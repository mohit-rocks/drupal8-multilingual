<?php

namespace Drupal\umami_multilingual;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Recipe review entities.
 *
 * @ingroup umami_multilingual
 */
class RecipeReviewListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Recipe review ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\umami_multilingual\Entity\RecipeReview $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.recipe_review.edit_form',
      ['recipe_review' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
