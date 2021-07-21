<?php

namespace Drupal\asu_api\Api\AskoApi\Request;

use Drupal\asu_application\Entity\Application;
use Drupal\user\Entity\User;

/**
 *
 */
class AskoApplicationRequest {

  private const YES = 'kylla';

  private const NO = 'ei';

  private const SENIOR = 55;

  private User $user;

  private Application $application;

  private string $projectName;

  /**
   * Constructor.
   */
  public function __construct(User $user, Application $application, string $projectName) {
    $this->user = $user;
    $this->application = $application;
    $this->projectName = $projectName;
  }

  /**
   * Application request data to array.
   *
   * @return array
   *
   * @throws \Exception
   */
  public function toArray(): array {
    $date = new \DateTime($this->user->field_date_of_birth->value);
    $data = [
      'etunimi' => $this->user->field_first_name->value,
      'sukunimi' => $this->user->field_last_name->value,
      'syntyma-aika' => $date->format('d.m.Y'),
      'hetuloppu' => $this->application->field_personal_id->value,
      'osoite' => $this->user->field_address->value,
      'postinumero' => $this->user->field_postal_code->value,
      'postitoimipaikka' => $this->user->field_city->value,
      'puhelin' => $this->user->field_phone_number->value,
      'email' => $this->user->getEmail(),
      'etunimi2' => '',
      'sukunimi2' => '',
      'syntyma-aika2' => '',
      'hetuloppu2' => '',
      'osoite2' => '',
      'postinumero2' => '',
      'postitoimipaikka2' => '',
      'puhelin2' => '',
      'email2' => '',
      'kohde' => $this->projectName,
      'huoneistonumero' => $this->getApartmentNumbers(),
      // Haso only.
      'jarjestysnumero' => '',
      '55_vuotias' => '',
      'ason_vaihtaja' => '',
      // Hitas only.
      'hitasomistus' => '',
      'lapsiperhe' => '',
      'lapsi1' => ''
    ];

    if ($this->application->hasAdditionalApplicant()) {
      $applicant = $this->getAdditionalApplicant();
      $data['etunimi2'] = $applicant['first_name'];
      $data['sukunimi2'] = $applicant['last_name'];
      $date2 = new \DateTime($applicant['date_of_birth']);
      $data['syntyma-aika2'] = $date2->format('d.m.Y');
      $data['hetuloppu2'] = $this->application->field_personal_id->value;
      $data['osoite2'] = $applicant['street_address'];
      $data['postinumero2'] = $applicant['postal_code'];
      $data['postitoimipaikka2'] = $applicant['city'];
      $data['puhelin2'] = $applicant['phone_number'];
      $data['email2'] = $applicant['email'];
    }

    if ($this->application->bundle() == 'hitas') {
      $data['hitasomistus'] = $this->userIsHitasOwner();
      $data['lapsiperhe'] = $this->userHasChildren();
      $data['lapsi1'] = '';
      unset($data['jarjestysnumero']);
      unset($data['55_vuotias']);
      unset($data['ason_vaihtaja']);
    }

    if ($this->application->bundle() == 'haso') {
      $data['jarjestysnumero'] = $this->application->field_right_of_residence_number->value;
      $data['55_vuotias'] = $this->userIsSenior();
      $data['ason_vaihtaja'] = $this->userIsAsoChanger();
      unset($data['hitasomistus']);
      unset($data['lapsiperhe']);
      unset($data['lapsi1']);
    }

    return $data;
  }

  /**
   * Return request data formatted for email.
   *
   * @return string
   */
  public function toMailFormat(): string {
    $body = '';
    foreach ($this->toArray() as $key => $value) {
      $body .= "$key: $value" . PHP_EOL;
    }
    return $body;
  }

  /**
   * Is user a senior.
   *
   * @return string
   *   Boolean as enum.
   *
   * @throws \Exception
   */
  private function userIsSenior(): string {
    $birthday = new \DateTime($this->user->field_date_of_birth->value);
    return $this::SENIOR <= $birthday->diff(new \DateTime('NOW'))->y ? $this::YES : $this::NO;
  }

  /**
   * Is user an aso changer.
   *
   * @return string
   *   Boolean as enum.
   */
  private function userIsAsoChanger(): string {
    return $this->application->field_aso_changer->value ? $this::YES : $this::NO;
  }

  private function userIsHitasOwner() : string {
    return $this->application->field_hitas_owner->value;
  }

  private function userHasChildren() : string  {
    return $this->application->getHasChildren() ? $this::YES : $this::NO;
  }

  /**
   * Get selected apartments as comma separated string.
   *
   * @return string
   */
  private function getApartmentNumbers(): string {
    $apartments = $this->application->getApartments();
    $values = [];
    foreach ($apartments as $key => $apartment) {
      $array = explode(' ', $apartment->information);
      $values[] = end($array);
    }
    return implode(',', $values);
  }

  /**
   * Get additional applicant.
   *
   * @return array
   *  Additional applicants.
   */
  private function getAdditionalApplicant(): ?array {
    $applicants = $this->application->getApplicants();
    if(!empty($applicants)){
      return $applicants[0];
    }
    return false;
  }

}
