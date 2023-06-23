<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Creat a icon for content with a title and text area.
 *
 * @Shortcode(
 *   id = "icon",
 *   title = @Translation("Icon"),
 * )
 */
class IconShortcode extends ShortcodeBase {

  /**
   * {@inheritdoc}
   */
  public function process(array $attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {

    // Merge with default attributes.
    $attributes = $this->getAttributes([
      'shape' => '',
      'color' => '',
      'size' => '',
      'wrapper' => '',
    ],
      $attributes
    );

    $output = [
      '#theme' => 'shortcode_icon',
      '#shape' => $attributes['shape'],
      '#text' => $text,
      '#color' => $attributes['color'],
      '#size' => $attributes['size'],
      '#wrapper' => $attributes['wrapper'],
    ];
    return $this->render($output);
  }
}
