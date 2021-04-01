<?php

namespace Drupal\asu_application\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Plugin implementation of the applicant field widget.
*
* @FieldWidget(
*   id = "asu_applicant_widget",
*   label = @Translation("Asu applicant - Widget"),
*   description = @Translation("Asu applicant - Widget"),
*   field_types = {
*     "asu_applicant"
*   },
* )
*/

class ApplicantWidget extends WidgetBase {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return parent::defaultSettings();
  }

  /**
  * {@inheritdoc}
  */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    /*
    $element['wrap'] = [
      '#type',
      '#cardinality' => $this->fieldDefinition->getFieldStorageDefinition()->getCardinality(),
    ]
    */

    $element['name'] = [
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#size' => 255,
      '#default_value' => isset($items->getValue()[$delta]['name']) ? $items->getValue()[$delta]['name'] : '',
    ];

    $element['email'] = [
      '#type' => 'email',
      '#title' => t('Email'),
      '#size' => 255,
      '#default_value' => isset($items->getValue()[$delta]['email']) ? $items->getValue()[$delta]['email'] : '',
    ];

    //setting default value to all fields from above
    #$children = Element::children($element);
    #foreach ($children as $child) {
      #$element[$child]['#default_value'] = isset($items[$delta]->{$child}) ? $items[$delta]->{$child} : NULL;
    #}

    return $element;
  }

}
