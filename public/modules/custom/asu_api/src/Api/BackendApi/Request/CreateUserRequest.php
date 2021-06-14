<?php

namespace Drupal\asu_api\Api\BackendApi\Request;

use Drupal\asu_api\Api\Request;
use Drupal\user\UserInterface;

/**
 * Create user request.
 */
class CreateUserRequest extends Request {

  protected const METHOD = 'POST';

  protected const PATH = 'v1/profiles/';

  protected const AUTHENTICATED = FALSE;

  /**
   * Current user.
   *
   * @var \Drupal\user\UserInterface
   */
  private UserInterface $user;

  /**
   * Construct.
   *
   * @param Drupal\user\UserInterface $user
   *   Current user.
   */
  public function __construct(UserInterface $user) {
    $this->user = $user;
  }

  /**
   * Data to array.
   */
  public function toArray(): array {
    $dateOfBirth = (new \DateTime($this->user->field_date_of_birth->value))->format('Y-m-d');
    return [
      'id' => $this->user->uuid(),
      'first_name' => $this->user->field_first_name->value,
      'last_name' => $this->user->field_last_name->value,
      'email' => $this->user->getEmail(),
      'phone_number' => $this->user->field_phone_number->value,
      'date_of_birth' => $dateOfBirth,
      'city' => $this->user->field_city->value,
      'postal_code' => (string) $this->user->field_postal_code->value,
      'street_address' => $this->user->field_address->value,
      'right_of_residence' => "1000",
      'contact_language' => $this->user->getPreferredLangcode(),
    ];
  }

}
