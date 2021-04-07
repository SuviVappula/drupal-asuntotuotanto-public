<?php

namespace Drupal\asu_api\Api;

use Drupal\asu_api\BackendApi\Request\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RequestHandler {

  /** @var \GuzzleHttp\Client */
  private $client;

  private $backendBaseUrl;

  public function __construct(string $backendBaseUrl) {
    $this->backendBaseUrl = $backendBaseUrl;
    $this->client = \Drupal::httpClient();
  }

  public function send(RequestInterface $request): ResponseInterface {
    $options = [];
    return $this->client->send($request, $options);
  }

}
