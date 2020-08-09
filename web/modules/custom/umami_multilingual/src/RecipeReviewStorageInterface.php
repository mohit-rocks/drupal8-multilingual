<?php

namespace Drupal\umami_multilingual;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface RecipeReviewStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Recipe review revision IDs for a specific Recipe review.
   *
   * @param \Drupal\umami_multilingual\Entity\RecipeReviewInterface $entity
   *   The Recipe review entity.
   *
   * @return int[]
   *   Recipe review revision IDs (in ascending order).
   */
  public function revisionIds(RecipeReviewInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Recipe review author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Recipe review revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\umami_multilingual\Entity\RecipeReviewInterface $entity
   *   The Recipe review entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(RecipeReviewInterface $entity);

  /**
   * Unsets the language for all Recipe review with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
