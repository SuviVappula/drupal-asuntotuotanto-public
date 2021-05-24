<?php

namespace Drupal\asu_api\Api\AskoApi;

use Drupal\asu_api\Api\AskoApi\Request\AskoApplicationRequest;
use Drupal\asu_application\Entity\Application;
use Drupal\user\Entity\User;

/**
 * Integration to As-Ko.
 */
class AskoApi {

  /**
   * Asko email address.
   *
   * @var string
   */
  private string $askoEmailAddress;

  /**
   * Constructor.
   */
  public function __construct(string $askoAdressVariable) {
    if ($env = getenv($askoAdressVariable)) {
      $this->askoEmailAddress = $env;
    }
    else {
      throw new \InvalidArgumentException('As-Ko address is not set');
    }
  }

  /**
   * Get email address.
   *
   * @return string
   */
  public function getEmailAddress(): string {
    return $this->askoEmailAddress;
  }

  /**
   * Get asko request.
   *
   * @param \Drupal\user\Entity\User $user
   *   User entity.
   * @param \Drupal\asu_application\Entity\Application $application
   *   Application entity.
   * @param string $projectName
   *   Name of the project.
   *
   * @return Drupal\asu_api\Api\AskoApi\Request\AskoApplicationRequest
   */
  public function getAskoApplicationRequest(User $user, Application $application, string $projectName): AskoApplicationRequest {
    return new AskoApplicationRequest($user, $application, $projectName);
  }

}
