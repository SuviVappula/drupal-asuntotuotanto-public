<?php

namespace Drupal\asu_api\Api\BackendApi\Request;

use Drupal\asu_api\Api\Request;
use Drupal\Core\Form\FormStateInterface;

/**
 * Update user information in backend.
 */
class UpdateUserRequest extends Request {

  protected const METHOD = 'POST';

  protected const PATH = 'api/v1/update_user';

  private FormStateInterface $formState;

  private array $fields;

  /**
   * Constructor.
   */
  public function __construct(FormStateInterface $formState, array $fields) {
    $this->formState = $formState;
    $this->fields = $fields;
  }

  /**
   * Update user request data to array.
   */
  public function toArray(): array {
    $data = [];
    // @todo Add email address.
    foreach ($this->fields as $field => $field_information) {
      if (isset($this->formState->{$field})) {
        $data['field_information']['external_field'] = $this->formState->{$field};
      }
    }
    return $data;
  }

}
