<?php

namespace Drupal\asu_api\Api\DrupalApi;

use Drupal\asu_api\Api\DrupalApi\Service\ApartmentService;
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

  private $apartmentService;

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
    $this->apartmentService = new ApartmentService($requestHandler);
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
  public function getFiltersService(): FiltersService\ {
    return $this->filtersService;
  }

  /**
   * Get Apartment Service.
   */
  public function getApartmentService(): ApartmentService {
    return $this->getApartmentService();
  }

}
