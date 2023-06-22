<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Creat a box for content with a title and text area.
 *
 * @Shortcode(
 *   id = "box",
 *   title = @Translation("Box"),
 *   description = @Translation("Replace the given text formatted like as a quote.")
 * )
 */
class BoxShortcode extends ShortcodeBase {

  /**
   * {@inheritdoc}
   */
  public function process(array $attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {

    // Merge with default attributes.
    $attributes = $this->getAttributes([
      'title' => '',
      'color' => '',
      'style' => '',
      'float' => '',
    ],
      $attributes
    );

    $output = [
      '#theme' => 'shortcode_box',
      '#title' => $attributes['title'],
      '#text' => $text,
      '#color' => $attributes['color'],
      '#style' => $attributes['style'],
      '#float' => $attributes['float'],
    ];
    return $this->render($output);
  }
}
