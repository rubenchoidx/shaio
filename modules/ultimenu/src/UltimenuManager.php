<?php

namespace Drupal\ultimenu;

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\Unicode;
use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\system\Entity\Menu;
use Drupal\Core\Menu\MenuActiveTrailInterface;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

/**
 * Manages Ultimenu plugin.
 *
 * @see plugin_api
 */
class UltimenuManager extends DefaultPluginManager implements UltimenuManagerInterface {

  use StringTranslationTrait;

  /**
   * Config Factory Service Object.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The theme handler.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * The menu link tree manager.
   *
   * @var \Drupal\Core\Menu\MenuLinkTreeInterface
   */
  protected $menuTree;

  /**
   * The active menu trail service.
   *
   * @var \Drupal\Core\Menu\MenuActiveTrailInterface
   */
  protected $menuActiveTrail;

  /**
   * Static cache of skins.
   *
   * @var array
   */
  protected $skins;

  /**
   * Constructs a UltimenuManager object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler.
   * @param \Drupal\Core\Menu\MenuLinkTreeInterface $menu_tree
   *   The menu tree manager.
   * @param \Drupal\Core\Menu\MenuActiveTrailInterface $menu_active_trail
   *   The active menu trail service.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $translation
   *   The string translation service.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   The cache backend.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ModuleHandlerInterface $module_handler, ThemeHandlerInterface $theme_handler, MenuLinkTreeInterface $menu_tree, MenuActiveTrailInterface $menu_active_trail, TranslationInterface $translation, CacheBackendInterface $cache_backend) {
    $this->configFactory = $config_factory;
    $this->moduleHandler = $module_handler;
    $this->themeHandler = $theme_handler;
    $this->menuTree = $menu_tree;
    $this->menuActiveTrail = $menu_active_trail;
    $this->setCacheBackend($cache_backend, 'ultimenu', ['ultimenu']);
    $this->alterInfo('ultimenu_info');
  }

  /**
   * {@inheritdoc}
   */
  public function getThemeHandler() {
    return $this->themeHandler;
  }

