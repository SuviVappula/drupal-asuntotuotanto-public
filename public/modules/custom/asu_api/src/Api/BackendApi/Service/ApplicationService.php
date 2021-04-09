<?php

namespace Drupal\asu_api\Api\BackendApi\Service;

use Drupal\asu_api\Api\BackendApi\Response\ApplicationResponse;
use Drupal\asu_api\Api\ServiceBase;
use Drupal\asu_api\Api\BackendApi\Request\ApplicationRequest;

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
    $httpRequest = $this->requestHandler->buildRequest($request);
    $response = $this->requestHandler->send($httpRequest);
    return ApplicationResponse::createFromHttpResponse($response);
  }

}
