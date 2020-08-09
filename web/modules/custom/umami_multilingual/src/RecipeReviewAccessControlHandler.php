<?php

namespace Drupal\umami_multilingual;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Recipe review entity.
 *
 * @see \Drupal\umami_multilingual\Entity\RecipeReview.
 */
class RecipeReviewAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\umami_multilingual\Entity\RecipeReviewInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished recipe review entities');
        }

        return AccessResult::allowedIfHasPermission($account, 'view published recipe review entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit recipe review entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete recipe review entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add recipe review entities');
  }

}
