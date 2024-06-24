<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\Core\Render\RendererInterface;
use Drupal\shortcode\Plugin\ShortcodeBase;
use Drupal\ucb_migration_shortcodes\FontAwesome4to6Converter;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
   * The Font Awesome 4 to 6 converter.
   *
   * @var \Drupal\ucb_migration_shortcodes\FontAwesome4to6Converter
   */
  protected $faConverter;

  /**
   * Constructs a ButtonShortcode object.
   *
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   * @param \Drupal\ucb_migration_shortcodes\FontAwesome4to6Converter $faConverter
   *   The Font Awesome 4 to 6 converter.
   */
  public function __construct(RendererInterface $renderer, FontAwesome4to6Converter $faConverter) {
    $this->renderer = $renderer;
    $this->faConverter = $faConverter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('renderer'),
      $container->get('ucb_migration_shortcodes.font_awesome_converter')
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

    $color = 'blue';
    $style = 'default';
    $size = 'regular';

    $userColor = $attributes['color'];
    $userStyle = $attributes['style'];
    $userSize = $attributes['size'];

    // These are the supported non-default colors.
    if ($userColor == 'black' || $userColor == 'gray' || $userColor == 'white' || $userColor == 'gold') {
      $color = $userColor;
    }

    // These are the supported non-default styles.
    if ($userStyle == 'full') {
      $style = $userStyle;
    }

    // These are the supported non-default sizes.
    if ($userSize == 'small' || $userSize == 'large') {
      $size = $userSize;
    }

    $output = [
      '#theme' => 'shortcode_button',
      '#link' => $attributes['url'],
      '#text' => [
        '#markup' => $processed_text,
      ],
      '#color' => $color,
      '#style' => $style,
      '#size' => $size,
      '#ico' => $this->faConverter->convert($attributes['icon']),
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
  protected function processNestedShortcodes($text, $langcode) {
    $shortcode_tags = [
      // Here's where we can put allowed shortcodes.
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
