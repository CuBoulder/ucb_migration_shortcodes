<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * The buttongroup shortcode.
 *
 * @Shortcode(
 *   id = "buttongroup",
 *   title = @Translation("Button Group"),
 * )
 */
class ButtonGroupShortcode extends ShortcodeBase {

  /**
   * {@inheritdoc}
   */
  public function process(array $attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {

    // Merge with default attributes.
    $attributes = $this->getAttributes([
      'color' => '',
      'size' => '',
    ],
      $attributes
    );

    $output = [
      '#theme' => 'shortcode_buttongroup',
      '#text' => $text,
      '#color' => $attributes['color'],
      '#size' => $attributes['size'],
    ];
    return $this->render($output);
  }
}
