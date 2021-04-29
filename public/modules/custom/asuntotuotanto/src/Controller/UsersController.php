<?php

namespace Drupal\asuntotuotanto\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Drupal\user\Form\UserLoginForm;

class UsersController extends ControllerBase {

  public function register() {
    if ($this->currentUser()->isAuthenticated()) {
      return $this->redirect('user.page');
    }

    $user = User::create();
    #$form_object = $this->entityTypeManager()->getFormObject('user', 'register')->setEntity($user);
    #$register_form = $this->formBuilder()->getForm($form_object);

    $form_object = $this->entityTypeManager()->getFormObject('user', 'asu_register_form')->setEntity($user);
    $register_form = $this->formBuilder()->getForm($form_object);

    $register_form['actions']['submit'][] = 'submitToBackend';

    $social_config = $this->config('social_auth.settings')->get('auth');
    foreach ($social_config as $plugin_id => $plugin_config) {
      $plugin_definition = $this->networkManager->getDefinition($plugin_id);
      $social_config[$plugin_id]['social_network'] = $plugin_definition['social_network'];
    }

    return [
      '#theme' => 'tc_user_login',
      '#register_form' => $register_form,
    ];
  }

  public function submitToBackend(){

  }

}
