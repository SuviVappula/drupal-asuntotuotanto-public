<?php

namespace Drupal\asu_api\Api;

use Psr\Http\Message\ResponseInterface;

/**
 * Base class for responses.
 */
class Response {

  protected array $content;

  /**
   * Constructor.
   */
  public function __construct(array $content) {
    $this->content = $content;
  }

  /**
   * @return array
   */
  public function getContent(): array {
    return $this->content;
  }

  /**
   * Create response object from http response.
   *
   * @param \Psr\Http\Message\ResponseInterface $response
   *
   * @return static
   */
  public static function createFromHttpResponse(ResponseInterface $response): self {
    if (!static::requestOk($response)) {
      throw new RequestException('Bad status code: ' . $response->getStatusCode());
    }
    $content = json_decode($response->getBody()->getContents(), TRUE);
    return new self($content);
  }

  /**
   * Check that http status code is 200.
   *
   * @param \Psr\Http\Message\ResponseInterface $response
   *
   * @return bool
   */
  public static function requestOk(ResponseInterface $response) {
    return $response->getStatusCode() <= 200 && $response->getStatusCode() > 300;
  }

}
