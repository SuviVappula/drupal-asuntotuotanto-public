<?php

namespace Drupal\Asuntotuotanto_public;

use Drupal\Core\TempStore\PrivateTempStore;

/**
 * Temporary data store.
 */
class Store {

  /**
   * Temporary store.
   *
   * @var \Drupal\Core\TempStore\PrivateTempStore
   */
  private PrivateTempStore $store;

  /**
   * Constructor.
   */
  public function __construct() {
    $this->store = \Drupal::service('tempstore.private')->get('user');
  }

  /**
   * Get value from datastore.
   *
   * @param string $key
   *   Key for the value.
   *
   * @return string
   *   A value for the key.
   */
  public function get(string $key): string {
    return $this->store->get($key);
  }

  /**
   * Set value to datastore.
   *
   * @param string $key
   *   The Key for the value.
   * @param string $value
   *   The value for the key.
   *
   * @throws \Drupal\Core\TempStore\TempStoreException
   */
  public function set(string $key, string $value) {
    $this->store->set($key, $value);
  }

}
