<?php

namespace Drupal\asu_api\Api\DrupalApi\Service;

use Drupal\asu_api\Api\BackendApi\Response\ApplicationResponse;
use Drupal\asu_api\Api\DrupalApi\Request\ApplicationRequest;
use Drupal\asu_api\Api\RequestHandler;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Application service.
 */
class ApplicationService {
  /**
   * Request handler.
   *
   * @var \Drupal\asu_api\Api\RequestHandler
   */
  private RequestHandler $requestHandler;

  /**
   * Constructor.
   */
  public function __construct(RequestHandler $requestHandler) {
    $this->requestHandler = $requestHandler;
  }

  /**
   * Send application.
   *
   * @param \Drupal\asu_api\Api\DrupalApi\Request\ApplicationRequest $request
   *   ApplicationRequest.
   *
   * @return \Drupal\asu_api\Api\BackendApi\Response\ApplicationResponse
   *   ApplicationResponse.
   *
   * @throws \Exception
   */
  public function sendApplication(ApplicationRequest $request) {
    $httpRequest = $this->requestHandler->buildRequest($request);
    // $httpRequest = $this->buildRequest($request);
    $response = $this->requestHandler->send($httpRequest);
    return ApplicationResponse::createFromHttpResponse($response);
  }

  /**
   * Build request for application.
   *
   * @param \Drupal\asu_api\Api\DrupalApi\Request\ApplicationRequest $request
   *   ApplicationRequest.
   *
   * @return \GuzzleHttp\Psr7\RequestInterface
   *   GuzzleRequest.
   */
  private function buildRequest(ApplicationRequest $request): RequestInterface {
    $payload = $request->toArray();
    // Return $this->requestHandler->buildRequest()
    return new Request(
      $request->getMethod(),
      $request->getPath(),
      ['Content-Type' => 'application/json'],
      json_encode($payload)
    );
  }

}
