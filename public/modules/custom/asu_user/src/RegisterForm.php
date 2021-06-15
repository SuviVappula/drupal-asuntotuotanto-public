<?php

namespace Drupal\asu_user;

use Drupal\asu_api\Api\BackendApi\BackendApi;
use Drupal\asu_api\Api\BackendApi\Request\CreateUserRequest;
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

  private Store $store;

  /**
   * Construct.
   */
  public function __construct(EntityRepositoryInterface $entity_repository, LanguageManagerInterface $language_manager, EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL, TimeInterface $time = NULL, BackendApi $backendApi, Store $store) {
    parent::__construct($entity_repository, $language_manager, $entity_type_bundle_info, $time);
    $this->backendApi = $backendApi;
    $this->store = $store;
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
      $container->get('asu_api.backendapi'),
      $container->get('asuntotuotanto_public.tempstore')
    );
  }

  /**
   *
   */
  public function form(array $form, FormStateInterface $form_state): array {
    $form = parent::form($form, $form_state);
    $config = \Drupal::config('asuntotuotanto_public.external_user_fields');
    $fields = $config->get('external_data_map');

    foreach ($fields as $field => $info) {
      $form['account'][$field] = [
        '#type' => $info['type'],
        '#title' => $this->t($info['title']),
        '#maxlength' => 255,
        '#required' => TRUE,
        '#attributes' => [
          // 'class' => ['username'],
          'autocorrect' => 'off',
          'autocapitalize' => 'off',
          'spellcheck' => 'false',
        ],
        // (!$register ? $account->getAccountName() : ''),
        '#default_value' => '',
        // '#default_value' => (!$register ? $account->getAccountName() : ''),
        // '#access' => $account->name->access('edit'),
      ];
    }

    return $form;
  }

  /**
   * {@inheritDoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    parent::save($form, $form_state);
    $this->sendToBackend($form_state);
  }

  /**
   * Send the user information to Django backend.
   */
  private function sendToBackend(FormStateInterface $form_state) {
    /** @var \Drupal\user\UserInterface $account */
    $account = $this->entity;

    try {
      $request = new CreateUserRequest($account, $form_state);
      $response = $this->backendApi
        ->getUserService()
        ->createUser($request);

      $account->field_backend_profile_id = $response->getProfileId();
      $account->field_backend_password = $response->getPassword();
      $account->save();
    }
    catch (ResponseParameterException $e) {
      // @todo Proper logging and error handling.
      // Request failed.
      $this->messenger()->addError('Backend returned unsatisfactory parameters.' . $e->getMessage());
    }
    catch (RequestException $e) {
      $this->messenger()->addError('Backend returned non-200 response:' . $e->getMessage());
    }
    catch (\Exception $e) {
      // Something unexpected happened.
      $this->messenger()->addError('Unexpected exception: ' . $e->getMessage());
    }
  }

}
