<?php

namespace Drupal\asu_application\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Provides a field type of applicant.
 *
 * @FieldType(
 *   id = "asu_applicant",
 *   label = @Translation("Applicant"),
 *   description = @Translation("Additional applicants for application"),
 *   default_formatter = "asu_applicant_formatter",
 *   default_widget = "asu_applicant_widget",
 * )
 */
class ApplicantFieldItem extends FieldItemBase implements FieldItemInterface {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'name' => [
          'type' => 'varchar',
          'length' => 255,
          'default' => '',
          // 'not_null' => FALSE,
        ],
        'email' => [
          'type' => 'varchar',
          'length' => 255,
          'default' => '',
          // 'not_null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = [];
    $properties['name'] = DataDefinition::create('string')
      ->setLabel(t('Name'));
    $properties['email'] = DataDefinition::create('email')
      ->setLabel(t('Email address'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return $this->name === NULL || $this->name === '';
  }

}
