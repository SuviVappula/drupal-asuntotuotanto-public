<?php

namespace Drupal\asuntotuotanto_public\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\StringItem;

/**
 * Variant of the 'link' field that links to the current company.
 *
 * @FieldType(
 *   id = "asu_external_string",
 *   label = @Translation("External string"),
 *   description = @Translation("External string as a field value."),
 *   default_widget = "string_textfield",
 *   default_formatter = "string",
 * )
 */
class AsuExternalString extends StringItem {
  /**
   * Whether or not the value has been calculated.
   *
   * @var bool
   */
  protected $isCalculated = FALSE;

  /**
   * {@inheritdoc}
   */
  public function __get($name) {
    $this->ensureCalculated();
    return parent::__get($name);
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $this->ensureCalculated();
    // Return parent::isEmpty();
  }

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    $this->ensureCalculated();
    return parent::getValue();
  }

  /**
   * Calculates the value of the field and sets it.
   */
  protected function ensureCalculated() {
    if (!$this->isCalculated) {
      $name = $this->getFieldDefinition()->getFieldStorageDefinition()->getName();
      $store = \Drupal::service('asuntotuotanto_public.tempstore');
      $dataMap = \Drupal::config('asuntotuotanto_public.external_user_fields')->get('external_data_map');

      if (isset($dataMap[$name])) {
        $this->setValue([
          'value' => $store->get($dataMap[$name]['external_field']),
        ]);
      }
      else {
        $this->setValue([
          'value' => '',
        ]);
      }
      $this->isCalculated = TRUE;
    }
  }

  /**
   *
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [];
  }

}
