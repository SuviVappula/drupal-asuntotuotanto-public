<?php

namespace Drupal\asu_api\Api\DrupalApi;

use Drupal\asu_api\Api\DrupalApi\Service\ApplicationService;
use Drupal\asu_api\Api\RequestHandler;

class DrupalApi {

  public function __construct(string $backendBaseUrl) {
    $requestHandler = new RequestHandler($backendBaseUrl);
    $this->applicationService = new ApplicationService($requestHandler);
  }

  public function getApplicationService(){
    return $this->applicationService;
  }



}
