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
  public function __construct(string $baseurlVariable, string $usernameVariable, string $passwordVariable) {
    $baseurl = Settings::get($baseurlVariable);
    $username = Settings::get($usernameVariable);
    $password = Settings::get($passwordVariable);
    $credentialsString = 'https://' . $username . ':' . $password . '@';
    $baseurlWithCredentials = isset($username) && isset($password) ? str_replace('https://', $credentialsString, $baseurl) : $baseurl;
    $handler = new RequestHandler($baseurlWithCredentials);
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
