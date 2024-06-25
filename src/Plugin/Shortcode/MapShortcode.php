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
      if (preg_match('/m\/(\d+)/', $parts['fragment'], $fragment, PREG_OFFSET_CAPTURE)) {
        // Matches a campus map.
        $mapFragment = $fragment[1][0];
      }
      elseif (array_key_exists('amp;mrkIid', $query)) {
        // Old-style campus map URL that doesn't work anymore, but an instance
        // was found in prod.
        $mapFragment = preg_replace('/\D/', '', $query['amp;mrkIid']);
      }
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
