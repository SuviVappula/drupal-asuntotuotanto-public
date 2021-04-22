<?php

namespace Drupal\asu_apartment_search\Controller;

use Drupal\asu_api\Api\DrupalApi\DrupalApi;
use Drupal\asu_api\Api\DrupalApi\Request\ApartmentRequest;
use Drupal\Core\Controller\ControllerBase;

/**
 * An asu_apartment_search controller.
 */
class ApartmentController extends ControllerBase {

  /**
   * Returns a renderable array for a asuntohaku page.
   * @param int $id
   * @return array|string
   */
  public function content(int $id) {
    /** @var DrupalApi $drupalApi */
    $drupalApi = \Drupal::service('asu_api.drupalapi');

    try {
      $apartmentRequest = new ApartmentRequest($id);
      $content = $drupalApi->getApartmentService()
        ->getContent($apartmentRequest)
        ->getContent();
    }
    catch(\Exception $exception) {
      return '';
    }

    $build = [
      '#markup' => $content,
      '#attached' => [
        #'library' => 'asu_apartment_search/apartment-search',
      ],
    ];
    return $build;

  }

}
