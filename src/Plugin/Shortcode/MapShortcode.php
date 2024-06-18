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
    $attributes = $this->getAttributes(
      [
        'size' => '',
      ],
      $attributes
    );

    $parts = parse_url($text);
    parse_str($parts['query'], $query);
    $mapLocation = '';
    $mapFragment = '';
    if (array_key_exists("pb", $query)) {
      $mapLocation = $query['pb'];
    }
    elseif (array_key_exists("id", $query)) {
      $mapLocation = $query['id'];
      $mapFragment = $parts['fragment'];
      preg_match('/m\/(\d+)/', $mapFragment, $mapFragment, PREG_OFFSET_CAPTURE);
      $mapFragment = $mapFragment[1][0];
    }
    else {
      $mapLocation = 'none';
    }

    $size = $attributes['size'];
    $output = [
      '#theme' => 'shortcode_map',
      '#text' => $text,
      '#size' => $size == 'small' || $size == 'medium' || $size == 'large' ? $size : 'small',
      '#maplocation' => $mapLocation,
      '#mapfragment' => $mapFragment,
    ];
    return $this->render($output);
  }

}
