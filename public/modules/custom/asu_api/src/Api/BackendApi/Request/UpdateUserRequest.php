<?php

namespace Drupal\asu_api\Api\BackendApi\Request;

use Drupal\asu_api\Api\Request;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\UserInterface;

/**
 * Update user information in backend.
 */
class UpdateUserRequest extends Request {

  protected const METHOD = 'PUT';

  protected const PATH = 'v1/profiles/';

  private FormStateInterface $formState;

  private array $fields;

  /**
   * Constructor.
   */
  public function __construct(UserInterface $user, FormStateInterface $formState, array $fields) {
    $this->formState = $formState;
    $this->fields = $fields;
    $this->user = $user;
  }

  /**
   * Update user request data to array.
   */
  public function toArray(): array {
    $data = [];
    foreach ($this->fields as $fieldName => $fieldInformation) {
      $data[$fieldInformation['external_field']] = $this->formState->getValue($fieldName);
    }

    $data['id'] = $this->user->uuid();
    $data['email'] = $this->user->getEmail();
    $data['contact_language'] = $this->user->getPreferredLangcode();

    return $data;
  }

}
