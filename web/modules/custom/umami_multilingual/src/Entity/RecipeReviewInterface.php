<?php

namespace Drupal\umami_multilingual\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Recipe review entities.
 *
 * @ingroup umami_multilingual
 */
interface RecipeReviewInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Recipe review name.
   *
   * @return string
   *   Name of the Recipe review.
   */
  public function getName();

  /**
   * Sets the Recipe review name.
   *
   * @param string $name
   *   The Recipe review name.
   *
   * @return \Drupal\umami_multilingual\Entity\RecipeReviewInterface
   *   The called Recipe review entity.
   */
  public function setName($name);

  /**
   * Gets the Recipe review creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Recipe review.
   */
  public function getCreatedTime();

  /**
   * Sets the Recipe review creation timestamp.
   *
   * @param int $timestamp
   *   The Recipe review creation timestamp.
   *
   * @return \Drupal\umami_multilingual\Entity\RecipeReviewInterface
   *   The called Recipe review entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Recipe review revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Recipe review revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\umami_multilingual\Entity\RecipeReviewInterface
   *   The called Recipe review entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Recipe review revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Recipe review revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\umami_multilingual\Entity\RecipeReviewInterface
   *   The called Recipe review entity.
   */
  public function setRevisionUserId($uid);

}
