<?php

namespace Drupal\asu_api\Api\ElasticSearchApi;

use Drupal\asu_api\Api\ElasticSearchApi\Service\ApartmentService;
use Drupal\asu_api\Api\RequestHandler;
use Drupal\Core\Site\Settings;

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
  public function __construct(string $baseurlVariable) {
    $baseurl = Settings::get($baseurlVariable);
    $username = getenv('ASU_ELASTICSEARCH_USERNAME');
    $password = getenv('ASU_ELASTICSEARCH_PASSWORD');
    $credentialsString = 'https://' . $username . ':' . $password . '@';
    $baseurl = isset($username) && isset($password) ? str_replace('https://', $credentialsString, $baseurl) : $baseurl;
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
