<?php

namespace Drupal\asu_apartment_search\Controller;

use Drupal\asu_api\Api\ElasticSearchApi\ElasticSearchApi;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

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
    try {
      /** @var ElasticSearchApi $elasticApi */
      $elasticApi = \Drupal::service('asu_api.elasticapi');
      $content = $elasticApi
        ->getApartmentService()
        ->getApartment($id)
        ->getApartment();
    }
    catch(\Exception $e){
      return new Response([]);
      return [];
    }

    #$content = extract($content);
    #$content['#theme'] = 'asu_content';
    #$content['#attached'] = [];
    #return $content;

    # map field to array from content
    return [
      '#theme' => 'asu_content',
      #'#attached' => [],
      '#cta_image' => 'asd1',
      '#application_start_time' => $content['project_application_start_time'],
      '#application_end_time' => $content['project_application_end_time'],
      #TODO:
      '#is_application_period_active' => 'asd',
      '#district' => $content['project_district'],
      '#address' => $content['apartment_address'],
      '#ownership_type' => $content['project_ownership_type'],
      #TODO:
      '#accessibility' => 'asdasd',
      '#project_description' => $content['project_description'],
      '#building_type' => $content['project_building_type'],
      '#energy_class' => $content['project_energy_class'],
      '#services' => $content['services'],
      #TODO:
      '#services_url' => 'asdasdasd',
      '#attachments' => $content['project_attachment_urls'],
      '#estimated_completion_date' => $content['project_estimated_completion_date'],
    ];
  }

}
