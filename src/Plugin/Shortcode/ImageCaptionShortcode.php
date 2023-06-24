<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Creat a box for content with a title and text area.
 *
 * @Shortcode(
 *   id = "imagecaption",
 *   title = @Translation("Image Caption"),
 * )
 */
class ImageCaptionShortcode extends ShortcodeBase {

  /**
   * {@inheritdoc}
   */
  public function process(array $attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {

    // Merge with default attributes.
    $attributes = $this->getAttributes([
      'align' => '',
    ],
      $attributes
    );

    $output = [
      '#theme' => 'shortcode_imagecaption',
      '#text' => $text,
      '#align' => $attributes['align'],
    ];
    return $this->render($output);
  }
}
