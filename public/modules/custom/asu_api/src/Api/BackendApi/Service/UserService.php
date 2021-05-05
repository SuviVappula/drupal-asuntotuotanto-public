<?php

namespace Drupal\asu_api\Api\BackendApi\Service;

use Drupal\asu_api\Api\BackendApi\Response\CreateUserResponse;
use Drupal\asu_api\Api\BackendApi\Response\UpdateUserResponse;
use Drupal\asu_api\Api\BackendApi\Response\UserResponse;
use Drupal\asu_api\Api\Request;
use Drupal\asu_api\Api\Response;
use Drupal\asu_api\Api\ServiceBase;

/**
 * Handle requests and responses related to applications.
 */
class UserService extends ServiceBase {

  /**
   * Send newly created user to backend.
   *
   * @param \Drupal\asu_api\Api\Request $request
   *   Create user request.
   *
   * @return \Drupal\asu_api\Api\Response
   *   Create user response.
   *
   * @throws \Exception
   */
  public function createUser(Request $request): Response {
    $httpRequest = $this->requestHandler->buildRequest($request);
    $response = $this->requestHandler->send($httpRequest);
    return CreateUserResponse::createFromHttpResponse($response);
  }

  /**
   * Get user information from backend.
   *
   * @param \Drupal\asu_api\Api\Request $request
   *
   * @return \Drupal\asu_api\Api\Response
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getUser(Request $request): Response {
    $httpRequest = $this->requestHandler->buildRequest($request);
    $response = $this->requestHandler->send($httpRequest);
    return UserResponse::createFromHttpResponse($response);
  }

  /**
   * @param \Drupal\asu_api\Api\Request $request
   *
   * @return \Drupal\asu_api\Api\Response
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function updateUser(Request $request): Response {
    $httpRequest = $this->requestHandler->buildRequest($request);
    $response = $this->requestHandler->send($httpRequest);
    return UpdateUserResponse::createFromHttpResponse($response);
  }

}
