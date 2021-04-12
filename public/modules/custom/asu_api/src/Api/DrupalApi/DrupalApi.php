<?php

namespace Drupal\asu_api\Api\DrupalApi;

use Drupal\asu_api\Api\DrupalApi\Service\ApplicationService;
use Drupal\asu_api\Api\DrupalApi\Service\FiltersService;
use Drupal\asu_api\Api\RequestHandler;

/**
 * Integration to drupal.
 */
class DrupalApi {

  /**
   * ApplicationService.
   *
   * @var \Drupal\asu_api\Api\DrupalApi\Service\ApplicationService
   *    ApplicationService.
   */
  private $applicationService;

  /**
   * FilterService.
   *
   * @var \Drupal\asu_api\Api\DrupalApi\Service\FiltersService
   *    FilterService.
   */
  private $filtersService;

  /**
   * Constructor.
   *
   * @param string $apiUrl
   *   Api url.
   */
  public function __construct(string $apiUrl) {
    $requestHandler = new RequestHandler($apiUrl);
    $this->applicationService = new ApplicationService($requestHandler);
    $this->filtersService = new FiltersService($requestHandler);
  }

  /**
   * Get application service.
   */
  public function getApplicationService() {
    return $this->applicationService;
  }

  /**
   * Get Filters service.
   */
  public function getFiltersService() {
    return $this->filtersService;
  }

}
