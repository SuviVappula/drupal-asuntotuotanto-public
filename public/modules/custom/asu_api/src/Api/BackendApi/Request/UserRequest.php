<?php

namespace Drupal\asu_api\Api\BackendApi\Request;

use Drupal\asu_api\Api\Request;
use Drupal\user\UserInterface;

/**
 *
 */
class UserRequest extends Request {

  protected const METHOD = '';
  protected const PATH = '';

  private UserInterface $user;

  /**
   *
   */
  public function __construct(UserInterface $user) {
    $this->user = $user;
  }

  /**
   *
   */
  public function toArray(): array {
    return ['id' => $this->user->uuid()];
  }

}
