<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Render\RendererInterface;

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
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a ButtonShortcode object.
   *
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(RendererInterface $renderer) {
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('renderer')
    );
  }

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
    ], $attributes);

    // Process nested shortcodes in the text content manually.
    $processed_text = $this->processNestedShortcodes($text, $langcode);

    $output = [
      '#theme' => 'shortcode_button',
      '#link' => $attributes['url'],
      '#title' => strip_tags($processed_text),
      '#text' => [
        '#markup' => $processed_text,
      ],
      '#color' => $attributes['color'],
      '#style' => $attributes['style'],
      '#size' => $attributes['size'],
      '#ico' => $attributes['icon'],
    ];

    return $this->renderer->renderRoot($output);
  }

  /**
   * Process nested shortcodes manually.
   *
   * @param string $text
   *   The text containing shortcodes.
   * @param string $langcode
   *   The language code.
   *
   * @return string
   *   The processed text with shortcodes rendered.
   */
  // Simple shortcode processing logic.
  protected function processNestedShortcodes($text, $langcode) {
    $shortcode_tags = [
      // Here's where we can put allowed shortcodes
      'icon' => 'Drupal\ucb_migration_shortcodes\Plugin\Shortcode\IconShortcode',
    ];

    foreach ($shortcode_tags as $tag => $class) {
      $pattern = '/\[' . $tag . '([^\]]*)\](.*?)\[\/' . $tag . '\]/';
      if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
          $attributes = $this->parseAttributes($match[1]);
          $content = $match[2];
          $shortcode = new $class();
          $render_array = $shortcode->process($attributes, $content, $langcode);
          $replacement = $this->renderer->renderRoot($render_array);
          $text = str_replace($match[0], $replacement, $text);
        }
      }
    }

    return $text;
  }

  /**
   * Parse shortcode attributes.
   *
   * @param string $attribute_string
   *   The attribute string.
   *
   * @return array
   *   The parsed attributes.
   */
  protected function parseAttributes($attribute_string) {
    $attributes = [];
    preg_match_all('/(\w+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?/', $attribute_string, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      $attributes[$match[1]] = $match[2];
    }
    return $attributes;
  }
}
