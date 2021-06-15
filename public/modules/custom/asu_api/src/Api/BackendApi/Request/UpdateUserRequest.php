<?php

namespace Drupal\asu_api\Api\BackendApi\Request;

use Drupal\asu_api\Api\Request;
use Drupal\Core\Form\FormStateInterface;

/**
 * Update user information in backend.
 */
class UpdateUserRequest extends Request {

  protected const METHOD = 'PUT';

  protected const PATH = 'v1/profiles/';

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
    foreach ($this->fields as $fieldName => $field_information) {
      if (isset($this->formState->{$fieldName})) {
        $data[] = $this->formState->{$fieldName};
      }
    }
    return $data;
  }

}
