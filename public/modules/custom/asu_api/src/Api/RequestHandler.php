<?php

namespace Drupal\asu_api\Api;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Handles requests.
 */
class RequestHandler {

  /**
   * Guzzle http-client.
   *
   * @var \GuzzleHttp\Client
   */
  private $client;

  /**
   * Api url.
   *
   * @var string
   */
  private $apiUrl;

  /**
   * Constructor.
   */
  public function __construct(string $apiUrl) {
    $this->apiUrl = $apiUrl;
    $this->client = \Drupal::httpClient();
  }

  /**
   * Send request.
   */
  public function send(RequestInterface $request): ResponseInterface {
    $options = [];
    return $this->client->send($request, $options);
  }

}
