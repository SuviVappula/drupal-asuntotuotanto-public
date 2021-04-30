<?php

namespace Drupal\asuntotuotanto;

use Drupal\asu_api\Api\BackendApi\BackendApi;
use Drupal\asu_api\Api\BackendApi\Request\CreateUserRequest;
use Drupal\asu_api\Exception\RequestException;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\RegisterForm as BaseForm;

/**
 * Customized registration form.
 */
class RegisterForm extends BaseForm {

  /**
   * Backend api class.
   *
   * @var \Drupal\asu_api\Api\BackendApi\BackendApi
   */
  private BackendApi $backendApi;

  /**
   * Construct.
   */
  public function __construct(EntityRepositoryInterface $entity_repository, LanguageManagerInterface $language_manager, EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL, TimeInterface $time = NULL, BackendApi $backendApi) {
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

  /**
   * {@inheritDoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    parent::save($form, $form_state);
    $this->sendToBackend();
  }

  /**
   * Send the user information to Django backend.
   */
  private function sendToBackend() {
    /** @var \Drupal\user\UserInterface $account */
    $account = $this->entity;

    try {
      $request = new CreateUserRequest($account);
      $this->backendApi
        ->getUserService()
        ->createUser($request);
    }
    catch (RequestException $e) {
      // @todo Proper logging and error handling.
      // Request failed.
      $this->messenger()->addError('Problem with the response:' . $e->getMessage());
    }
    catch (\Exception $e) {
      // Something unexpected happened.
      $this->messenger()->addError('Unexpected exception: ' . $e->getMessage());
    }
  }

}
