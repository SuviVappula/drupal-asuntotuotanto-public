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
   * Content.
   *
   * @var \StdClass
   */
  private \StdClass $content;

  /**
   * Constructor.
   *
   * @param object $content
   *   Contents of the response.
   */
  public function __construct(\stdClass $content) {
    // @todo Set content as attributes and create setters.
    $this->content = $content;
  }

  /**
   * Get request content.
   */
  public function getContent() {
    return $this->content;
  }

  /**
   * Create new user response from http response.
   *
   * @param \Psr\Http\Message\ResponseInterface $response
   *   Guzzle response.
   *
   * @return CreateUserResponse
   *   CreateUserResponse.
   *
   * @throws \Exception
   */
  public static function createFromHttpResponse(ResponseInterface $response): self {
    if (self::requestOk($response)) {
      throw new RequestException('Bad status code: ' . $response->getStatusCode());
    }
    $content = json_decode($response->getBody()->getContents(), FALSE);
    return new self($content);
  }

}
