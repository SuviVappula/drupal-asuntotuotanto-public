<?php

namespace Drupal\asu_api\Api\BackendApi\Response;

use Drupal\asu_api\Api\Response;
use Drupal\asu_api\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * Authentication response class.
 */
class AuthenticationResponse extends Response {

  /**
   * Token used in authenticated backend requests.
   *
   * @var string
   */
  private string $token;

  /**
   * Constructor.
   */
  public function __construct(\stdClass $content) {
    $this->token = $content->token;
  }

  /**
   * Get the token.
   */
  public function getToken() {
    return $this->token;
  }

  /**
   * {@inheritDoc}
   */
  public static function createFromHttpResponse(ResponseInterface $response): self {
    if (self::requestOk($response)) {
      throw new RequestException('Bad status code: ' . $response->getStatusCode());
    }
    $content = json_decode($response->getBody()->getContents(), FALSE);
    return new self($content);
  }

}
