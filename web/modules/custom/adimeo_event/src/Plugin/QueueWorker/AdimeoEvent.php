<?php

namespace Drupal\adimeo_event\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\node\Entity\Node;

/**
 * Defines 'adimeo_event_eventqueue' queue worker.
 *
 * @QueueWorker(
 *   id = "adimeo_event_eventqueue",
 *   title = @Translation("EventQueue"),
 *   cron = {"time" = 60}
 * )
 */
class AdimeoEvent extends QueueWorkerBase {

  /**
   * @var Node $data
   * {@inheritdoc}
   */
  public function processItem($data) {
    $data->setUnpublished()->save();
  }

}
