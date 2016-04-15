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

    $build = [
      '#type' => 'markup',
      '#markup' => $this->t('Hi %name!', [
        '%name' => $current_user->getAccountName(),
      ]),
      '#cache' => [
        'keys' => ['mycachekey'],
        'contexts' => [
          // The "current user" is used above, which depends on the request,
          // so we tell Drupal to vary by the 'user' cache context.
          'user',
        ],
        'tags' => ['llamas:are:awesome:but:kittens:too'],
        'max-age' => Cache::PERMANENT,

      ],
    ];
  $renderer->addCacheableDependency($build, \Drupal\user\Entity\User::load($current_user->id()));
  return $build;
  }
}
