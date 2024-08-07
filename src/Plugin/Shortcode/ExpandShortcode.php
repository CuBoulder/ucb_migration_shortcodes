<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Creat a box for content with a title and text area.
 *
 * @Shortcode(
 *   id = "expand",
 *   title = @Translation("Expand"),
 * )
 */
class ExpandShortcode extends ShortcodeBase {

  /**
   * {@inheritdoc}
   */
  public function process(array $attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {

    // Merge with default attributes.
    $attributes = $this->getAttributes([
      'title' => '',
      'style' => '',
    ], $attributes);

    $output = [
      '#theme' => 'shortcode_expand',
      '#text' => [
        '#markup' => $text,
      ],
      '#title' => [
        '#markup' => $attributes['title'],
      ],
      '#style' => $attributes['style'],
    ];
    return $this->render($output);
  }

}
