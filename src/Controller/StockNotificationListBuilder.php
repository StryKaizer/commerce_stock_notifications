<?php

namespace Drupal\commerce_stock_notifications\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for stock_notification entity.
 */
class StockNotificationListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the contact list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['id'] = $this->t('Id');
    $header['email'] = $this->t('Email');
    $header['langcode'] = $this->t('Language code');
    $header['product_id'] = $this->t('Product variation');
    $header['created'] = $this->t('Created');
    $header['sent_time'] = $this->t('Sent time');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['id'] = $entity->id();
    $row['email'] = $entity->email->value;
    $row['langcode'] = $entity->langcode->value;
    $row['product_id'] = $entity->product_id->target_id;
    $row['created'] = $entity->created->value;
    $row['sent_time'] = $entity->sent_time->value;
    return $row + parent::buildRow($entity);
  }

}
