<?php

namespace Drupal\lazy_builder_example\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\user\Entity\User;

/**
 * Provides a block to show lazy building in action.
 *
 * @Block(
 *   id = "lazyblock",
 *   admin_label = @Translation("Lazy block"),
 * )
 */
class LazyBuilderBlock extends BlockBase implements ContainerFactoryPluginInterface, TrustedCallbackInterface {
    
  protected $currentUser;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
    $configuration,
    $plugin_id,
    $plugin_definition,
    $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $build['dynamic_user_content'] = [
      '#lazy_builder' => [
        self::class . '::printUserDetails',
        [
          $this->currentUser->id(),
        ]
      ],
    ];
    return $build;
  }

  public static function trustedCallbacks() {
    return [
        'printUserDetails'
    ];
  }

  public static function printUserDetails($uid) {
    $build = [];

    $account = User::load($uid);
    $t = \Drupal::translation();
    $build['lazy_builder_username'] = [
      '#markup' => '<p>' . $t->translate('Hi @name', ['@name' => $account->getDisplayName()]) . '</p>',
    ];
    $build['lazy_builder_memberfor'] = [
      '#markup' => '<p>' . $t->translate('Member for: @time', ['@time' => \Drupal::service('date.formatter')->formatTimeDiffSince($account->getCreatedTime())]) . '</p>',
    ];
    $build['#cache'] = [
      'contexts' => [
        'user',
      ],
    ];
    return $build;
  }
  
}
