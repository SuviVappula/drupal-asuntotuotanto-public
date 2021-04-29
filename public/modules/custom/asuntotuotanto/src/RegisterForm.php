<?php

namespace Drupal\asuntotuotanto;

use Drupal\asu_api\Api\BackendApi\BackendApi;
use Drupal\asu_api\Api\BackendApi\Request\CreateUserRequest;
use Drupal\asu_api\Exception\ApplicationRequestException;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\RegisterForm as BaseForm;

class RegisterForm extends BaseForm {

  private BackendApi $backendApi;

  public function getFormId(){
    return 'asu_register_form';
  }

  public function __construct(EntityRepositoryInterface $entity_repository, LanguageManagerInterface $language_manager, EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL, TimeInterface $time = NULL, BackendApi $backendApi)
  {
    parent::__construct($entity_repository, $language_manager, $entity_type_bundle_info, $time);
    $this->backendApi = $backendApi;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.repository'),
      $container->get('language_manager'),
      $container->get('entity_type.bundle.info'),
      $container->get('datetime.time'),
      $container->get('asu_api.backendapi')
    );
  }

  public function save(array $form, FormStateInterface $form_state)
  {
    if(SAVED_NEW === parent::save($form, $form_state)){
      $this->sendToBackend();
    }
  }

  private function sendToBackend(){
    /** @var \Drupal\user\UserInterface $account */
    $account = $this->entity;

    try{
      $request = new CreateUserRequest($account);
      $this->backendApi->getUserService()->createUser($request);
    }
    catch(ApplicationRequestException $e){
      // Request failed
    }
    catch(\Exception $e){
      // Something unexpected happened.
    }
  }

}
