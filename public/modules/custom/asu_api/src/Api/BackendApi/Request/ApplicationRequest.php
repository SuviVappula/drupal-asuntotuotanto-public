<?php

namespace Drupal\asu_api\Api\BackendApi\Request;

use Drupal\asu_api\Api\Request;
use Drupal\asu_application\Entity\Application;
use Drupal\user\UserInterface;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Application request.
 */
class ApplicationRequest extends Request {
  /**
   * Api path.
   *
   * @var string
   */
  protected const PATH = 'application';

  /**
   * Method.
   *
   * @var string
   */
  protected const METHOD = 'POST';

  /**
   * User object.
   *
   * @var \Drupal\user\Entity\UserInterface|UserInterface
   */
  private $user;

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
   * Has children.
   *
   * @var bool
   */
  private bool $hasChildren;

  /**
   * Right of residence number.
   *
   * @var int
   */
  private ?string $rightOfResidenceNumber;

  /**
   * Project id.
   *
   * @var int
   */
  private string $projectId;

  /**
   * Constructor.
   *
   * @param \Drupal\user\Entity\UserInterface $user
   *   Owner of the application.
   * @param \Drupal\asu_application\Entity\Application $application
   *   Application.
   */
  public function __construct(
    UserInterface $user,
    Application $application
  ) {
    $this->user = $user;
    $this->setUserId($user->id());
    $this->setApplicationId($application->id());
    $this->setRightOfResidenceNumber($user->field_right_of_r->value);
    $this->setApplicationType($application->bundle());

    $apartments = [];
    foreach ($application->getApartments()->getValue() as $key => $value) {
      if (isset($value['id'])) {
        $apartments[$key + 1] = (int) $value['id'];
      }
    }
    if (empty($apartments)) {
      throw new \Exception('Application apartments cannot be empty.');
    }

    $this->setApartmentIds($apartments);
    $this->setHasChildren($application->getHasChildren());
    $this->projectId = $application->getProjectId();
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
   * Set Right of residence number.
   *
   * @param string $value
   *   Application type.
   */
  public function setRightOfResidenceNumber($value) {
    $this->rightOfResidenceNumber = $value;
  }

  /**
   * Set HasChildren.
   *
   * @param bool $value
   *   Application type.
   */
  public function setHasChildren($value) {
    $this->hasChildren = $value;
  }

  /**
   * Calculates person's age from PID.
   *
   * @param string $pid
   *   Personal identification number.
   *
   * @return int
   *   Age.
   */
  private function calculateAgeFromPid(string $pid): Integer {
    $century = substr($pid, 7, 1) === "-" ? 19 : 20;
    $year = substr($pid, 5, 2);

    $day = substr($pid, 1, 2);
    $month = substr($pid, 3, 2);

    $date = "{$day}-{$month}-{$century}{$year}";

    $date = new DateTime($date);
    $now = new DateTime();
    $interval = $now->diff($date);

    return $interval->y;
  }

  /**
   * Data to array.
   */
  public function toArray(): array {
    $values = [
      'user_id' => $this->userId,
      'application_id' => $this->applicationId,
      'project_id' => $this->projectId,
      'application_type' => $this->applicationType,
      'apartment_ids' => $this->apartmentIds,
      'has_children' => $this->hasChildren,
    ];

    $values['age'] = isset($this->user->field_identification_number->value) ?
      $this->calculateAgeFromPid($this->user->field_identification_number->value) : NULL;

    if ($this->rightOfResidenceNumber) {
      $values['haso_number'] = $this->rightOfResidenceNumber;
    }

    return $values;
  }

}
