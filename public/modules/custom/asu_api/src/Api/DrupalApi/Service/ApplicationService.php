<?php

namespace Drupal\asu_api\Api\DrupalApi\Service;

use Drupal\asu_api\Api\BackendApi\Response\ApplicationResponse;
use Drupal\asu_api\Api\DrupalApi\Request\ApplicationRequest;
use Drupal\asu_api\Api\RequestHandler;

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
    $response = $this->requestHandler->send($httpRequest);
    return ApplicationResponse::createFromHttpResponse($response);
  }

}
