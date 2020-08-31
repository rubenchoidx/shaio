<?php
/**
 * @file
 * Preprocessors and theme functions of Ultimenu module.
 */

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\Unicode;
use Drupal\Core\Template\Attribute;

/**
 * Prepares variables for ultimenu templates.
 *
 * Default template: ultimenu.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - element: An associative array containing the properties of the element.
 *     Properties used: #config, #items, #delta, #plugin_id, #attributes.
 *     - config: The available config related to this particular instance.
 *     - items: An array of available items.
 *     - delta: The menu block delta, or menu name.
 *     - attributes: An associative array of attributes to be placed in the UL
 *       tag.
 *
 * @see ultimenu.html.twig
 */
function template_preprocess_ultimenu(array &$variables) {
  $element  = $variables['element'];
  $config   = $element['#config'];
  $items    = $element['#items'];
  $ultimenu = \Drupal::service('ultimenu.manager');
  $goodies  = $ultimenu->getSetting('goodies');

  $variables['delta']   = $element['#delta'];
  $variables['goodies'] = $goodies;
  $variables['config']  = $config;

  $variables['attributes'] = new Attribute();
  $variables['attributes']['id'] = 'ultimenu-' . $variables['delta'];
  if ($variables['delta'] == 'main') {
    $variables['attributes']['data-ultimenu'] = $variables['delta'];
  }

  $active_trails = \Drupal::service('menu.active_trail')->getActiveTrailIds($config['menu_name']);
  $variables['items'] = [];
  foreach ($items as $key => $link) {
    $item = [];
    $li_attributes = [];

    $link += array(
      'ajax' => NULL,
      'url' => NULL,
    );

    $link_element = array(
      '#type' => 'link',
      '#options' => array(
        'attributes' => array(
          'class' => array('ultimenu__link'),
        ),
      ),
    );

    $title_stripped = strip_tags($link['title']);

    if (isset($goodies['menu-desc']) && $goodies['menu-desc'] && $description = $link['description']) {
      // Render description, and sanitize the title if so configured.
      // If you override this, be sure to have proper sanitization.
      $menu_description = '<small>' . strip_tags($description, '<em><strong><i><b>') . '</small>';
      $is_desc_top = isset($goodies['desc-top']) && $goodies['desc-top'];
      $link_title = $is_desc_top ? $menu_description . $title_stripped : $title_stripped . $menu_description;
      $link['title'] = [
        '#markup' => $link_title,
        '#allowed_tags' => ['b', 'em', 'i', 'small', 'span', 'strong'],
      ];
    }

    $link_element += array(
      '#title' => $link['title'],
      '#url' => $link['url'],
      '#ajax' => $link['ajax'],
    );

    $item['title'] = $link['title'];

    if (isset($link['url'])) {
      $url = $link['url'];

      if ($url->isRouted()) {
        if (array_key_exists($key, $active_trails)) {
          $li_attributes['class'][] = 'active-trail';
        }

        // Also enable set_active_class for the contained link.
        $link_element['#options']['set_active_class'] = TRUE;

        // Add a "data-drupal-link-system-path" attribute to let the
        // drupal.active-link library know the path in a standardized manner.
        $system_path = $url->getInternalPath();
        // @todo System path is deprecated - use the route name and parameters.
        // Special case for the front page.
        $link_element['#options']['attributes']['data-drupal-link-system-path'] = $system_path == '' ? '<front>' : $system_path;
      }
    }

    if (isset($link['attributes']) && is_array($link['attributes'])) {
      $li_attributes += $link['attributes'];
    }

    // Remove browser tooltip if so configured.
    if (isset($goodies['no-tooltip']) && $goodies['no-tooltip']) {
      $link_element['#options']['attributes']['title'] = '';
    }

    // Add LI title class based on title if so configured.
    if (isset($goodies['title-class']) && $goodies['title-class']) {
      $title_class = Html::cleanCssIdentifier(Unicode::strtolower('uitem--' . $title_stripped));
      $li_attributes['class'][] = $title_class;
    }

    // Add LI counter class based on counter if so configured.
    if (isset($goodies['counter-class']) && $goodies['counter-class']) {
      static $item_id = 0;
      $li_attributes['class'][] = 'uitem--' . (++$item_id);
    }

    // Add LI mlid/shortened uuid class based on uuid if so configured.
    if (!empty($goodies['mlid-class']) && $link['shortened_uuid']) {
      $li_attributes['class'][] = Html::cleanCssIdentifier(Unicode::strtolower('uitem--' . $link['shortened_uuid']));
    }

    if (isset($link['url'])) {
      $item['link'] = $link_element;
    }

    if ($flyout = $link['flyout']) {
      $item['flyout'] = $flyout;
    }

    // Handle list item attributes.
    array_unshift($li_attributes['class'], 'ultimenu__item', 'uitem');
    $item['attributes'] = new Attribute($li_attributes);
    $item['flyout_attributes'] = new Attribute();

    // Add the item to the list of links.
    $variables['items'][$key] = $item;
  }
}
