<?php

namespace Drupal\test_adimeo\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an eventsblock block.
 *
 * @Block(
 *   id = "test_adimeo_eventsblock",
 *   admin_label = @Translation("EventsBlock"),
 *   category = @Translation("Custom")
 * )
 */
class EventsblockBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
