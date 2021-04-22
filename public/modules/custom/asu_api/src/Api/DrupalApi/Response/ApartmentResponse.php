<?php

namespace Drupal\asu_api\Api\DrupalApi\Response;

use Drupal\asu_api\Api\Response;
use Psr\Http\Message\ResponseInterface;

class ApartmentResponse extends Response {

  private array $content;

  /**
   * Constructor.
   */
  public function __construct(array $content) {
    $this->content = $content;
  }

  public function getContent(): array {
    return $this->content;
  }

  public static function createFromHttpResponse(ResponseInterface $response): Response {
    parent::requestOk($response);
    $content = json_decode($response->getBody()->getContents(), TRUE);
    return new self($content);
  }


}
