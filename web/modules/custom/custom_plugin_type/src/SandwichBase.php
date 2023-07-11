<?php

namespace Drupal\custom_plugin_type;

use Drupal\Component\Plugin\PluginBase;

/**
 * A base class to help developers implement their own sandwich plugins.
 *
 * We intentionally declare our base class as abstract, and don't implement the
 * order() method required by \Drupal\custom_plugin_type\SandwichInterface.
 * This way even if they are using our base class, developers will always be
 * required to define an order() method for their custom sandwich type.
 *
 * @see \Drupal\custom_plugin_type\Annotation\Sandwich
 * @see \Drupal\custom_plugin_type\SandwichInterface
 */
abstract class SandwichBase extends PluginBase implements SandwichInterface {

  /**
   * {@inheritdoc}
   */
  public function description() {
    // Retrieve the @description property from the annotation and return it.
    return $this->pluginDefinition['description'];
  }

  /**
   * {@inheritdoc}
   */
  public function calories() {
    // Retrieve the @calories property from the annotation and return it.
    return (float) $this->pluginDefinition['calories'];
  }

  /**
   * {@inheritdoc}
   */
  abstract public function order(array $extras);

}
