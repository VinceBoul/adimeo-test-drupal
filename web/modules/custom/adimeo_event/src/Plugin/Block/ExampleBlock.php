<?php

namespace Drupal\adimeo_event\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "adimeo_event_example",
 *   admin_label = @Translation("Example"),
 *   category = @Translation("Adimeo Event")
 * )
 */
class ExampleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      // You can get nid and anything else you need from the node object.
      $nid = $node->id();
      $node = Node::load($nid);
      /**
       * @var Term $term
       */
      $term = $node->get('field_event_type')->first()
        ->get('entity')
        ->getTarget()
        ->getValue();

      $now = new DrupalDateTime('');

      $query = \Drupal::entityQuery('node');
      $query
        ->condition('type', 'event')
        ->condition('field_event_type.entity:taxonomy_term.tid', $term->id())
        ->condition('nid', $nid, '<>')
        ->condition('field_date_end', $now, '>')
        ->sort('field_date_start', 'ASC');

      $build['#relatedEvents'] = Node::loadMultiple($query->execute());

      $otherNids = [];
      if (count($build['#relatedEvents']) < 3){

        $query = \Drupal::entityQuery('node');
        $query
          ->condition('type', 'event')
          ->condition('field_event_type.entity:taxonomy_term.tid', $term->id(), '<>')
          ->condition('field_date_end', $now, '>')
          ->sort('field_date_start', 'ASC')
          ->range(0, 3-count($build['#relatedEvents']));

        $build['#otherEvents'] = Node::loadMultiple($query->execute());
      }
    }

    $build['#theme'] = 'event_block';
    return $build;
  }

}
