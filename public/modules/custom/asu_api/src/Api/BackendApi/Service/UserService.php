<?php

namespace Drupal\asu_api\Api\BackendApi\Service;

use Drupal\asu_api\Api\BackendApi\Request\CreateUserRequest;
use Drupal\asu_api\Api\BackendApi\Response\CreateUserResponse;
use Drupal\asu_api\Api\ServiceBase;

/**
 * Handle requests and responses related to applications.
 */
class UserService extends ServiceBase {

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
  public function createUser(CreateUserRequest $request): CreateUserResponse {
    $httpRequest = $this->requestHandler->buildRequest($request);
    $response = $this->requestHandler->send($httpRequest);
    return CreateUserResponse::createFromHttpResponse($response);
  }

}
