<?php

namespace Drupal\custom_plugin_type;

/**
 * An interface for all Sandwich type plugins.
 */
interface SandwichInterface {

  /**
   * Provide a description of the sandwich.
   *
   * @return string
   *   A string description of the sandwich.
   */
  public function description();

  /**
   * Provide the number of calories per serving for the sandwich.
   *
   * @return float
   *   The number of calories per serving.
   */
  public function calories();

  /**
   * Place an order for a sandwich.
   *
   * This is just an example method on our plugin that we can call to get
   * something back.
   *
   * @param array $extras
   *   An array of extra ingredients to include with this sandwich.
   *
   * @return string
   *   Description of the sandwich that was just ordered.
   */
  public function order(array $extras);

}
