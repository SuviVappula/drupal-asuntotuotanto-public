<?php

namespace Drupal\asu_api\Api\BackendApi;

use Drupal\asu_api\Api\BackendApi\Service\ApplicationService;
use Drupal\asu_api\Api\RequestHandler;

class BackendApi {
  private ApplicationService $applicationService;

  public function __construct(string $backendBaseUrl) {
    $requestHandler = new RequestHandler($backendBaseUrl);
    $this->applicationService = new ApplicationService($requestHandler);
  }

  public function getApplicationService(): ApplicationService {
    return $this->applicationService;
  }
}
