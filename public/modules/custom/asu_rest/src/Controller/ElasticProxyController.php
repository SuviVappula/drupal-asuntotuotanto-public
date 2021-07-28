<?php

namespace Drupal\asu_rest\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Elastic proxy controller.
 */
class ElasticProxyController extends ControllerBase {

  /**
   * Returns a renderable array for a asuntohaku page.
   */
  public function elasticProxy(Request $request): array {
    $query = $request->getContent();
    try {
      $elasticSearchApi = \Drupal::service('asu_api.elasticapi');
      /** @var \Drupal\asu_api\Api\ElasticSearchApi\Request\ProxyRequest $proxyRequest */
      $proxyRequest = $elasticSearchApi
        ->getApartmentService()
        ->proxyRequest(json_decode($query, TRUE));
      $response = $proxyRequest->getHits();
    }
    catch (\Exception $e) {
      \Drupal::logger('asu_elastic_proxy')->critical('Could not fetch apartments for react search component: ' . $e->getMessage());
      die('{}');
    }
    echo(json_encode($response));
    die();
  }

}
