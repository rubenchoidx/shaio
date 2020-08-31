<?php

namespace Drupal\ultimenu;

/**
 * Interface for Ultimenu plugins.
 */
interface UltimenuManagerInterface {

  /**
   * Returns the theme handler.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  public function getThemeHandler();

  /**
   * Returns the module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  public function getModuleHandler();

  /**
   * Returns the Config Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  public function getConfig($config = 'ultimenu.settings');

  /**
   * Returns the Ultimenu settings.
   *
   * @param string $setting_name
   *   The setting name.
   *
   * @return array|NULL
   *   The settings.
   */
  public function getSetting($setting_name = NULL);

  /**
   * Returns the Ultimenu blocks.
   *
   * @return array
   *   The blocks.
   */
  public function getUltimenuBlocks();

  /**
   * Returns the enabled Ultimenu blocks.
   *
   * @param string $delta
   *   The menu name.
   *
   * @return array
   *   The enabled blocks.
   */
  public function getEnabledBlocks($delta);

  /**
   * Gets the region key.
   *
   * @param string $menu_name
   *   The menu name.
   * @param string $key
   *   The menu item key can be UUID or menu item title.
   * @param string $title
   *   The menu item title.
   * @param string $max_length
   *   The maximum characters to trim.
   *
   * @return string
   *   The region key name based on shortened UUID, or menu item title.
   */
  public function getRegionKey($menu_name, $key, $title, $max_length = 28);

  /**
   * A reversed process to convert an option into a full CSS skin path.
   *
   * This silly reversion ensures the setting will be intact when moving around
   * CSS files, or theme and module directory.
   *
   * @param string $path
   *   The path that should be converted to full CSS path.
   *
   * @return string
   *   The CSS path containing ultimenu skins.
   */
  public function getSkinPath($path);

  /**
   * Gets the skin basename.
   *
   * @param string $path
   *   The path to the CSS file.
   *
   * @return string
   *   The skin basename.
   */
  public function getSkinName($path);

  /**
   * Simplify menu names or menu item titles for region key.
   *
   * If region key is to use menu item title:
   * Region key: ultimenu_LOOOOOOOOOOOONGMENUNAME_LOOOOOOOOOOOOOOOOOONGMENUITEM.
   * If region key is to use unfriendly key UUID, we'll only care for menu name.
   * Region key: ultimenu_LOOOOOOOOOOOOOONGMENUNAME_1c2d3e4.
   *
   * @param string $string
   *   The Menu name or menu item title.
   * @param int $max_length
   *   The amount of characters to truncate.
   *
   * @return string
   *   The truncated menu properties ready to use for region key.
   */
  public function truncateRegionKey($string, $max_length = 28);

  /**
   * Returns the available menus, excluding some admin menus.
   *
   * @return array
   *   The menus.
   */
  public function getMenus();

  /**
   * Generate a list of links based on the menu name.
   *
   * @param string $menu_name
   *   The menu name.
   *
   * @return array
   *   An array of the requested menu links.
   */
  public function loadMenuTree($menu_name);

  /**
   * Build the menu to contain Ultimenu regions.
   *
   * @param string $menu_name
   *   The menu name.
   * @param array $config
   *   The config available for the menu tree.
   *
   * @return array
   *   An array of the modified ultimenu links.
   */
  public function buildMenuTree($menu_name, array $config);

  /**
   * The array of available Ultimenu regions based on enabled menu items.
   *
   * @return array
   *   An array of regions definition dependent on available menu items.
   */
  public function getRegions();

  /**
   * Returns the array of enabled Ultimenu regions based on enabled settings.
   *
   * @return array
   *   An array of enabled regions definition based on enabled menu items.
   */
  public function getEnabledRegions();

  /**
   * Returns the renderable array region data.
   *
   * @return array
   *   The region data.
   */
  public function buildDataRegion(&$region, $children = []);

  /**
   * A helper function to generate a list of blocks from a specified region.
   *
   * @param string $region
   *   The string identifier for a Ultimenu region. e.g. "ultimenu_main_about".
   *
   * @return array
   *   The renderable array of blocks within the region.
   */
  public function getBlocksByRegion($region);

  /**
   * Returns the default theme Ultimenu regions from theme .info.yml.
   *
   * @return array
   *   The Ultimenu regions.
   */
  public function parseThemeInfo();

  /**
   * Returns unwanted Ultimenu regions for removal from theme .info.yml.
   *
   * When a menu item disabled or deleted, relevant dynamic Ultimenu regions
   * removed from the system, but theme .info.yml has a copy stored there.
   * System will always keep and display the unwanted.
   * Either manual deletion from .info.yml, or a force removal if so configured.
   *
   * @return array|bool
   *   The array of unwanted Ultimenu regions from theme .info.yml, or FALSE.
   */
  public function removeRegions();

  /**
   * Retrieves stored CSS files for Ultimenu skin options.
   *
   * @return array
   *   An array of available CSS files.
   */
  public function getSkins();

  /**
   * Clear the cache definitions.
   *
   * @param bool $all
   *   A flag to check if the clearing is affection all about Ultimenu.
   */
  public function clearCachedDefinitions($all = FALSE);

}
