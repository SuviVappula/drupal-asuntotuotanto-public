<?php

namespace Drupal\asu_api\Api\ElasticSearchApi\Request;

use Drupal\asu_api\Api\Request;

/**
 * Application request.
 */
class ApartmentRequest extends Request {

  protected const METHOD = 'POST';
  protected const PATH = 'elasticsearch_index_drupal_apartment/_search';

  /**
   * Project id.
   *
   * @var string
   */
  private String $projectId;

  /**
   * Constructor.
   */
  public function __construct(string $projectId) {
    $this->projectId = $projectId;
  }

  /**
   * {@inheritdoc}
   */
  public function toArray(): array {
    return [
      "size" => 1000,
      "query" => [
        "match" => [
          "project_id" => (int) $this->projectId,
        ],
      ],
    ];
  }

}
