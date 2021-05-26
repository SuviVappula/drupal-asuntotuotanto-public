<?php

namespace Drupal\asu_rest;

/**
 * Handles applications.
 */
class Applications {

  const HIGH_ENUM = 'HIGH';
  const MEDIUM = 10;
  const MEDIUM_ENUM = 'MEDIUM';
  const LOW = 5;
  const LOW_ENUM = 'LOW';

  /**
   * Array of application objects.
   *
   * @var array|\Drupal\Core\Entity\EntityInterface[]
   */
  private array $applications;

  /**
   * Applications constructor.
   *
   * @param string $userId
   *   User id.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(string $userId = NULL) {
    $applicationStorage = \Drupal::entityTypeManager()
      ->getStorage('asu_application');

    try {
      if (!$userId) {
        $this->applications = $applicationStorage->loadMultiple();
      }
      else {
        $this->applications = $applicationStorage
          ->loadByProperties(['uid' => $userId, 'status' => 1]);
      }
    }
    catch (\Exception $e) {
      $this->applications = [];
    }
  }

  /**
   * Get all applications for all applications.
   *
   * @return static
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public static function create(): self {
    return new self();
  }

  /**
   * Get applications by user.
   *
   * @param string $userId
   *   User whose applications are resolved.
   *
   * @return static
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public static function applicationsByUser(string $userId): self {
    return new self($userId);
  }

  /**
   * Get applications.
   *
   * @return array
   *   Array of apartment ids by project.
   */
  public function getApartmentApplicationsByProject(): array {
    if (empty($this->applications)) {
      return [];
    }
    $applicationsByProject = [];

    /** @var \Drupal\asu_application\Entity\Application $application */
    foreach ($this->applications as $application) {
      $apartmentIds = $application->getApartmentIds();
      $applicationsByProject[$application->getProjectId()] = $apartmentIds;
    }
    return $applicationsByProject;
  }

  /**
   * Get apartment applications.
   */
  public function getApartmentApplications() {
    if (empty($this->applications)) {
      return [];
    }
    $applications = [];

    /** @var \Drupal\asu_application\Entity\Application $application */
    foreach ($this->applications as $application) {
      $apartmentIds = $application->getApartmentIds();
      $applications = array_merge($applications, $apartmentIds);
    }
    foreach ($this->applications as $application) {
      $apartmentIds = $application->getApartmentIds();
      $applications = array_merge($applications, $apartmentIds);
    }

    return $applications;
  }

  /**
   * Return application count as status text instead of numeric.
   *
   * @return array
   *   Apartment application status.
   */
  public function getApartmentApplicationStatuses(): array {
    $applications = $this->getApartmentApplications();

    $counts = array_count_values($applications);

    $applicationStatuses = [];
    foreach ($counts as $key => $count) {
      $applicationStatuses[$key] = $this::resolveApplicationCountEnum($count);
    }
    return $applicationStatuses;
  }

  /**
   * Resolve the enum for application count.
   *
   * @param int $count
   *   Number of applications for an apartment.
   *
   * @return string
   *   Application count as enum.
   */
  public static function resolveApplicationCountEnum(int $count): string {
    if ($count === 0) {
      return self::LOW_ENUM;
    }
    if ($count <= self::LOW) {
      return self::LOW_ENUM;
    }
    if (in_array($count, range(self::LOW, self::MEDIUM))) {
      return self::MEDIUM_ENUM;
    }
    if ($count > self::MEDIUM) {
      return self::HIGH_ENUM;
    }
  }

}
