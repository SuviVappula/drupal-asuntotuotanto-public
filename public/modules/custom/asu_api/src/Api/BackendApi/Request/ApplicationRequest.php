<?php

namespace Drupal\asu_api\Api\BackendApi\Request;

use Drupal\asu_api\Api\Request;
use Drupal\asu_application\Entity\Application;
use Drupal\user\Entity\User;

/**
 * Application request.
 */
class ApplicationRequest extends Request {
  /**
   * Api path.
   *
   * @var string
   */
  protected const PATH = '/application';

  /**
   * Method.
   *
   * @var string
   */
  protected const METHOD = 'POST';

  /**
   * User id.
   *
   * @var string
   */
  private $userId;

  /**
   * Application id.
   *
   * @var string
   */
  private $applicationId;

  /**
   * Application type.
   *
   * @var string
   */
  private string $applicationType;

  /**
   * Apartment ids.
   *
   * @var array
   */
  private array $apartmentIds;

  /**
   * Constructor.
   *
   * @param \Drupal\user\Entity\User $user
   *   Owner of the application.
   * @param \Drupal\asu_application\Entity\Application $application
   *   Application.
   */
  public function __construct(
    User $user,
    Application $application
  ) {
    $this->setUserId($user->id());
    $this->setApplicationId($application->id());
    $this->setApplicationType($application->getType());
    $this->setApartmentIds($application->getApartments());
  }

  /**
   * Set user id.
   *
   * @param string $userId
   *   User id.
   */
  public function setUserId($userId) {
    $this->userId = $userId;
  }

  /**
   * Set application id.
   *
   * @param string $applicationId
   *   Application id.
   */
  public function setApplicationId($applicationId) {
    $this->applicationId = $applicationId;
  }

  /**
   * Set application type.
   *
   * @param string $application_type
   *   Application type.
   */
  public function setApplicationType($application_type) {
    $this->applicationType = $application_type;
  }

  /**
   * Set apartment ids.
   *
   * @param array $apartmentIds
   *   Apartment ids.
   */
  public function setApartmentIds(array $apartmentIds) {
    $this->apartmentIds = $apartmentIds;
  }

  /**
   * Data to array.
   */
  public function toArray(): array {
    $values = [
      'user_id' => $this->user_id,
      'application_id' => $this->application_id,
      'application_type' => $this->application_type,
      'apartment_ids' => $this->apartment_ids,
    ];

    return $values;
  }

}