  /**
   * {@inheritdoc}
   */
  public function getModuleHandler() {
    return $this->moduleHandler;
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig($config = 'ultimenu.settings') {
    return $this->configFactory->get($config);
  }

  /**
   * {@inheritdoc}
   */
  public function getSetting($setting_name = NULL) {
    return $this->getConfig()->get($setting_name);
  }

  /**
   * {@inheritdoc}
   */
  public function getMenus() {
    $menus = &drupal_static(__METHOD__);
    if (!isset($menus)) {
      if ($custom_menus = Menu::loadMultiple()) {
        foreach ($custom_menus as $menu_name => $menu) {
          $custom_menus[$menu_name] = Html::escape($menu->label());
        }
      }

      $exclude_menus = [
        'admin' => $this->t('Administration'),
        'devel' => $this->t('Development'),
        'tools' => $this->t('Tools'),
      ];

      $menus = array_diff_key($custom_menus, $exclude_menus);
      asort($menus);
    }
    return $menus;
  }

  /**
   * {@inheritdoc}
   */
  public function getUltimenuBlocks() {
    $items = &drupal_static(__METHOD__, NULL);

    if (!isset($items)) {
      $items = [];
      $menus = $this->getMenus();
      foreach ($menus as $delta => $name) {
        if ($this->getEnabledBlocks($delta)) {
          $items[$delta] = $this->t('@name', ['@name' => $name]);
        }
      }
      asort($items);
    }

    return $items;
  }

  /**
   * {@inheritdoc}
   */
  public function getEnabledBlocks($delta) {
    $blocks = $this->getSetting('blocks');
    if (!empty($blocks[$delta])) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getRegionKey($menu_name, $key, $title, $max_length = 28) {
    $goodies = $this->getSetting('goodies');
    $is_mlid = isset($goodies['ultimenu-mlid']) && $goodies['ultimenu-mlid'];
    $menu_name = $this->truncateRegionKey($menu_name, $max_length);
    list(, $uuid) = array_pad(array_map('trim', explode(":", $key, 2)), 2, NULL);
    list($shortened_uuid,) = array_pad(array_map('trim', explode("-", $uuid, 2)), 2, NULL);
    $menu_item = $is_mlid ? $shortened_uuid : $this->truncateRegionKey(strip_tags($title), $max_length);
    $region_key = 'ultimenu_' . $menu_name . '_' . $menu_item;

    return $region_key;
  }

  /**
   * {@inheritdoc}
   */
  public function getSkinPath($path) {
    $skin_path = &drupal_static(__METHOD__, NULL);
    if (!$skin_path) {
      $skin_path = '';
      list(, $skin_name) = array_pad(array_map('trim', explode("|", $path, 2)), 2, NULL);

      if (strpos($path, "module|") !== FALSE) {
        $skin = drupal_get_path('module', 'ultimenu') . '/skins';
        $skin_path = $skin . '/' . $skin_name . '.css';
      }
      elseif (strpos($path, "custom|") !== FALSE) {
        $skin = $this->getSetting('skins');
        $skin_path = $skin . '/' . $skin_name . '.css';
      }
      elseif (strpos($path, "theme|") !== FALSE) {
        $theme_default = $this->getConfig('system.theme')->get('default');
        $skin = drupal_get_path('theme', $theme_default) . '/css/ultimenu';
        $skin_path = $skin . '/' . $skin_name . '.css';
      }

      if ($skin_path) {
        $skin_path = '/' . $skin_path;
      }
    }
    return $skin_path;
  }

  /**
   * {@inheritdoc}
   */
  public function getSkinName($path) {
    $skin_name = \Drupal::service('file_system')->basename($path, '.css');
    $skin_basename = str_replace("ultimenu--", "", $skin_name);
    $skin_basename = str_replace("-", "_", $skin_basename);

    return $skin_basename;
  }

  /**
   * {@inheritdoc}
   */
  public function truncateRegionKey($string, $max_length = 28) {
    // Transliterate the string.
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $trans = \Drupal::transliteration();
    $transformed = $trans->transliterate($string, $langcode);

    // Decode it.
    $transformed = Html::decodeEntities($transformed);
    $transformed = Unicode::strtolower(str_replace(array('menu-', '-menu'), '', $transformed));
    $transformed = preg_replace('/[\W\s]+/', '_', $transformed);

    // Trim trailing underscores.
    $transformed = trim($transformed, '_');
    $transformed = Unicode::truncate($transformed, $max_length, TRUE, FALSE);
    return $transformed;
  }

  /**
   * {@inheritdoc}
   */
  public function loadMenuTree($menu_name) {
    $menu_tree = $this->menuTree;

    $parameters = new MenuTreeParameters();
    $parameters->setTopLevelOnly()->onlyEnabledLinks();

    $tree = $menu_tree->load($menu_name, $parameters);
    $manipulators = array(
      array('callable' => 'menu.default_tree_manipulators:checkAccess'),
      array('callable' => 'menu.default_tree_manipulators:generateIndexAndSort'),
      array('callable' => 'menu.default_tree_manipulators:flatten'),
    );
    $tree = $menu_tree->transform($tree, $manipulators);

    return $tree;
  }

  /**
   * {@inheritdoc}
   */
  public function loadSubMenuTree($menu_name, $link_id = '', $title = '') {
    $build = [];
    if (empty($link_id)) {
      return $build;
    }

    $level = 1;
    $depth = 4;

    $menu_tree = $this->menuTree;

    $parameters = $this->menuTree->getCurrentRouteMenuTreeParameters($menu_name);
    $parameters->setRoot($link_id)->excludeRoot()->onlyEnabledLinks();
    $parameters->setMaxDepth(min($level + $depth - 1, $this->menuTree->maxDepth()));

    $tree = $menu_tree->load($menu_name, $parameters);
    $manipulators = array(
      array('callable' => 'menu.default_tree_manipulators:checkAccess'),
      array('callable' => 'menu.default_tree_manipulators:generateIndexAndSort'),
    );
    $tree = $menu_tree->transform($tree, $manipulators);

    if ($tree) {
      $build['content'] = $menu_tree->build($tree);
      $css_name = Html::cleanCssIdentifier(Unicode::strtolower($menu_name . '-' . $title));
      $build['#attributes']['class'] = array('ultimenusub', 'ultimenusub--' . $css_name);
      $build['#theme_wrappers'][] = 'container';
    }

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildMenuTree($menu_name, array $config) {
    $tree = $this->loadMenuTree($menu_name);
    $submenu_enabled = !empty($config['submenu']);

    $ultimenu = [];
    foreach ($tree as $key => $data) {
      // Generally we only deal with visible links, but just in case.
      if (!$data->link->isEnabled()) {
        continue;
      }

      if ($data->access !== NULL && !$data->access instanceof AccessResultInterface) {
        throw new \DomainException('MenuLinkTreeElement::access must be either NULL or an AccessResultInterface object.');
      }

      // Only render accessible links.
      if ($data->access instanceof AccessResultInterface && !$data->access->isAllowed()) {
        continue;
      }

      $class        = [];
      $element      = [];
      $link         = $data->link;
      $url          = $link->getUrlObject();
      $title        = $link->getTitle();
      $has_children = isset($data->hasChildren) && $data->hasChildren == TRUE;
      $expanded     = $link->isExpanded();
      $plugin_id    = $link->getPluginId();
      $show_submenu = $submenu_enabled && $expanded && $has_children;
      $children     = $show_submenu ? $this->loadSubMenuTree($menu_name, $plugin_id, $title) : [];

      // Get the non-localized title to get relevant info.
      $definition = $link->getPluginDefinition();
      if ($url->isExternal()) {
        $class[] = 'external';
      }

      $region['region'] = $this->getRegionKey($config['menu_name'], $key, $title);
      $flyout = '';

      if ($regions = $this->getSetting('regions')) {
        if (!empty($regions[$region['region']])) {
          $region['config'] = $config;
          $flyout = $this->buildDataRegion($region, $children);
        }
      }

      $element['attributes']['class'] = $class;
      $element['title'] = $title;
      $element['url'] = $url;
      $element['options'] = $link->getOptions();
      $element['description'] = $link->getDescription();
      $element['flyout'] = $flyout;
      $element['config'] = $config;

      // @todo check provider: standard, menu_link_content.
      if ($definition['route_name'] == '<front>') {
        $shortened_uuid = 'front_page';
      }
      else {
        list(, $uuid) = array_pad(array_map('trim', explode(":", $definition['id'], 2)), 2, NULL);
        list($shortened_uuid,) = array_pad(array_map('trim', explode("-", $uuid, 2)), 2, NULL);
      }
      $element['uuid'] = $definition['id'];
      $element['shortened_uuid'] = $shortened_uuid;
      $ultimenu[$link->getPluginId()] = $element;
      unset($link);
    }
    return $ultimenu;
  }

  /**
   * {@inheritdoc}
   */
  public function getRegions() {
    $regions = &drupal_static(__METHOD__);
    if (!isset($regions)) {
      $blocks      = $this->getSetting('blocks');
      $menu_blocks = is_array($blocks) ? array_filter($blocks) : array($blocks);
      $menus       = [];

      foreach ($menu_blocks as $delta => $title) {
        $menus[$delta] = $this->loadMenuTree($delta);
      }

      // Allow alteration.
      $this->moduleHandler->alter('ultimenu_menus_info', $menus);

      $regions = [];
      foreach ($menus as $menu_name => $tree) {
        $tree = $this->menuTree->build($tree);
        if (isset($tree['#items'])) {
          foreach ($tree['#items'] as $key => $item) {
            $name_id = $this->truncateRegionKey($menu_name);
            $name_id_nice = str_replace("_", " ", $name_id);

            if ($item['title']) {
              $menu_title = strip_tags($item['title']);
              $region_key = $this->getRegionKey($menu_name, $key, $menu_title);
              $regions[$region_key] = "Ultimenu:$name_id_nice: $menu_title";
              $regions = array_unique($regions);
            }
          }
        }
      }

      // Allow alteration.
      $this->moduleHandler->alter('ultimenu_regions_info', $regions);
    }
    return $regions;
  }

  /**
   * {@inheritdoc}
   */
  public function getEnabledRegions() {
    $regions = &drupal_static(__METHOD__);

    if (!isset($regions)) {
      $regions = [];
      $regions_all = $this->getRegions();

      // First limit to enabled regions from the settings.
      if (($regions_enabled = $this->getSetting('regions')) !== NULL) {
        foreach (array_filter($regions_enabled) as $enabled) {
          // We must depends on enabled menu items as always.
          // A disabled menu item will automatically drop its Ultimenu region.
          if (array_key_exists($enabled, $regions_all)) {
            $regions[$enabled] = $regions_all[$enabled];
          }
        }
      }
    }
    return $regions;
  }

  /**
   * {@inheritdoc}
   */
  public function buildDataRegion(&$region, $children = []) {
    $build   = [];
    $blocks  = [];
    $config  = $region['config'];
    $reverse = FALSE;

    $content = [];
    if ($children) {
      $reverse = !empty($config['submenu_position']) && $config['submenu_position'] == 'bottom';
      $content[] = $children;
    }

    if ($blocks = $this->getBlocksByRegion($region['region'])) {
      $content[] = $blocks;
    }

    if ($content = array_filter($content)) {
      $build['content'] = $reverse ? array_reverse($content, TRUE) : $content;
      $build['#config'] = $config;
      $build['#region'] = $region['region'];
      $build['#sorted'] = TRUE;

      // Add the region theme wrapper for the Ultimenu flyout.
      $build['#theme_wrappers'][] = 'region';
    }

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getBlocksByRegion($region) {
    $build = [];
    $theme = $this->getConfig('system.theme')->get('default');
    $blocks = entity_load_multiple_by_properties('block', ['theme' => $theme, 'region' => $region]);

    if ($blocks) {
      uasort($blocks, 'Drupal\block\Entity\Block::sort');
      foreach ($blocks as $key => $block) {
        if ($block->access('view')) {
          $build[$key] = entity_view($block, 'block');
        }
      }
    }
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function parseThemeInfo() {
    $regions = &drupal_static(__METHOD__);

    if (!isset($regions)) {
      $theme = $this->getConfig('system.theme')->get('default');
      $file  = drupal_get_path('theme', $theme) . '/' . $theme . '.info.yml';

      // Parse theme .info.yml file.
      $info = \Drupal::service('info_parser')->parse($file);

      $regions = [];
      foreach ($info['regions'] as $key => $region) {
        if (array_key_exists($key, $this->getRegions())) {
          $regions[$key] = $region;
        }
      }
    }
    return $regions;
  }

  /**
   * {@inheritdoc}
   */
  public function removeRegions() {
    $goodies = $this->getSetting('goodies');
    if (!empty($goodies['force-remove-region']) && $theme_regions = $this->parseThemeInfo()) {
      return $theme_regions;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getSkins() {
    if (!isset($this->skins)) {
      if ($cache = $this->cacheBackend->get($this->cacheKey . ':skin')) {
        $this->skins = $cache->data;
      }
      else {
        $theme_default = $this->getConfig('system.theme')->get('default');
        $theme_skin    = drupal_get_path('theme', $theme_default) . '/css/ultimenu';
        $custom_skin   = $this->getSetting('skins');
        $module_skin   = drupal_get_path('module', 'ultimenu') . '/skins';
        $mask          = '/.css$/';

        $files = [];
        if (is_dir($module_skin)) {
          foreach (file_scan_directory($module_skin, $mask) as $filename => $file) {
            $files[$filename] = $file;
          }
        }
        if (!empty($custom_skin) && is_dir($custom_skin)) {
          foreach (file_scan_directory($custom_skin, $mask) as $filename => $file) {
            $files[$filename] = $file;
          }
        }
        if (is_dir($theme_skin)) {
          foreach (file_scan_directory($theme_skin, $mask) as $filename => $file) {
            $files[$filename] = $file;
          }
        }
        if ($files) {
          $skins = [];
          foreach ($files as $file) {
            $uri  = $file->uri;
            $name = $file->name;

            // Simplify lengthy deep directory structure.
            if (strpos($uri, $module_skin) !== FALSE) {
              $uri = "module|" . $name;
            }
            // Fix for Warning: Empty needle.
            elseif (!empty($custom_skin) && strpos($uri, $custom_skin) !== FALSE) {
              $uri = "custom|" . $name;
            }
            elseif (is_dir($theme_skin) && strpos($uri, $theme_skin) !== FALSE) {
              $uri = "theme|" . $name;
            }

            // Convert file name to CSS friendly for option label and styling.
            $skins[$uri] = Html::cleanCssIdentifier(Unicode::strtolower($name));
          }

          $this->cacheBackend->set($this->cacheKey . ':skin', $skins, Cache::PERMANENT, array('skin'));
          $this->skins = $skins;
        }
      }
    }
    return $this->skins;
  }

  /**
   * {@inheritdoc}
   */
  public function clearCachedDefinitions($all = FALSE) {
    // Do not invalidate the block cache here.
    drupal_static_reset();

    // Invalidate the theme cache to update ultimenu region-based theme.
    $this->themeHandler->refreshInfo();

    if ($all) {
      // Clear the skins cache.
      $this->skins = NULL;
      // Invalidate the block cache to update ultimenu-based derivatives.
      if ($this->moduleHandler->moduleExists('block')) {
        \Drupal::service('plugin.manager.block')->clearCachedDefinitions();
      }
    }
  }

}
