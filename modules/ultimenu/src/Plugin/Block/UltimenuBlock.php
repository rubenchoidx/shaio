<?php

namespace Drupal\ultimenu\Plugin\Block;

use Drupal\Core\Url;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\ultimenu\UltimenuManagerInterface;

/**
 * Provides an 'Ultimenu' block.
 *
 * @Block(
 *  id = "ultimenu_block",
 *  admin_label = @Translation("Ultimenu block"),
 *  category = @Translation("Ultimenu"),
 *  deriver = "Drupal\ultimenu\Plugin\Derivative\UltimenuBlock"
 * )
 */
class UltimenuBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The Plugin service.
   *
   * @var \Drupal\ultimenu\UltimenuManagerInterface.
   */
  protected $ultimenuManager;

  /**
   * Constructs an UltimenuBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\ultimenu\UltimenuManagerInterface $ultimenu_manager
   *   The ultimenu manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, UltimenuManagerInterface $ultimenu_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->ultimenuManager = $ultimenu_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('ultimenu.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function delta() {
    // Derivatives are prefixed with 'ultimenu-', e.g.: ultimenu-main.
    $id = $this->getDerivativeId();
    return substr($id, 9);
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'skin' => 'module|ultimenu--basic',
      'orientation' => 'ultimenu--htb',
    );
  }

  /**
   * Overrides \Drupal\block\BlockBase::blockForm().
   */
  public function blockForm($form, FormStateInterface $form_state) {
    if (\Drupal::currentUser()->hasPermission('administer ultimenu')) {
      $form['skin'] = array(
        '#type' => 'select',
        '#title' => $this->t('Ultimenu skin'),
        '#default_value' => $this->configuration['skin'],
        '#options' => $this->ultimenuManager->getSkins(),
        '#empty_option' => $this->t('- None -'),
        '#description' => $this->t('Choose the skin for this block. You can supply custom skins at <a href=":ultimenu_settings" target="_blank">Ultimenu settings</a>. The skin can be made specific to this block using the proper class by each menu name. Be sure to <a href=":clear" target="_blank">clear the cache</a> if trouble to see the new skin applied.', array(':ultimenu_settings' => Url::fromRoute('ultimenu.settings')->toString(), ':clear' => Url::fromRoute('system.performance_settings')->toString())),
      );

      $form['orientation'] = array(
        '#type' => 'select',
        '#title' => $this->t('Flyout orientation'),
        '#default_value' => $this->configuration['orientation'],
        '#options' => array(
          'ultimenu--htb' => t('Horizontal to bottom'),
          'ultimenu--htt' => t('Horizontal to top'),
          'ultimenu--vtl' => t('Vertical to left'),
          'ultimenu--vtr' => t('Vertical to right'),
        ),
        '#description' => $this->t('Choose the orientation of the flyout, depending on the placement. At sidebar left, <strong>Vertical to right</strong>. At header, <strong>Horizontal to bottom</strong>. At footer, <strong>Horizontal to top</strong>'),
      );

      $form['submenu'] = array(
        '#type' => 'checkbox',
        '#title' => $this->t('Render submenu'),
        '#default_value' => isset($this->configuration['submenu']) ? $this->configuration['submenu'] : FALSE,
        '#description' => $this->t('Render the relevant submenus inside the Ultimenu region without using Block admin, and independent from blocks. Alternatively use core Menu level option with regular menu block when core supports the "Fixed parent item", see <a href=":url" target="_blank">#2631468</a>. <br /><strong>Important!</strong> Be sure to check "<strong>Show as expanded</strong>" at the parent menu item edit page as needed, otherwise no submenus will be rendered.', [':url' => 'https://www.drupal.org/node/2631468']),
      );

      $form['submenu_position'] = array(
        '#type' => 'select',
        '#title' => $this->t('Submenu position'),
        '#options' => array(
          'bottom' => t('Bottom'),
          'top' => t('Top'),
        ),
        '#empty_option' => $this->t('- None -'),
        '#default_value' => isset($this->configuration['submenu_position']) ? $this->configuration['submenu_position'] : '',
        '#description' => $this->t('Choose where to place the submenu, either before or after existing blocks. Default to Top.'),
      );

    }

    return $form;
  }

  /**
   * Overrides \Drupal\block\BlockBase::blockSubmit().
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['skin'] = $form_state->getValue('skin');
    $this->configuration['orientation'] = $form_state->getValue('orientation');
    $this->configuration['submenu'] = $form_state->getValue('submenu');
    $this->configuration['submenu_position'] = $form_state->getValue('submenu_position');

    // Invalidate the library discovery cache to update the new skin discovery.
    \Drupal::service('library.discovery')->clearCachedDefinitions();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $menu_name     = $this->delta();
    $skin          = $this->configuration['skin'];
    $orientation   = $this->configuration['orientation'];
    $submenu       = !empty($this->configuration['submenu']);
    $provider      = '';
    $skin_name     = '';
    $skin_basename = '';
    $skin_css_path = '';

    // Load the specified block skin.
    if (!empty($skin)) {
      $skin_css_path = $this->ultimenuManager->getSkinPath($skin);
      $skin_basename = $this->ultimenuManager->getSkinName($skin_css_path);

      // Fetch the skin file name from the setting.
      list($provider, $skin_name) = array_pad(array_map('trim', explode("|", $skin, 2)), 2, NULL);
    }

    // Provide the settings for further process.
    $configs = [
      'skin'             => $skin,
      'orientation'      => $orientation,
      'delta'            => $menu_name,
      'menu_name'        => $menu_name,
      'skin_name'        => $skin_name,
      'skin_provider'    => $provider,
      'submenu'          => $submenu,
      'submenu_position' => $submenu && !empty($this->configuration['submenu_position']) ? $this->configuration['submenu_position'] : '',
    ];

    // Build the ultimenu tree.
    $tree = $this->ultimenuManager->buildMenuTree($menu_name, $configs);

    // Allows alteration of the tree before passing to template.
    // @see https://drupal.org/node/1894902
    $this->ultimenuManager->getModuleHandler()->alter('ultimenu_tree', $tree);

    // Build the block.
    $build = [];
    if ($tree) {
      $build = array(
        '#theme'  => 'ultimenu',
        '#items'  => $tree,
        '#config' => $configs,
        '#delta'  => $menu_name,
      );
      $build['#attached']['library'][] = 'ultimenu/ultimenu';
      if ($skin_basename) {
        $build['#attached']['library'][] = 'ultimenu/ultimenu.skin.' . $skin_basename;
      }
    }

    return $build;
  }

}
