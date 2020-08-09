<?php

namespace Drupal\umami_multilingual\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a Recipe review revision.
 *
 * @ingroup umami_multilingual
 */
class RecipeReviewRevisionDeleteForm extends ConfirmFormBase {

  /**
   * The Recipe review revision.
   *
   * @var \Drupal\umami_multilingual\Entity\RecipeReviewInterface
   */
  protected $revision;

  /**
   * The Recipe review storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $recipeReviewStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->recipeReviewStorage = $container->get('entity_type.manager')->getStorage('recipe_review');
    $instance->connection = $container->get('database');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'recipe_review_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the revision from %revision-date?', [
      '%revision-date' => format_date($this->revision->getRevisionCreationTime()),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.recipe_review.version_history', ['recipe_review' => $this->revision->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $recipe_review_revision = NULL) {
    $this->revision = $this->RecipeReviewStorage->loadRevision($recipe_review_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->RecipeReviewStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')->notice('Recipe review: deleted %title revision %revision.', ['%title' => $this->revision->label(), '%revision' => $this->revision->getRevisionId()]);
    $this->messenger()->addMessage(t('Revision from %revision-date of Recipe review %title has been deleted.', ['%revision-date' => format_date($this->revision->getRevisionCreationTime()), '%title' => $this->revision->label()]));
    $form_state->setRedirect(
      'entity.recipe_review.canonical',
       ['recipe_review' => $this->revision->id()]
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {recipe_review_field_revision} WHERE id = :id', [':id' => $this->revision->id()])->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.recipe_review.version_history',
         ['recipe_review' => $this->revision->id()]
      );
    }
  }

}
