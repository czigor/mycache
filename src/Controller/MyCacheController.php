<?php
/**
 * @file
 * Contains \Drupal\mycache\Controller\MyCacheController.
 *
 * @see https://www.drupal.org/developing/api/8/render/arrays/cacheability.
 */

namespace Drupal\mycache\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Cache\Cache;

class MyCacheController extends ControllerBase {
  public function content() {
    $renderer = \Drupal::service('renderer');
    $current_user = \Drupal::currentUser();
    $node = node_load(1);
    $build = [
      /*'#lazy_builder' => [
        'Drupal\mycache\Controller\MyCacheController:mycache_helo', [$current_user->getAccountName()],
      ],
      '#create_placeholder' => TRUE,*/
      '#type' => 'markup',
      '#markup' => $this->t('Hi @name! This is the title: @title', [
        '@name' => $current_user->getAccountName(),
        '@title' => $node->getTitle(),
       ]),
      '#cache' => [
        // Keys are used for identifying the cache entry.
        'keys' => ['mycache'],
        // For each user we want a separate cache entry.
        'contexts' => [
          'user',
        ],
        // We invalidate the cache when node:1 changes.
        'tags' => ['node:1'],
        'max-age' => Cache::PERMANENT,
      ],
    ];
    // This adds user object #cache metadata to our #cache array. (AFAIK in this
    // case it does not have any additional benefits since our contexts already
    // takes care of adding a user:uid cache tag and cache key but generally
    // it's good practice to add it here.)
    $renderer->addCacheableDependency($build, \Drupal\user\Entity\User::load($current_user->id()));
    return $build;
  }

  /**
   * #lazy_builder callback.
   */
  public function mycache_helo($name) {
    $node = node_load(1);
    return [
      '#markup' => t('Hi @name! This is the title: @title', ['@name' => $name, '@title' => $node->getTitle()]),
    ];
  }
}
