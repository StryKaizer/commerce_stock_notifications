<?php

namespace Drupal\commerce_stock_notifications\Entity;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides access checking for commerce stock notifications.
 */
class StockNotificationAccessControlHandler extends EntityAccessControlHandler {

  /**
   * Permission for administering stock notifications.
   */
  const ADMIN_PERMISSION = 'administer commerce stock notifications';


  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'create commerce stock notification');
  }

  /**
   * {@inheritdoc}
   *
   * Link the activities to the permissions. checkAccess is called with the
   * $operation as defined in the routing.yml file.
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, self::ADMIN_PERMISSION);

      case 'edit':
        return AccessResult::allowedIfHasPermission($account, self::ADMIN_PERMISSION);

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, self::ADMIN_PERMISSION);
    }
    return AccessResult::allowed();
  }


}
