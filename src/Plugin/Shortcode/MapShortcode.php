<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Creat a map for content with a title and text area.
 *
 * @Shortcode(
 *   id = "map",
 *   title = @Translation("Map"),
 * )
 */
class MapShortcode extends ShortcodeBase {

  /**
   * {@inheritdoc}
   */
  public function process(array $attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {

    // Merge with default attributes.
    $attributes = $this->getAttributes([
      'size' => '',
    ],
      $attributes
    );

    $parts = parse_url($text);
    parse_str($parts['query'], $query);
    $maplocation = $query['pb'];


    $output = [
      '#theme' => 'shortcode_map',
      '#text' => $text,
      '#size' => $attributes['size'],
      '#maplocation' => $maplocation,
    ];
    return $this->render($output);
  }
}
