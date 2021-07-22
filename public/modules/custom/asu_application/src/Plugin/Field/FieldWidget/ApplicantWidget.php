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
      '#attributes' => ['id' => 'has-additional-applicant'],
    ];

    $element['applicant_prefix'] = [
      '#type' => 'markup',
      '#markup' => '<div id="applicant-wrapper" class="application-form__applicant-form">',
    ];

    $element['application_information_prefix'] = [
      '#type' => 'markup',
      '#markup' => '<div class="application-form__application-information">',
    ];

    $element['application_information_tooltip'] = [
      '#type' => 'markup',
      '#markup' => '<p class="application-form__application-information-tooltip">'. $this->t('
      This applicant cannot complete another application for the same item.') .'</p>',
    ];

    $element['application_information_text'] = [
      '#type' => 'markup',
      '#markup' => '<p>' . $this->t('
      If there are more than one buyer, they must all be notified as applicants now - <strong>buyers can no longer be added afterwards</strong>. Applicant also means applicant economy (persons registered at the same address). Spouses registered at a different address are also considered as applicant households. If you want more than one person to buy an apartment, mark them all as applicants.') . '</p>',
    ];

    $element['application_information_suffix'] = [
      '#type' => 'markup',
      '#markup' => '</div>',
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
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#size' => 50,
      '#default_value' => isset($items->getValue()[$delta]['city']) ? $items->getValue()[$delta]['city'] : '',
    ];

    $element['Phone number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone number'),
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
      '#markup' => '</div>',
    ];

    return $element;
  }

}
