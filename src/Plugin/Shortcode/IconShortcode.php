<?php

namespace Drupal\ucb_migration_shortcodes\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\Core\Render\RendererInterface;
use Drupal\shortcode\Plugin\ShortcodeBase;
use Drupal\ucb_migration_shortcodes\FontAwesome4to6Converter;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Creat a icon for content with a title and text area.
 *
 * @Shortcode(
 *   id = "icon",
 *   title = @Translation("Icon"),
 * )
 */
class IconShortcode extends ShortcodeBase {

  /**
   * The Font Awesome 4 to 6 converter.
   *
   * @var \Drupal\ucb_migration_shortcodes\FontAwesome4to6Converter
   */
  protected $faConverter;

  /**
   * Constructs an IconShortcode object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   * @param \Drupal\ucb_migration_shortcodes\FontAwesome4to6Converter $faConverter
   *   The Font Awesome 4 to 6 converter.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RendererInterface $renderer, FontAwesome4to6Converter $faConverter) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $renderer);
    $this->faConverter = $faConverter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
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
      'shape' => '',
      'color' => '',
      'size' => '',
      'pull' => '',
      'wrapper' => '',
    ], $attributes);

    $color = '';
    $size = '';
    $pull = '';
    $wrapper = '';

    $userColor = $attributes['color'];
    $userSize = $attributes['size'];
    $userPull = $attributes['pull'];
    $userWrapper = $attributes['wrapper'];

    // These are the supported non-default colors.
    if ($userColor == 'black' || $userColor == 'white' || $userColor == 'gray' || $userColor == 'gold') {
      $color = $userColor;
    }
    elseif ($userColor == 'light-gray') {
      $color = 'lightgray';
    }
    elseif ($userColor == 'dark-gray') {
      $color = 'darkgray';
    }

    // These are the supported non-default sizes.
    if (preg_match('/fa-(2xs|xs|sm|lg|xl|2xl|([0-9]|10)x)/', $userSize)) {
      $size = $userSize;
    }

    // These are the supported non-default pulls.
    if ($userPull == 'left' || $userPull == 'right') {
      $pull = $userPull;
    }

    // These are the supported non-default wrappers.
    if ($userWrapper == 'square' || $userWrapper == 'circle') {
      $wrapper = $userWrapper;
    }
    elseif ($userWrapper == 'rounded') {
      $wrapper = 'square-rounded';
    }

    $output = [
      '#theme' => 'shortcode_icon',
      '#shape' => $this->faConverter->convert($attributes['shape']),
      '#text' => $text,
      '#color' => $color,
      '#size' => $size,
      '#pull' => $pull,
      '#wrapper' => $wrapper,
    ];

    return $this->render($output);
  }

}
