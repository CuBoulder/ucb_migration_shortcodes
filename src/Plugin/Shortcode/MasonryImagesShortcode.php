<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Creat a box for content with a title and text area.
 *
 * @Shortcode(
 *   id = "masonry-images",
 *   title = @Translation("Masonry Images"),
 * )
 */
class MasonryImagesShortcode extends ShortcodeBase {

  /**
   * {@inheritdoc}
   */
  public function process(array $attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    
    // Merge with default attributes.
    $attributes = $this->getAttributes([
      'columns' => '',
    ],
      $attributes
    );

    $output = [
      '#theme' => 'shortcode_masonryimages',
      '#columns' => $attributes['columns'],
      '#text' => $text,
    ];
    return $this->render($output);
  }
}
