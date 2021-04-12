<?php

namespace Drupal\asu_application\Event;

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
  public function getApplicationId(): string {
    return $this->applicationId;
  }

}
