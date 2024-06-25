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

    $color = 'black';
    $style = 'default';
    $size = 'regular';

    $userColor = $attributes['color'];
    $userStyle = $attributes['style'];
    $userSize = $attributes['size'];

    if ($userColor == 'dark') {
      $color = 'black';
    }
    if ($userColor == 'light') {
      $color = 'white';
    }
    if ($userColor == 'gold') {
      $color = $userColor;
    }
    if ($userStyle == 'regular') {
      $style = 'default';
    }
    if ($userStyle == 'full') {
      $style = $userStyle;
    }
    if ($userSize == 'small' || $userSize == 'large') {
      $size = $userSize;
    }

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
      '#theme' => 'shortcode_give',
      '#link' => $attributes['url'],
      '#title' => $text,
      '#text' => $text,
      '#color' => $color,
      '#style' => $style,
      '#size' => $size,
      '#ico' => $attributes['icon'],
    ];
    return $this->render($output);
  }
}
