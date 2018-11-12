<?php

namespace Drupal\commerce_stock_notifications\Entity;

use Drupal\commerce_stock_notifications\StockNotificationInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\UserInterface;

/**
 * Provides an entity type for commerce stock notifications.
 *
 * @ContentEntityType(
 *   id = "commerce_stock_notification",
 *   label = @Translation("Stock notification"),
 *   label_collection = @Translation("Stock notification"),
 *   label_singular = @Translation("stock notification"),
 *   label_plural = @Translation("stock notifications"),
 *   label_count = @PluralTranslation(
 *     singular = "@count stock notification",
 *     plural = "@count stock notifications"
 *   ),
 *   handlers = {
 *     "list_builder" =
 *   "Drupal\commerce_stock_notifications\Controller\StockNotificationListBuilder",
 *     "access" =
 *   "Drupal\commerce_stock_notifications\Entity\StockNotificationAccessControlHandler",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\Core\Entity\ContentEntityForm",
 *       "edit" = "Drupal\Core\Entity\ContentEntityForm",
 *       "delete" = "Drupal\commerce_stock_notifications\Form\StockNotificationDeleteForm",
 *     },
 *   },
 *   admin_permission = "administer commerce stock notifications",
 *   base_table = "commerce_stock_notification",
 *   data_table = "commerce_stock_notification_field_data",
 *   translatable = FALSE,
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "label" = "email",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *   },
 *   field_ui_base_route = "entity.commerce_stock_notification.edit_form",
 *   links = {
 *     "canonical" =
 *   "/commerce-stock-notifications/{commerce_stock_notification}",
 *     "edit-form" =
 *   "/commerce-stock-notifications/{commerce_stock_notification}/edit",
 *     "delete-form" =
 *   "/commerce-stock-notifications/{commerce_stock_notification}/delete",
 *   },
 * )
 */
class StockNotification extends ContentEntityBase implements StockNotificationInterface {

  /**
   * Static cache for property getters that take some computation.
   *
   * @var array
   */
  protected $cachedProperties = [];

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    /** @var \Drupal\Core\Field\BaseFieldDefinition[] $fields */
    $fields = parent::baseFieldDefinitions($entity_type);

    // Make the form display of the language configurable.
    $fields['langcode']->setDisplayConfigurable('form', TRUE);


    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Created by'))
      ->setDescription(t('The user who owns the commerce stock notification.'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback('Drupal\commerce_stock_notifications\Entity\StockNotification::getCurrentUserId')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created on'))
      ->setDescription(t('The time that the notification request was created.'))
      ->setDisplayOptions('view', [
        'type' => 'timestamp',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['sent_time'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Sent time'))
      ->setDescription(t('The date the promotion becomes valid.'))
      ->setRequired(FALSE)
      ->setSetting('datetime_type', 'datetime')
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 5,
      ]);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setDescription(t('Email address to notify.'))
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'email_default',
        'weight' => 1,
      ])
      ->setSetting('display_description', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['product_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Index ID'))
      ->setSetting('max_length', 50);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Product variation'))
      ->setDescription(t('The product variation which triggers the notification.'))
      ->setSetting('target_type', 'commerce_product_variation')
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => -1,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('uid', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('uid', $uid);
    return $this;
  }

  /**
   * Returns the default value for the "uid" base field definition.
   *
   * @return array
   *   An array with the default value.
   *
   * @see \Drupal\commerce_stock_notifications\Entity\StockNotification::baseFieldDefinitions()
   */
  public static function getCurrentUserId() {
    return [\Drupal::currentUser()->id()];
  }

}
