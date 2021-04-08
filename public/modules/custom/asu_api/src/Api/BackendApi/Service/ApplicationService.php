<?php

namespace Drupal\asu_api\Api\BackendApi\Service;

use Drupal\asu_api\Api\BackendApi\Response\ApplicationResponse;
use Drupal\asu_api\Api\ServiceBase;
use Drupal\asu_api\BackendApi\Request\ApplicationRequest;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Handle requests and responses related to applications.
 */
class ApplicationService extends ServiceBase {

  /**
   * Send newly created application to backend.
   *
   * @param \Drupal\asu_api\BackendApi\Request\ApplicationRequest $request
   *   ApplicationRequest.
   *
   * @return \Drupal\asu_api\Api\BackendApi\Response\ApplicationResponse
   *   ApplicationResponse.
   *
   * @throws \Exception
   */
  public function sendApplication(ApplicationRequest $request) {
    $httpRequest = $this->buildRequest($request);
    $response = $this->requestHandler->send($httpRequest);
    return ApplicationResponse::createFromHttpResponse($response);
  }

  /**
   * Build request.
   *
   * @param \Drupal\asu_api\BackendApi\Request\ApplicationRequest $request
   *   ApplicationResponse.
   *
   * @return \GuzzleHttp\Psr7\RequestInterface
   *   GuzzleRequest.
   */
  private function buildRequest(ApplicationRequest $request): RequestInterface {
    $payload = $request->toArray();
    return new Request(
      $request->getMethod(),
      $request->getPath(),
      ['Content-Type' => 'application/json'],
      $payload
    );
  }

}
