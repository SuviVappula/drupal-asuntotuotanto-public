<?php

namespace Drupal\asu_api\Api\BackendApi\Request;

use Drupal\asu_api\Api\Request;
use Drupal\user\Entity\User;

/**
 * Request user information from backend.
 */
class UserRequest extends Request {

  protected const METHOD = 'GET';
  protected const PATH = 'v1/profiles/';

  private User $user;

  /**
   * Constructor.
   */
  public function __construct(User $user) {
    $this->user = $user;
  }

  /**
   * User request data to array.
   */
  public function toArray(): array {
    return ['id' => $this->user->uuid()];
  }

}
