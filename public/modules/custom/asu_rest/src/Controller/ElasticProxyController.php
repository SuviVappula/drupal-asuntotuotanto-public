<?php

namespace Drupal\asu_rest\Controller;

use Drupal\asu_api\Api\ElasticSearchApi\Request\ProxyRequest;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\Exception\BrokenPostRequestException;
use Drupal\rest\ModifiedResourceResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Elastic proxy controller.
 */
class ElasticProxyController extends ControllerBase {

  /**
   * Returns a renderable array for a asuntohaku page.
   */
  public function elasticProxy(Request $request): array {
    #$response = [];
    #$queryString = $request->getContent();
    try {
      $elasticSearchApi = \Drupal::service('asu_api.elasticapi');
      /** @var ProxyRequest $proxyRequest */
      $proxyRequest = $elasticSearchApi
        ->getApartmentService()
        ->proxyRequest([]);
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
