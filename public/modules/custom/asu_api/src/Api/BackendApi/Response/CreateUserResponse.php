<?php

namespace Drupal\asu_api\Api\BackendApi\Response;

use Drupal\asu_api\Api\Response;
use Drupal\asu_api\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * Response for user creation request.
 */
class CreateUserResponse extends Response {

  /**
   * Constructor.
   *
   * @param object $content
   *   Contents of the response.
   */
  public function __construct(array $content) {
    // @todo Set content as attributes and create setters.
    $this->content = $content;
  }
}
