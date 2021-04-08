<?php

namespace Drupal\asu_api;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Event for application creation.
 */
class ApplicationEvent extends Event {
  const EVENT_NAME = 'application_created_event';

  /**
   * Application id.
   *
   * @var int
   */
  protected $applicationId;

  /**
   * {@inheritdoc}
   */
  public function __construct($applicationId) {
    $this->applicationId = $applicationId;
  }

  /**
   * Gets the application id.
   */
  public function getApplicationId() {
    return $this->applicationId;
  }

}
