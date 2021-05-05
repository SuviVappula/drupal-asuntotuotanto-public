<?php

namespace Drupal\asuntotuotanto_public;

use Drupal\Core\Field\FieldItemList;
use Drupal\Core\TypedData\ComputedItemListTrait;

/**
 * Handles external data computing for custom field.
 */
class ExternalData extends FieldItemList {
  use ComputedItemListTrait;

  /**
   * Compute the value.
   */
  protected function computeValue() {
  }

  /**
   * Computes the calculated values for this item list.
   *
   * In this example, there is only a single item/delta for this field.
   *
   * The ComputedItemListTrait only calls this once on the same instance; from
   * then on, the value is automatically cached in $this->items, for use by
   * methods like getValue().
   */
  protected function ensurePopulated() {
    if (!isset($this->list[0])) {
      $this->list[0] = $this->createItem(0);
    }
  }

}
