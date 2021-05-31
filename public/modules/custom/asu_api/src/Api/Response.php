<?php

namespace Drupal\asu_api\Api;

use Psr\Http\Message\ResponseInterface;

/**
 * The request class.
 */
abstract class Response {

  abstract static function createFromHttpResponse(ResponseInterface $response): Response;

  public function requestOk(ResponseInterface $response): bool {
    if ($response->getStatusCode() < 200 && $response->getStatusCode() > 299) {
      throw new \Exception('Bad status code: ' . $response->getStatusCode());
    }
    return true;
  }

}
