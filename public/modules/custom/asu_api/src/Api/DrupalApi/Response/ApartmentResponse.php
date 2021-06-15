<?php

namespace Drupal\asu_api\Api\DrupalApi\Response;

use Drupal\asu_api\Api\Response;
use Psr\Http\Message\ResponseInterface;

/**
 *
 */
class ApartmentResponse extends Response {

  private string $content;

  /**
   * Constructor.
   */
  public function __construct(string $content) {
    $this->content = $content;
  }

  /**
   *
   */
  public function getContent(): string {
    return $this->content;
  }

  /**
   *
   */
  public static function createFromHttpResponse(ResponseInterface $response): Response {
    parent::requestOk($response);
    $content = json_decode($response->getBody()->getContents(), TRUE);
    return new self($content);
  }

}
