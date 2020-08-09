<?php

namespace Drupal\umami_multilingual;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\umami_multilingual\Entity\RecipeReviewInterface;

/**
 * Defines the storage handler class for Recipe review entities.
 *
 * This extends the base storage class, adding required special handling for
 * Recipe review entities.
 *
 * @ingroup umami_multilingual
 */
class RecipeReviewStorage extends SqlContentEntityStorage implements RecipeReviewStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(RecipeReviewInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {recipe_review_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {recipe_review_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(RecipeReviewInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {recipe_review_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('recipe_review_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
