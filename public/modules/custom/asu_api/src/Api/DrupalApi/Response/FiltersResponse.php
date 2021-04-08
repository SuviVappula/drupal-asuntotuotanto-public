<?php

namespace Drupal\asu_api\Api\DrupalApi\Response;

use Psr\Http\Message\ResponseInterface;

/**
 *
 */
class FiltersResponse {

  private \StdClass $content;

  /**
   *
   */
  public function __construct($content) {
    // @todo Set content as attributes and create setters.
    $this->content = $content;
  }

  /**
   *
   */
  public function getContent() {
    return $this->content;
  }

  /**
   *
   */
  public static function createFromHttpResponse(ResponseInterface $response) {
    if ($response->getStatusCode() !== 200) {
      throw new \Exception('Bad status code: ' . $response->getStatusCode());
    }
    $content = json_decode($response->getBody()->getContents(), FALSE);
    return new self($content);
  }

}
