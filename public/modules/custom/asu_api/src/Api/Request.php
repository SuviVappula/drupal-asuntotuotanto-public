<?php

namespace Drupal\asu_api\Api;

/**
 * Request class.
 */
abstract class Request {

  protected const METHOD = 'GET';
  protected const PATH = '';

  /**
   * Gets the HTTP method.
   *
   * @return string
   *   The HTTP method.
   */
  public function getMethod(): string {
    return static::METHOD;
  }

  /**
   * Gets the request path.
   *
   * For example /prices.
   *
   * @return string
   *   The path.
   */
  public function getPath(): string {
    if (!static::PATH) {
      throw new \LogicException('Missing path.');
    }
    return static::PATH;
  }

  /**
   * Gets the request data.
   *
   * @return array
   *   The request.
   */
  abstract public function toArray(): array;

}
