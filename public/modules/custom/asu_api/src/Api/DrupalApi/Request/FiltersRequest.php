<?php

namespace Drupal\asu_api\Api\DrupalApi\Request;

use Drupal\asu_api\Api\Request;

/**
 * Filters request.
 */
class FiltersRequest extends Request {

  protected const PATH = '/filters';
  protected const METHOD = 'GET';

  /**
   * Constructor.
   */
  public function __construct() {
  }

  /**
   * Data to array.
   */
  public function toArray(): array {
    $values = [];

    return $values;
  }

}
