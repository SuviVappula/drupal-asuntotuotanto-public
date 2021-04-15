<?php

namespace Drupal\asu_api\Api\ElasticSearchApi;

use Drupal\asu_api\Api\ElasticSearchApi\Service\ApartmentService;
use Drupal\asu_api\Api\RequestHandler;

/**
 * ElasticSearch api.
 */
class ElasticSearchApi {

  /**
   * Apartment service.
   *
   * @var \Drupal\asu_api\Api\ElasticSearchApi\Service\ApartmentService
   */
  private ApartmentService $apartmentService;

  /**
   * Constructor.
   *
   * ElasticSearchApi constructor.
   *
   * @param string $baseurl
   *   Elasticsearch baseurl.
   */
  public function __construct(string $baseurl) {
    $handler = new RequestHandler($baseurl);
    $this->apartmentService = new ApartmentService($handler);
  }

  /**
   * Get apartment service.
   *
   * @return \Drupal\asu_api\Api\ElasticSearchApi\Service\ApartmentService
   *   Apartment service.
   */
  public function getApartmentService(): ApartmentService {
    return $this->apartmentService;
  }

}
