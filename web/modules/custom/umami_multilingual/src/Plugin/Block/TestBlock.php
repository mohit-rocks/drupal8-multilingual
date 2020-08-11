<?php

namespace Drupal\umami_multilingual\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'TestBlock' block.
 *
 * @Block(
 *  id = "test_block",
 *  admin_label = @Translation("Test block"),
 * )
 */
class TestBlock extends BlockBase {


  public function build() {
    $build = [];
    $text_1 = $this->t('Hello World', [], ['context' => 'String-1']);
    $text_2 = $this->t('Hello World', [], ['context' => 'String-2']);

    return [
      '#theme' => 'item_list',
      '#items' => [$text_1, $text_2],
    ];
  }

}
