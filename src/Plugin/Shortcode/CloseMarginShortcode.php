<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Creat a box for content with a title and text area.
 *
 * @Shortcode(
 *   id = "close-margin",
 *   title = @Translation("Close Margin"),
 * )
 */
class CloseMarginShortcode extends ShortcodeBase {

  /**
   * {@inheritdoc}
   */
  public function process(array $attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {

    $output = [
      '#theme' => 'shortcode_closemargin',
      '#text' => $text,
    ];
    return $this->render($output);
  }
}
