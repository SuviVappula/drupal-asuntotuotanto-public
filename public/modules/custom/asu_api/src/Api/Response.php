<?php

namespace Drupal\asu_api\Api;

use Psr\Http\Message\ResponseInterface;

/**
 * The request class.
 */
abstract class Response {

  /**
   * Create response class from http client's response.
   */
  abstract public static function createFromHttpResponse(ResponseInterface $response): Response;

  /**
   * Check if request returns 2xx response.
   *
   * @param \Psr\Http\Message\ResponseInterface $response
   *   Guzzle http response.
   *
   * @return bool
   *   Is request 2xx.
   *
   * @throws \Exception
   */
  public static function requestOk(ResponseInterface $response): bool {
    if ($response->getStatusCode() < 200 && $response->getStatusCode() > 299) {
      throw new \Exception('Bad status code: ' . $response->getStatusCode());
    }
    return TRUE;
  }

}
