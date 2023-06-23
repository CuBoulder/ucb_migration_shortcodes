<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * The button shortcode.
 *
 * @Shortcode(
 *   id = "button",
 *   title = @Translation("Button"),
 * )
 */
class ButtonShortcode extends ShortcodeBase {

  /**
   * {@inheritdoc}
   */
  public function process(array $attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {

    // Merge with default attributes.
    $attributes = $this->getAttributes([
      'color' => '',
      'style' => '',
      'size' => '',
      'url' => '',
    ],
      $attributes
    );


    $output = [
      '#theme' => 'shortcode_button',
      '#url' => $attributes['url'],
      '#text' => $text,
      'color' => $attributes['color'],
      'style' => $attributes['style'],
      'size' => $attributes['size'],
    ];

    return $this->render($output);
  }
}
