<?php

namespace Drupal\umami_multilingual\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Recipe review entities.
 */
class RecipeReviewViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
