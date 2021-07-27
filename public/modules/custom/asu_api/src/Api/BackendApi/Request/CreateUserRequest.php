<?php

namespace Drupal\asu_api\Api\BackendApi\Request;

use Drupal\asu_api\Api\BackendApi\Response\UserResponse;
use Drupal\asu_api\Api\Request;
use Drupal\asu_api\Api\Response;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\UserInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Create user request.
 */
class CreateUserRequest extends Request {
  protected const METHOD = 'POST';

  protected const PATH = '/v1/profiles/';

  protected const AUTHENTICATED = FALSE;

  /**
   * Current user.
   *
   * @var \Drupal\user\UserInterface
   */
  private UserInterface $user;

  private FormStateInterface $form_state;

  /**
   * Construct.
   *
   * @param Drupal\user\UserInterface $user
   *   Current user.
   */
  public function __construct(UserInterface $user, FormStateInterface $form_state) {
    $this->user = $user;
    $this->form_state = $form_state;
  }

  /**
   * Data to array.
   */
  public function toArray(): array {
    $config = \Drupal::config('asu_user.external_user_fields');
    $fieldMap = $config->get('external_data_map');

    $data = [
      'id' => $this->user->uuid(),
      'email' => $this->user->getEmail(),
    ];

    foreach ($fieldMap as $field => $information) {
      $data[$information['external_field']] = $this->form_state->getValue($field);
    }

    $dateOfBirth = (new \DateTime($this->user->date_of_birth->value))->format('Y-m-d');
    $data['date_of_birth'] = $dateOfBirth;
    // @todo Remove right of residence.
    $data['right_of_residence'] = '1000';
    $data['contact_language'] = $this->user->getPreferredLangcode();

    return $data;
  }
}
