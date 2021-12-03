<?php

namespace Drupal\asu_rest\Plugin\rest\resource;

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Provides a resource to get available filters.
 *
 * @RestResource(
 *   id = "asu_applications",
 *   label = @Translation("Applications"),
 *   uri_paths = {
 *     "canonical" = "/applications/{uuid}",
 *     "https://www.drupal.org/link-relations/create" = "/applications"
 *   }
 * )
 */
final class Applications extends ResourceBase {

  private const REQUIRED_FIELDS = [
    'uuid',
  ];

  /**
   * Responds to GET requests.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The HTTP response object.
   */
  public function get(Request $request) {
    $this->validateParameters($request);
    return new ModifiedResourceResponse();
  }

  /**
   * Validate request parameters.
   */
  private function validateParameters(Request $request) {
    /** @var \Symfony\Component\HttpFoundation\ParameterBag $parameters */
    $parameters = new ParameterBag($request);

    foreach (self::REQUIRED_FIELDS as $field) {
      if ($parameters->get($field)) {
        continue;
      }
      throw new BadRequestHttpException(sprintf('Missing required field: %s.', $field));
    }
    return $parameters;
  }

}
