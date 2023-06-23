<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Creat a box for content with a title and text area.
 *
 * @Shortcode(
 *   id = "callout",
 *   title = @Translation("Call Out"),
 * )
 */
class CalloutShortcode extends ShortcodeBase {

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

    $output = [
      '#theme' => 'shortcode_callout',
      '#text' => $text,
      '#size' => $attributes['size'],
    ];
    return $this->render($output);
  }
}
