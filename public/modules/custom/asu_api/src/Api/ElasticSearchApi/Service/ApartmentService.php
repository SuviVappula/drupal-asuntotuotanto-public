<?php

namespace Drupal\asu_api\Api\ElasticSearchApi\Service;

use Drupal\asu_api\Api\ElasticSearchApi\Request\ApartmentRequest;
use Drupal\asu_api\Api\ElasticSearchApi\Response\ApartmentResponse;
use Drupal\asu_api\Api\ServiceBase;

/**
 * Service ApartmentService.
 */
class ApartmentService extends ServiceBase {

  /**
   * Get project apartments.
   *
   * @param \Drupal\asu_api\Api\ElasticSearchApi\Request\ApartmentRequest $apartmentRequest
   *   Apartment request.
   *
   * @return \Drupal\asu_api\Api\ElasticSearchApi\Response\ApartmentResponse
   *   Apartment response.
   *
   * @throws \Exception
   */
  public function getProjectApartments(ApartmentRequest $apartmentRequest): ApartmentResponse {
    $options = [
      'headers' => [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
      ],
      'json' => $apartmentRequest->toArray(),
    ];
    $response = $this->requestHandler->post($apartmentRequest->getPath(), $options);
    return ApartmentResponse::createFromHttpResponse($response);
  }

}
