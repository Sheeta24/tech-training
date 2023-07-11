<?php

namespace Drupal\custom_plugin_type\Plugin\Sandwich;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\custom_plugin_type\SandwichBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a meatball sandwich.
 *
 * @Sandwich(
 *   id = "meatball_sandwich",
 *   description = @Translation("Italian style meatballs drenched in irresistible marinara sauce, served on freshly baked bread."),
 *   calories = "1200"
 * )
 */
class ExampleMeatballSandwich extends SandwichBase implements ContainerFactoryPluginInterface {

  use StringTranslationTrait;

  /**
   * The day the sandwich is ordered.
   *
   * Since meatball sandwiches have a special behavior on Sundays, and since we
   * want to test that behavior on days other than Sunday, we have to store the
   * day as a property so we can test it.
   *
   * This is the string representation of the day of the week you get from
   * date('D').
   *
   * @var string
   */
  protected $day;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {

    $sandwich = new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('string_translation')
    );
    return $sandwich;
  }

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TranslationInterface $translation) {
    $this->setStringTranslation($translation);
    $this->day = date('D');
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function order(array $extras) {
    $ingredients = ['meatballs', 'irresistible marinara sauce'];
    $sandwich = array_merge($ingredients, $extras);
    return 'You ordered an ' . implode(', ', $sandwich) . ' sandwich. Enjoy!';
  }

  /**
   * {@inheritdoc}
   */
  public function description() {
    // We override the description() method in order to change the description
    // text based on the date. On Sunday we only have day old bread.
    if ($this->day == 'Sun') {
      return $this->t("Italian style meatballs drenched in irresistible marinara sauce, served on day old bread.");
    }
    return parent::description();
  }

}
