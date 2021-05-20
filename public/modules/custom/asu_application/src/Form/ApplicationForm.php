<?php

namespace Drupal\asu_application\Form;

use Drupal\asu_api\Api\ElasticSearchApi\Request\ApartmentRequest;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\user\Entity\User;
use Drupal\asu_application\Event\ApplicationEvent;

/**
 * Form for Application.
 */
class ApplicationForm extends ContentEntityForm {

  use MessengerTrait;

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    if ($this->isFormAccessable()) {
      // @todo Add message & redirect.
      // $this->messenger()->addMessage($this->t('You are trying to fill an application which is not active.'));
      die('you should not be here');
    }

    $parameters = \Drupal::routeMatch()->getParameters();

    if ($this->entity->isNew()) {
      $project_id = $parameters->get('project_id');
      $user = User::load(\Drupal::currentUser()->id());
      /** @var \Drupal\asu_application\Entity\ApplicationType $application */
      $application = $parameters->get('application_type');
      $application_type_id = $application->id();
    }
    else {
      $project_id = $this->entity->get('project_id');
      $user = $this->entity->getOwner();
      $application_type_id = $this->entity->bundle();
    }

    try {
      $project_data = $this->getApartments($project_id);
    }
    catch (\Exception $e) {
      // @todo Message & redirect, cannot fetch apartments.
    }

    if (!$this->isCorrectApplicationFormForProject($application_type_id, $project_data['ownership_type'])) {
      // @todo Redirect to correct form.
    }

    $startDate = $project_data['application_start_date'];
    $endDate = $project_data['application_end_date'];

    if (!$this->isFormActive($startDate, $endDate)) {
      // @todo Add redirect to proper place, outside of application time.
      $this->messenger()->addMessage($this->t('You are trying to fill an application which is not active.'));
    }

    $projectName = $project_data['project_name'];
    $apartments = $project_data['apartments'];
    // Set the apartments as a value to the form array.
    $form['apartment_values'] = $apartments;
    $form['project_name'] = $projectName;

    $form = parent::buildForm($form, $form_state);

    $form['#title'] = $this->t('Application for') . ' ' . $projectName;

    if ($application_type_id == 'haso') {
      if ($this->entity->isNew()) {
        if (!$user->field_right_of_r->value) {
          $this->messenger()->addMessage("Your user account is missing the right of residence number. You must add a valid right of residence number in order to apply.");
        }
      }
    }
    elseif ($application_type_id == 'hitas') {
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;
    $message_params = [
      '%entity_label' => $entity->id(),
      '%content_entity_label' => $entity->getEntityType()->getLabel()->render(),
      '%bundle_label' => $entity->bundle->entity->label(),
    ];

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $project_name = $form['project_name'];
        $event = new ApplicationEvent($entity->id(), $project_name);
        /** @var \Symfony\Component\EventDispatcher\EventDispatcher $event_dispatcher */
        $event_dispatcher = \Drupal::service('event_dispatcher');
        $event_dispatcher->dispatch($event, ApplicationEvent::EVENT_NAME);
        $this->messenger()->addStatus($this->t('Created the %bundle_label - %content_entity_label entity:  %entity_label.', $message_params));
        break;

      default:
        $this->messenger()->addStatus($this->t('Saved the %bundle_label - %content_entity_label entity:  %entity_label.', $message_params));
    }

    $content_entity_id = $entity->getEntityType()->id();
    $form_state->setRedirect("entity.{$content_entity_id}.canonical", [$content_entity_id => $entity->id()]);

  }

  /**
   * Check if the form be edited or filled.
   *
   * @return bool
   *   Is the form accessible.
   */
  private function isFormAccessable(): bool {
    return !$this->entity->isNew() && !$this->entity->getProjectId();
  }

  /**
   * The form should only be active between designated application time.
   *
   * @param string $startTime
   *   Start time as ISO string.
   * @param string $endTime
   *   End time as ISO string.
   *
   * @return bool
   *   Is current moment between the project's application time.
   */
  private function isFormActive(string $startTime, string $endTime): bool {
    $start = strtotime($startTime);
    $end = strtotime($endTime);
    $date = new \DateTime();
    $now = $date->getTimestamp();
    return $now < $end && $now > $start;
  }

  /**
   * Check that user is filling the correct form.
   *
   * @param string $formType
   *   Form type.
   * @param string $ownershipType
   *   Ownership type.
   *
   * @return bool
   *   Does the apartment ownershiptype match the form's type.
   */
  private function isCorrectApplicationFormForProject($formType, $ownershipType) {
    return $formType == $ownershipType;
  }

  /**
   * Get project apartments.
   *
   * @return array
   *   Array of project information & apartments.
   */
  private function getApartments($projectId): ?array {
    /** @var \Drupal\asu_api\Api\ElasticSearchApi\ElasticSearchApi $elastic */
    $elastic = \Drupal::service('asu_api.elasticapi');
    $request = new ApartmentRequest($projectId);
    $apartmentResponse = $elastic->getApartmentService()
      ->getProjectApartments($request);

    $projectName = $apartmentResponse->getProjectName();

    $apartments = [];
    foreach ($apartmentResponse->getApartments() as $apartment) {
      $data = $apartment['_source'];
      $apartments[$data['nid']] = $data['apartment_address'];
    }
    ksort($apartments, SORT_NUMERIC);

    return [
      'project_name' => $projectName,
      'ownership_type' => $apartmentResponse->getOwnershipType(),
      'application_start_date' => $apartmentResponse->getStartTime(),
      'application_end_date' => $apartmentResponse->getEndTime(),
      'apartments' => $apartments,
    ];
  }

}
