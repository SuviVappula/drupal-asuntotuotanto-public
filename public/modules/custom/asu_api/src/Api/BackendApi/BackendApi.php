<?php

namespace Drupal\asu_api\Api\BackendApi;

use Drupal\asu_api\Api\BackendApi\Service\ApplicationService;
use Drupal\asu_api\Api\BackendApi\Service\UserService;
use Drupal\asu_api\Api\RequestHandler;

/**
 * Integration to django.
 */
class BackendApi {
  /**
   * Application service.
   *
   * @var \Drupal\asu_api\Api\BackendApi\Service\ApplicationService
   */
  private ApplicationService $applicationService;

  private UserService $userService;

  /**
   * Constructor.
   */
  public function __construct(string $backendBaseUrl) {
    $requestHandler = new RequestHandler($backendBaseUrl);
    $this->applicationService = new ApplicationService($requestHandler);
    $this->userService = new UserService($requestHandler);
  }

  /**
   * Get application service.
   */
  public function getApplicationService(): ApplicationService {
    return $this->applicationService;
  }

  public function getUserService(): UserService {
    return $this->userService;
  }

}
