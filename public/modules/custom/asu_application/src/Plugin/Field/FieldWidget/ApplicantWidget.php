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
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#size' => 255,
      '#default_value' => isset($items->getValue()[$delta]['name']) ? $items->getValue()[$delta]['name'] : '',
    ];

    $element['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#size' => 255,
      '#default_value' => isset($items->getValue()[$delta]['email']) ? $items->getValue()[$delta]['email'] : '',
    ];

    return $element;
  }

}
