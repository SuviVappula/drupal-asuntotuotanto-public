<?php

namespace Drupal\asu_api\Api\ElasticSearchApi\Request;

use Drupal\asu_api\Api\Request;

/**
 *
 */
class ProxyRequest extends Request {

  protected const METHOD = 'POST';
  protected const PATH = 'asuntotuotanto_apartment/_search';

  private $requestArray;

  /**
   * Constructor.
   */
  public function __construct(array $request) {
    $this->requestArray = $request;
  }

  /**
   * {@inheritdoc}
   */
  public function toArray(): array {
    return $this->requestArray;
  }

}
