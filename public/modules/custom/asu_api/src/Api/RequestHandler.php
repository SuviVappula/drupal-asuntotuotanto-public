<?php

namespace Drupal\asu_api\Api;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;

/**
 * Handles requests.
 */
class RequestHandler {
  /**
   * Guzzle http-client.
   *
   * @var \GuzzleHttp\Client
   */
  private Client $client;

  /**
   * Api url.
   *
   * @var string
   */
  private string $apiUrl;

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
   * Send http client post request.
   *
   * @param string $endpoint
   *   Api endpoint.
   * @param array $options
   *   Request options.
   *
   * @return \Psr\Http\Message\ResponseInterface
   *   Http response.
   */
  public function post(string $endpoint, array $options): ResponseInterface {
    $url = $this->apiUrl . $endpoint;
    return $this->client->post($url, $options);
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
  public function buildRequest(\Drupal\asu_api\Api\Request $request): RequestInterface {
    $method = $request->getMethod();
    $uri = "{$this->apiUrl}{$request->getPath()}";
    $payload = $request->toArray();
    return new Request(
      $method,
      $uri,
      ['Content-Type' => 'application/json'],
      json_encode($payload)
    );
  }

  /**
   *
   */
  public function buildAuthenticatedRequest(\Drupal\asu_api\Api\Request $request, string $profileId, string $token): RequestInterface {
    $method = $request->getMethod();
    $uri = "{$this->apiUrl}{$request->getPath()}$profileId/";
    $payload = $request->toArray();
    $headers = [
      'Content-Type' => 'application/json',
      'Authorization' => 'Bearer ' . $token,
    ];
    return new Request(
      $method,
      $uri,
      $headers,
      json_encode($payload)
    );
  }

}
