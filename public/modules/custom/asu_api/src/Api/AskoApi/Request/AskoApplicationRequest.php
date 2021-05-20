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
   * Application request to array.
   *
   * @return array
   *
   * @throws \Exception
   */
  public function toArray(): array {
    $data = [
      'etunimi' => $this->user->field_first_name->value,
      'sukunimi' => $this->user->field_last_name->value,
      'email' => $this->user->getEmail(),
      'kohde' => $this->projectName,
      'huoneistonumero' => $this->getApartmentNumbers(),
    ];

    if ($this->application->bundle() == 'haso') {
      $data['jarjestysnumero'] = $this->application->field_right_of_residence_number->value;
      $data['55_vuotias'] = $this->userIsSenior();
      $data['ason_vaihtaja'] = $this->userIsAsoChanger();
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

}
