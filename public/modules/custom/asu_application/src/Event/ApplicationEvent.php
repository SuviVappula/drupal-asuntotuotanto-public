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
   * Name of the project.
   *
   * @var string
   */
  protected string $projectName;

  /**
   * {@inheritdoc}
   */
  public function __construct($applicationId, string $projectName) {
    $this->applicationId = $applicationId;
    $this->projectName = $projectName;
  }

  /**
   * Gets the application id.
   */
  public function getApplicationId(): string {
    return $this->applicationId;
  }

  /**
   * Get the name of the project.
   *
   * @return string
   */
  public function getProjectName(): string {
    return $this->projectName;
  }

}
