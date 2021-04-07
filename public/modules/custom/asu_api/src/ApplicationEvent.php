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
  protected $application_id;

  /**
   * {@inheritdoc}
   */
  public function __construct($application_id) {
    $this->application_id = $application_id;
  }

  /**
   * Gets the application id.
   */
  public function getApplicationId() {
    return $this->application_id;
  }

}
