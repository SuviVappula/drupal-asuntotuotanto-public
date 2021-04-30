<?php

namespace Drupal\asu_api\Api\BackendApi\Response;

use Drupal\asu_api\Api\Response;
use Drupal\asu_api\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * Response for user creation request.
 */
class UserResponse extends Response {
  /**
   * Constructor.
   * @param array $content
   */
  public function __construct(array $content) {
    //@todo: Create setters and getters.
    parent::__construct($content);
  }
}
