<?php

namespace Drupal\asu_application\Form;

use Drupal\asu_application\Entity\ApplicationType;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

/**
 * Class ApplicationForm
 */
class ApplicationForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    if(!$this->entity->isNew() && !$this->entity->getProjectId()){
      die('you should not be here');
    }

    $parameters = \Drupal::routeMatch()->getParameters();

    if($this->entity->isNew()){
      $project_id = $parameters->get('project_id');
      $user = User::load(\Drupal::currentUser()->id());
      /** @var ApplicationType $application */
      $application = $parameters->get('application_type');
      $application_type_id = $application->id();
    }
    else {
      $project_id = $this->entity->get('project_id');
      $user = $this->entity->getOwner();
      $application_type_id = $this->entity->bundle();
    }

    $form = parent::buildForm($form, $form_state);

    $project_data = $this->getApartments($project_id);

    $form['#title'] = t('Application for ') . $project_data['project'];

    if($application_type_id == 'haso'){
      if($this->entity->isNew()){
        if(!$user->field_right_of_r->value){
          $this->messenger()->addMessage("Your user account is missing the right of residence number. You must add a valid right of residence number in order to apply.");
        }
      }

    }
    else if($application_type_id == 'hitas') {

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
        $this->messenger()->addStatus($this->t('Created the %bundle_label - %content_entity_label entity:  %entity_label.', $message_params ));
        break;

      default:
        $this->messenger()->addStatus($this->t('Saved the %bundle_label - %content_entity_label entity:  %entity_label.', $message_params));
    }

    $content_entity_id = $entity->getEntityType()->id();
    $form_state->setRedirect("entity.{$content_entity_id}.canonical", [$content_entity_id => $entity->id()]);

  }

  private function getApplicationType($type){

  }

  private function getApartments(){
    //get apartments
    /** @var \GuzzleHttp\Client $client */
    #$client = Drupal::httpClient();
    #$client->post();

    $apartments = [
      '0' => $this->t('Select'),
      '2' => 'Kaakelikuja 22 A1',
      '3' => 'Kaakelikuja 22 A2',
      '4' => 'Kaakelikuja 22 A3',
      '5' => 'Kaakelikuja 22 A4',
      '6' => 'Kaakelikuja 22 A5',
      '7' => 'Kaakelikuja 22 A6',
      '8' => 'Kaakelikuja 22 B1',
      '9' => 'Kaakelikuja 22 B2',
      '10' => 'Kaakelikuja 22 B3',
      '11' => 'Kaakelikuja 22 B4',
      '12' => 'Kaakelikuja 22 B5',
      '13' => 'Kaakelikuja 22 B6',
    ];

    $data = [
      'project' => 'Kaakelikuja 22',
      'apartments' => $apartments
    ];

    return $data;
  }

}
