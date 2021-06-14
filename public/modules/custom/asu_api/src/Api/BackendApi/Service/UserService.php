<?php

namespace Drupal\asu_api\Api\BackendApi\Service;

use Drupal\asu_api\Api\BackendApi\Request\CreateUserRequest;
use Drupal\asu_api\Api\BackendApi\Request\UpdateUserRequest;
use Drupal\asu_api\Api\BackendApi\Response\CreateUserResponse;
use Drupal\asu_api\Api\BackendApi\Response\UpdateUserResponse;
use Drupal\asu_api\Api\ServiceBase;
use Drupal\asu_api\Exception\RequestException;
use Drupal\asu_api\Exception\ResponseParameterException;

/**
 * Handle requests and responses related to applications.
 */
class UserService extends ServiceBase {

  /**
   * Send newly created application to backend.
   *
   * @param \Drupal\asu_api\BackendApi\Request\CreateUserRequest $request
   *   CreateUserRequest.
   *
   * @return \Drupal\asu_api\Api\BackendApi\Response\CreateUserResponse
   *   CreateUserResponse.
   *
   * @throws \Exception
   */
  public function createUser(CreateUserRequest $request): CreateUserResponse {
    try {
      $httpRequest = $this->requestHandler->buildRequest($request);
      $response = $this->requestHandler->send($httpRequest);
      return CreateUserResponse::createFromHttpResponse($response);
    }
    catch (ResponseParameterException $exception) {
      \Drupal::messenger()->addMessage('Response parameters are not correct: ' . $exception->getMessage());
      die('parameters are wrong.');
      // Response parameters are not what we expect.
    }
    catch (RequestException $exception) {
      \Drupal::messenger()->addMessage('non-200 status code.: ' . $exception->getMessage());
      die('non 200' . $exception->getMessage());
      // Status code is not 200.
    }
  }

  /**
   * Send updated user data to backend.
   */
  public function updateUser(UpdateUserRequest $request): UpdateUserResponse {
    $httpRequest = $this->requestHandler->buildRequest($request);
    $response = $this->requestHandler->send($httpRequest);
    return UpdateUserResponse::createFromHttpResponse($response);
  }

}
