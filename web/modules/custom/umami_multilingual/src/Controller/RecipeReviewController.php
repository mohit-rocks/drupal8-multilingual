<?php

namespace Drupal\umami_multilingual\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\umami_multilingual\Entity\RecipeReviewInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RecipeReviewController.
 *
 *  Returns responses for Recipe review routes.
 */
class RecipeReviewController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->dateFormatter = $container->get('date.formatter');
    $instance->renderer = $container->get('renderer');
    return $instance;
  }

  /**
   * Displays a Recipe review revision.
   *
   * @param int $recipe_review_revision
   *   The Recipe review revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($recipe_review_revision) {
    $recipe_review = $this->entityTypeManager()->getStorage('recipe_review')
      ->loadRevision($recipe_review_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('recipe_review');

    return $view_builder->view($recipe_review);
  }

  /**
   * Page title callback for a Recipe review revision.
   *
   * @param int $recipe_review_revision
   *   The Recipe review revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($recipe_review_revision) {
    $recipe_review = $this->entityTypeManager()->getStorage('recipe_review')
      ->loadRevision($recipe_review_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $recipe_review->label(),
      '%date' => $this->dateFormatter->format($recipe_review->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Recipe review.
   *
   * @param \Drupal\umami_multilingual\Entity\RecipeReviewInterface $recipe_review
   *   A Recipe review object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(RecipeReviewInterface $recipe_review) {
    $account = $this->currentUser();
    $recipe_review_storage = $this->entityTypeManager()->getStorage('recipe_review');

    $langcode = $recipe_review->language()->getId();
    $langname = $recipe_review->language()->getName();
    $languages = $recipe_review->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $recipe_review->label()]) : $this->t('Revisions for %title', ['%title' => $recipe_review->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all recipe review revisions") || $account->hasPermission('administer recipe review entities')));
    $delete_permission = (($account->hasPermission("delete all recipe review revisions") || $account->hasPermission('administer recipe review entities')));

    $rows = [];

    $vids = $recipe_review_storage->revisionIds($recipe_review);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\umami_multilingual\RecipeReviewInterface $revision */
      $revision = $recipe_review_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $recipe_review->getRevisionId()) {
          $link = $this->l($date, new Url('entity.recipe_review.revision', [
            'recipe_review' => $recipe_review->id(),
            'recipe_review_revision' => $vid,
          ]));
        }
        else {
          $link = $recipe_review->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.recipe_review.translation_revert', [
                'recipe_review' => $recipe_review->id(),
                'recipe_review_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.recipe_review.revision_revert', [
                'recipe_review' => $recipe_review->id(),
                'recipe_review_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.recipe_review.revision_delete', [
                'recipe_review' => $recipe_review->id(),
                'recipe_review_revision' => $vid,
              ]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['recipe_review_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
