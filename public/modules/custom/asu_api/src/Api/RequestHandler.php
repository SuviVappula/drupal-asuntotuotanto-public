<?php

namespace Drupal\asu_api\Api;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Drupal\asu_api\Api\Request as RequestDto;

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
   *
   * @param \GuzzleHttp\Psr7\RequestInterface $request
   *   Request.
   * @param array $options
   *   Options.
   *
   * @return \Psr\Http\Message\ResponseInterface
   *   Response interface.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function send(RequestInterface $request, array $options = []): ResponseInterface {
    return $this->client->send($request, $options);
  }

  /**
   * Build request to be sent.
   *
   * @param \Drupal\asu_api\Api\Request $request
   *   Request.
   *
   * @return \GuzzleHttp\Psr7\RequestInterface
   *   Request to send.
   */
  public function buildRequest(RequestDto $request): RequestInterface {
    $method = $request->getMethod();
    $uri = "{$this->apiUrl}/{$request->getPath()}";
    $payload = $request->toArray();
    return new Request(
      $method,
      $uri,
      ['Content-Type' => 'application/json'],
      json_encode($payload)
    );
  }

}
