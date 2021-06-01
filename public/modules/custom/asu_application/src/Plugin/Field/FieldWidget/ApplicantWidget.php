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

    $form['#attached']['library'][] = 'asu_application/additional-applicant';

    $element['has_additional_applicant'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Add additional applicant'),
      '#attributes' => ['id' => 'has-additional-applicant']
    ];

    $element['applicant_prefix'] = [
      '#type' => 'markup',
      '#markup' => '<div id="applicant-wrapper">'
    ];

    $element['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First name'),
      '#size' => 100,
      '#default_value' => isset($items->getValue()[$delta]['first_name']) ? $items->getValue()[$delta]['first_name'] : '',
    ];

    $element['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last name'),
      '#size' => 100,
      '#default_value' => isset($items->getValue()[$delta]['last_name']) ? $items->getValue()[$delta]['last_name'] : '',
    ];

    $element['date_of_birth'] = [
      '#type' => 'date',
      '#title' => $this->t('Date of birth'),
      '#size' => 30,
      '#default_value' => isset($items->getValue()[$delta]['date_of_birth']) ? $items->getValue()[$delta]['date_of_birth'] : '',
    ];

    $element['street_address'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Street address'),
      '#size' => 100,
      '#default_value' => isset($items->getValue()[$delta]['street_address']) ? $items->getValue()[$delta]['street_address'] : '',
    ];

    $element['Postal code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Postal code'),
      '#size' => 50,
      '#default_value' => isset($items->getValue()[$delta]['postal_code']) ? $items->getValue()[$delta]['postal_code'] : '',
    ];

    $element['City'] = [
      '#type' => 'email',
      '#title' => $this->t('city'),
      '#size' => 50,
      '#default_value' => isset($items->getValue()[$delta]['city']) ? $items->getValue()[$delta]['city'] : '',
    ];

    $element['Phone number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('phone_number'),
      '#size' => 20,
      '#default_value' => isset($items->getValue()[$delta]['phone_number']) ? $items->getValue()[$delta]['phone_number'] : '',
    ];

    $element['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#size' => 50,
      '#default_value' => isset($items->getValue()[$delta]['email']) ? $items->getValue()[$delta]['email'] : '',
    ];

    $element['applicant_suffix'] = [
      '#type' => 'markup',
      '#markup' => '</div>'
    ];

    return $element;
  }

}
