<?php

namespace Drupal\ultimenu;

use Drupal\Core\Url;
use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines ultimenu admin settings form.
 */
class UltimenuSettingsForm extends ConfigFormBase {

  /**
   * The Plugin service.
   *
   * @var \Drupal\ultimenu\UltimenuManagerInterface.
   */
  protected $ultimenuManager;

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'ultimenu_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['ultimenu.settings'];
  }

  /**
   * Constructs an UltimenuBlock object.
   *
   * @param \Drupal\ultimenu\UltimenuManagerInterface $ultimenu_manager
   *   The ultimenu manager.
   */
  public function __construct(UltimenuManagerInterface $ultimenu_manager) {
    $this->ultimenuManager = $ultimenu_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('ultimenu.manager')
    );
  }

  /**
   * Implements \Drupal\Core\Form\FormInterface::buildForm().
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $menus            = $this->ultimenuManager->getMenus();
    $ultimenu_regions = $this->ultimenuManager->getRegions();
    $regions_enabled  = $this->ultimenuManager->getEnabledRegions();
    $theme_default    = $this->ultimenuManager->getConfig('system.theme')->get('default');
    $config           = $this->config('ultimenu.settings');
    $blocks           = $config->get('blocks');
    $regions          = $config->get('regions');

    $form['#attached']['library'][] = 'ultimenu/ultimenu.admin';

    $form['ultimenu'] = array(
      '#type' => 'vertical_tabs',
      '#weight' => -200,
      '#prefix' => $this->t('<p>An Ultimenu <strong>block</strong> is based on a <strong>menu</strong>. Ultimenu <strong>regions</strong> are based on the <strong>menu items</strong>. The result is a block contains regions containing blocks, as opposed to: a region contains blocks.</p>'),
    );

    $form['ultimenu_blocks'] = array(
      '#type'  => 'details',
      '#title' => $this->t('Ultimenu blocks'),
      '#group' => 'ultimenu',
    );

    $form['ultimenu_blocks']['blocks'] = array(
      '#type' => 'checkboxes',
      '#title' => $this->t('Toggle Ultimenu blocks'),
      '#options' => $menus,
      '#default_value' => $blocks ?: [],
      '#description' => $this->t('Check one to create an Ultimenu <strong>block</strong>. The block will be available at <a href=":block_admin">block admin</a> under Ultimenu set. And the relevant <strong>regions</strong> based on its enabled menu items will be available below after saving. Ultimenu will only care for the first top level menus. If you are willing to use submenus, please adjust the settings under <strong>Menu levels</strong> relevant to the particular Menu block assigned within an Ultimenu region (analog to D7 <a href=":menu_block" target="_blank">Menu block</a> module), and embed them inside an Ultimenu region. Otherwise use regular dropdown method, instead.', array(':block_admin' => Url::fromRoute('block.admin_display')->toString(), ':menu_block' => '//drupal.org/project/menu_block')),
    );

    $form['ultimenu_regions'] = array(
      '#type' => 'details',
      '#title' => $this->t('Ultimenu regions'),
      '#group' => 'ultimenu',
    );

    // All available Ultimenu regions.
    $form['ultimenu_regions']['regions'] = array(
      '#type' => 'checkboxes',
      '#title' => $this->t('Toggle Ultimenu regions'),
      '#options' => $ultimenu_regions,
      '#default_value' => $regions ?: [],
      '#description' => $this->t('Check one to enable an Ultimenu <strong>region</strong>. The regions will be available at <a href="@block_admin">block admin</a>.', array('@block_admin' => Url::fromRoute('block.admin_display')->toString())),
    );

    // Compare settings against Ultimenu regions stored in theme .info.yml.
    if ($theme_regions = $this->ultimenuManager->parseThemeInfo()) {
      foreach ($theme_regions as $key => $region) {
        $form['ultimenu_regions']['regions'][$key]['#attributes']['class'][] = 'stored-in-theme';
        // Option disabled, but region stored in theme .info.yml, provide hint.
        if (empty($regions[$key])) {
          // Ultimenu region is stored in .info.yml, force remove is enabled.
          if ($this->ultimenuManager->removeRegions()) {
            $form['ultimenu_regions']['regions'][$key]['#field_suffix'] = $this->t('&#8592; Stored, but force removed');
          }
          // Ultimenu region is stored in .info.yml, force remove is disabled.
          else {
            $form['ultimenu_regions']['regions'][$key]['#attributes']['class'][] = 'error';
            $form['ultimenu_regions']['regions'][$key]['#field_suffix'] = $this->t('&#8592; Stored, but disabled?');
          }
        }
      }
    }

    $form['ultimenu_goodies'] = array(
      '#type' => 'details',
      '#title' => $this->t('Ultimenu goodies'),
      '#group' => 'ultimenu',
    );

    $goodies = $config->get('goodies');
    // Menu title tooltip: http://webdesign.about.com/od/htmltags/a/aa101005.htm
    $form['ultimenu_goodies']['goodies'] = array(
      '#type' => 'checkboxes',
      '#title' => $this->t('Toggle Ultimenu goodies'),
      '#default_value' => !empty($goodies) ? array_values((array) $goodies) : array(),
      '#options' => array(
        'menu-desc' => $this->t('Render menu description'),
        'desc-top' => $this->t('Menu description above menu title'),
        'title-class' => $this->t('Add TITLE class to menu item'),
        'mlid-class' => $this->t('Add shortened UUID class'),
        'counter-class' => $this->t('Add menu counter class'),
        'no-tooltip' => $this->t('Remove browser tooltip'),
        'ultimenu-mlid' => $this->t('Use shortened UUID, not TITLE, for Ultimenu region key'),
        'force-remove-region' => $this->t('Force remove Ultimenu region stored in <strong>@theme_default.info.yml</strong>', array('@theme_default' => $theme_default)),
      ),
      '#description' => $this->t('Using ugly UUID as region key is only useful for a multilingual site. <br />You can force remove unwanted Ultimenu regions stored in <strong>@theme_default.info.yml</strong>. Otherwise <strong>@theme_default.info.yml</strong> will always win, ignoring the Ultimenu region checkboxes above.',
        array('@theme_default' => $theme_default)),
    );

    $form['ultimenu_goodies']['skins'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Path to custom Ultimenu skins library'),
      '#default_value' => $config->get('skins'),
      '#description' => $this->t('The path to Ultimenu skins folder, e.g.: <strong>libraries/skins/ultimenu</strong> containing CSS files that will be used as options for each Ultimenu block. Please be specific with <strong>ultimenu</strong> directory to limit the scan. Or place skins in your theme default: <strong>@theme_default/css/ultimenu</strong> for auto discovery.',
      array(
        '@theme_default' => drupal_get_path('theme', $theme_default),
      )),
    );

    // Provide region definitions for copy/paste.
    if (!empty($regions)) {
      $copies = [];
      foreach ($regions_enabled as $key => $region) {
        $copies[] = "$key: '$region'";
      }

      if ($copies) {
        $copies = "regions:\n  " . implode("\n  ", $copies);
        $form['ultimenu_goodies']['markups'] = array(
          '#type' => 'item',
          '#markup' => '<textarea class="getfocus" spellcheck="false">' . $copies . '</textarea>',
          '#allowed_tags' => ['textarea'],
        );

        $form['ultimenu_goodies']['hints'] = array(
          '#type' => 'item',
          '#markup' => $this->t("<ol><li>Changing region key from TITLE to UUID will reset relevant regions and blocks. Simply re-assign blocks to get them back.</li><li>Optionally copy the provided regions into your <strong>@theme_default</strong> to permanently store Ultimenu regions.</li><li>If a menu item is deleted or disabled, the related Ultimenu region is deleted.</li><li>Don't forget to clear cache whenever you update <strong>@theme_default</strong> file.</li><li>If you disable a region here, but stored in <strong> @theme_default</strong>, you can force remove <strong>@theme_default </strong> regions by checking <strong>Force remove Ultimenu region stored in @theme_default</strong> above. Otherwise <strong> @theme_default</strong> always wins ignoring the above settings.</li><li>If you copy/paste the above regions, be sure to exclude <strong>regions:</strong> key if the working theme has already regions key in place.</li></ol><div class='messages messages--warning'><strong>Warning!</strong> If you edit <strong>@theme_default</strong>, be careful with file indentation, otherwise .yml parser fatal error.</div>", array(
            '@theme_default' => $theme_default . '.info.yml',
          )),
        );
      }
    }
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!$form_state->isValueEmpty('skins') && !is_dir($form_state->getValue('skins'))) {
      $form_state->setErrorByName('skins', $this->t('<strong>@skins</strong> do not exists. Please create the directory first.', array('@skins' => $form_state->getValue('skins'))));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * Implements \Drupal\Core\Form\FormInterface::submitForm().
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data = [];
    // Do not litter the ultimenu.settings.yml.
    $data['blocks']  = array_filter($form_state->getValue('blocks'));
    $data['regions'] = array_filter($form_state->getValue('regions'));
    $data['goodies'] = array_filter($form_state->getValue('goodies'));
    $data['skins']   = $form_state->getValue('skins');

    $config = $this->configFactory->getEditable('ultimenu.settings');

    if ($form_state->hasValue('blocks')) {
      $config->set('blocks', $data['blocks']);
    }
    if ($form_state->hasValue('regions')) {
      $config->set('regions', $data['regions']);
    }
    if ($form_state->hasValue('goodies')) {
      $config->set('goodies', $data['goodies']);
    }
    if ($form_state->hasValue('skins')) {
      $config->set('skins', $data['skins']);
    }

    $config->save();

    // Reset static and theme info to get the new blocks and regions fetched.
    $this->ultimenuManager->clearCachedDefinitions();

    // Invalidate the block cache to update ultimenu-based derivatives.
    if ($this->ultimenuManager->getModuleHandler()->moduleExists('block')) {
      \Drupal::service('plugin.manager.block')->clearCachedDefinitions();
    }

    // If anything fails, notice to clear the cache.
    drupal_set_message($this->t('Be sure to <a href=":clear_cache">clear the cache</a> <strong>ONLY IF</strong> trouble to see the updated regions at <a href=":block_admin">block admin</a>.', array(':clear_cache' => Url::fromRoute('system.performance_settings')->toString(), ':block_admin' => Url::fromRoute('block.admin_display')->toString())));

    parent::submitForm($form, $form_state);
  }

}
