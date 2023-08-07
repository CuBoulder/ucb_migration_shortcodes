<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Creat a box for content with a title and text area.
 *
 * @Shortcode(
 *   id = "countdown",
 *   title = @Translation("Countdown"),
 * )
 */
class CountdownShortcode extends ShortcodeBase {

  /**
   * {@inheritdoc}
   */
  public function process(array $attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {

    // Merge with default attributes.
    $attributes = $this->getAttributes([
      'style' => '',
      'background' => '',
      'size' => '',
    ],
      $attributes
    );

    $output = [
      '#theme' => 'shortcode_countdown',
      '#text' => $text,
      '#style' => $attributes['style'],
      '#background' => $attributes['background'],
      '#size' => $attributes['size'],
    ];
    return $this->render($output);
  }
}
