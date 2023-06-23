<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * The give shortcode.
 *
 * @Shortcode(
 *   id = "give",
 *   title = @Translation("Give"),
 * )
 */
class GiveShortcode extends ShortcodeBase {

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
