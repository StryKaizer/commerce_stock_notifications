<?php

namespace Drupal\commerce_stock_notifications;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\search_api\Query\QueryInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for commerce stock notification entities.
 */
interface StockNotificationInterface extends ContentEntityInterface, EntityOwnerInterface {


}
