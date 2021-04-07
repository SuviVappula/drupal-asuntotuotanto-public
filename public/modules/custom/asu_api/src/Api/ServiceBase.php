<?php
namespace Drupal\asu_api\Api;

use Drupal\asu_api\Api\RequestHandler;

abstract class ServiceBase {
  /**
   * @var Drupal\asu_api\BackendApi\RequestHandler
   */
  protected $requestHandler;

  public function __construct(RequestHandler $requestHandler)
  {
    $this->requestHandler = $requestHandler;
  }
}
