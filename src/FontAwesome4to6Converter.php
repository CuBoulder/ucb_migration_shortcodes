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
    $data = Yaml::parseFile($this->extensionPathResolver->getPath('module', 'ucb_migration_shortcodes') . '/libraries/fontawesome' . $faVersion . '/metadata/conversion.yml');
    $this->dataCache->set($cacheId, $data);
    return $data;
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
    $icons = $this->getFontAwesomeIcons();
    $conversions = $this->getFontAwesomeConversions();
    $fa4ClassNames = preg_split('/\s+/', $faClasses);
    $fa6ClassNames = [];
    $iconMatched = FALSE;
    foreach ($fa4ClassNames as $fa4ClassName) {
      if (preg_match('/fa-((2xs|xs|sm|lg|xl|2xl|([0-9]|10)x)|beat-fade|bounce|border|fade|flip-(horizontal|vertical|both)|fw|inverse|li|pull-(left|right)|rotate-(90|180|270|by)|shake|spin(-(pulse|reverse))?|sr-only(-focusable)?|stack(-(1|2)x)?|ul)/', $fa4ClassName)) {
        // Matches a non-icon Font Awesome class supported in Font Awesome 6.
        // Not all of these are valid for icons but it's unlikely most of them
        // will be present.
        $fa6ClassNames[] = $fa4ClassName;
      }
      elseif (!$iconMatched && preg_match('/fa-([a-z0-9\-]+)/', $fa4ClassName, $faMatch)) {
        // Matches an icon Font Awesome class.
        $fa4IconName = $faMatch[1];
        if (isset($conversions[$fa4IconName])) {
          $conversion = $conversions[$fa4IconName];
          $fa6ClassNames[] = $conversion['style'];
          $fa6ClassNames[] = 'fa-' . $conversion['name'];
        }
        elseif (isset($icons[$fa4IconName])) {
          $icon = $icons[$fa4IconName];
          $fa6ClassNames[] = 'fa-' . $icon['styles'][0] ?? 'solid';
          $fa6ClassNames[] = 'fa-' . $fa4IconName;
        }
        else {
          $fa6ClassNames[] = 'fa-solid';
          $fa6ClassNames[] = 'fa-' . $fa4IconName;
        }
        $iconMatched = TRUE;
      }
    }
    if (!$iconMatched) {
      // No icon specified, still have it recognized as an icon widget.
      $fa6ClassNames[] = 'fa-solid';
    }
    return implode(' ', $fa6ClassNames);
  }

}
