<?php

namespace Drupal\asu_api\Api\BackendApi\Request;

use Drupal\asu_api\Api\Request;
use Drupal\asu_application\Entity\Application;
use Drupal\user\Entity\User;

class ApplicationRequest extends Request {

  protected const PATH = '/application';
  protected const METHOD = 'POST';

  private $userId;

  private $applicationId;

  private string $applicationType;

  private array $apartmentIds;

  public function __construct(
    User $user,
    Application $application
  ) {
    $this->setUserId($user->id());
    $this->setApplicationId($application->id());
    $this->setApplicationType($application->getType());
    $this->setApartmentIds($application->getApartments());
  }

  public static function create(
    User $user,
    Application $application
  ): self {
    $instance = new static();
    $instance->setUserId($user->id());
    $instance->setApplicationId($application->id());
    $instance->setApplicationType($application->getType());
    $instance->setApartmentIds($application->getApartments());
    return $instance;
  }

  public function setUserId($userId){
    $this->userId = $userId;
  }

  public function setApplicationId($applicationId){
    $this->applicationId = $applicationId;
  }

  public function setApplicationType($application_type){
    $this->applicationType = $application_type;
  }

  public function setApartmentIds(array $apartmentIds){
    $this->apartmentIds = $apartmentIds;
  }

  public function toHttpRequest(){
    $headers = [];
    return new \GuzzleHttp\Psr7\Request(
      $this->getMethod(),
      $this->getPath(),
      $headers,
      $this->toArray(),
    );
  }

  public function toArray(): array
  {
    $values = [
      'user_id' => $this->user_id,
      'application_id' => $this->application_id,
      'application_type' => $this->application_type,
      'apartment_ids' => $this->apartment_ids,
    ];

    return $values;
  }

}
