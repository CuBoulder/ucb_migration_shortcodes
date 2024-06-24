<?php

namespace Drupal\ucb_migration_shortcodes;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ExtensionPathResolver;
use Symfony\Component\Yaml\Yaml;

/**
 * Contains helper methods for converting Font Awesome icons.
 */
class FontAwesome4to6Converter {

  /**
   * The data cache.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $dataCache;

  /**
   * The extension path resolver.
   *
   * @var \Drupal\Core\Extension\ExtensionPathResolver
   */
  protected $extensionPathResolver;

  /**
   * Constructs a FontAwesome4to6Converter object.
   *
   * @param \Drupal\Core\Cache\CacheBackendInterface $data_cache
   *   The data cache.
   * @param \Drupal\Core\Extension\ExtensionPathResolver $extensionPathResolver
   *   The extension path resolver.
   */
  public function __construct(CacheBackendInterface $data_cache, ExtensionPathResolver $extensionPathResolver) {
    $this->dataCache = $data_cache;
    $this->extensionPathResolver = $extensionPathResolver;
  }

  /**
   * Gets the Font Awesome icon metadata.
   *
   * @return array
   *   The Font Awesome icon metadata.
   *
   * @see \Drupal\ckeditor5_icons\CKEditor5Icons::getFontAwesomeIcons()
   *   Uses a modified version of this method.
   */
  protected function getFontAwesomeIcons() {
    $faVersion = '6';
    $cacheId = 'ucb_migration_shortcodes.fontawesome' . $faVersion . '.icons';
    $cached = $this->dataCache->get($cacheId);
    if ($cached) {
      return $cached->data;
    }
    $data = array_map(function ($icon) {
      return [
        'styles' => $icon['styles'],
        'label' => $icon['label'],
      ];
    }, Yaml::parseFile($this->extensionPathResolver->getPath('module', 'ucb_migration_shortcodes') . '/libraries/fontawesome' . $faVersion . '/metadata/icons.yml'));
    $this->dataCache->set($cacheId, $data);
    return $data;
  }

  /**
   * Gets the Font Awesome conversion metadata.
   *
   * @return array
   *   The Font Awesome conversion metadata.
   */
  protected function getFontAwesomeConversions() {
    $faVersion = '6';
    $cacheId = 'ucb_migration_shortcodes.fontawesome' . $faVersion . '.conversions';
    $cached = $this->dataCache->get($cacheId);
    if ($cached) {
      return $cached->data;
    }
    $data = array_map(function ($icon) {
      return [
        'style' => $this->shimPefixToFontAwesome6Style($icon['prefix']),
        'name' => $icon['name'],
      ];
    }, Yaml::parseFile($this->extensionPathResolver->getPath('module', 'ucb_migration_shortcodes') . '/libraries/fontawesome' . $faVersion . '/metadata/shims.yml'));
    $this->dataCache->set($cacheId, $data);
    return $data;
  }

  /**
   * Converts the shim prefix to a valid Font Awesome 6 style.
   *
   * @param string|null $prefix
   *   The shim prefix.
   *
   * @return string
   *   The Font Awesome 6 style.
   */
  protected function shimPefixToFontAwesome6Style($prefix) {
    switch ($prefix) {
      case 'far':
        return 'fa-regular';

      case 'fab':
        return 'fa-brands';

      default:
        return 'fa-solid';
    }
  }

  /**
   * Converts Font Awesome 4 icon classes to Font Awesome 6 icon classes.
   *
   * @param string|null $faClasses
   *   The Font Awesome 4 CSS class name.
   *
   * @return string
   *   The Font Awesome 6 CSS class name.
   *
   * @todo Implement the conversion.
   */
  public function convert($faClasses) {
    if (!$faClasses) {
      return '';
    }
    return 'fa ' . $faClasses;
  }

}
