<?php

namespace Drupal\cache_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;

/**
 * Provides a page and examples of Cache API.
 *
 * @ingroup cache_example
 */
class TestController extends ControllerBase {

  /**
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   */
  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }


  /**
   * Display loggedin user name
   */
  public function content() {
    $build = [
      '#type' => 'markup',
      '#markup' => $this->t('Hello @name, welcome to the #cache example.', ['@name' => $this->currentUser->getAccountName()]),
      '#cache' => [
        'contexts' => [
          'user',
        ],
      ],
    ];
    return $build;
  }

  /**
   * Display list of nodes
   */
  public function getNodes() {
    $query = \Drupal::entityQuery('node')
      ->accessCheck(FALSE)
      ->condition('status', 1)
      ->range(0, 10);
    $nids = $query->execute();
    foreach ($nids as $nid) {
      $node = Node::load($nid);
      $items[] = $node->title->value;
    }

    if (!empty($items)) {
      $build = [
        '#theme' => 'item_list',
        '#list_type' => 'ul',
        '#title' => 'Latest Nodes',
        '#items' => $items,
        '#wrapper_attributes' => ['class' => 'container'],
        '#cache' => [
          'tags' => [
            'node_list',
          ],
        ],
      ];
    } else {
      $build = [
        '#type' => 'markup',
        '#markup' => $this->t('There is no content please add some content to display here.')
      ];
    }
    return $build;
  }
}

