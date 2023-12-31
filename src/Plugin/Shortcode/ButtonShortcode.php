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
      'url' => '',
      'color' => '',
      'style' => '',
      'size' => '',
      'icon' => '',
    ],
      $attributes
    );

    $output = [
      '#theme' => 'shortcode_button',
      '#link' => $attributes['url'],
      '#title' => $text,
      '#text' => $text,
      '#color' => $attributes['color'],
      '#style' => $attributes['style'],
      '#size' => $attributes['size'],
      '#ico' => $attributes['icon'],
    ];
    return $this->render($output);
  }
}
