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

  protected const PATH = 'api/v1/create_user';

  private UserInterface $user;

  private FormStateInterface $form_state;

  /**
   * Construct.
   */
  public function __construct(UserInterface $user, FormStateInterface $form_state) {
    $this->user = $user;
    $this->form_state = $form_state;
  }

  /**
   * Data to array.
   */
  public function toArray(): array {
    $config = \Drupal::config('asuntotuotanto_public.external_user_fields');
    $fieldMap = $config->get('external_data_map');

    $data = [
      'uuid' => $this->user->uuid(),
      'username' => $this->user->getEmail(),
    ];

    // @todo: Make sure field is always up to date.
    foreach ($fieldMap as $field => $information) {
      $data[$information['external_field']] = $this->form_state->getValue($field);
    }

    return $data;
  }

  /**
   *
   */
  public static function createResponse(ResponseInterface $response): Response {
    if (!static::requestOk($response)) {
      throw new RequestException('Bad status code: ' . $response->getStatusCode());
    }
    $content = json_decode($response->getBody()->getContents(), TRUE);
    return new UserResponse($content);
  }

}
