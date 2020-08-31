<?php

namespace Drupal\ultimenu\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\ultimenu\UltimenuManagerInterface;

/**
 * Provides block plugin definitions for Ultimenu.
 *
 * @see \Drupal\ultimenu\Plugin\Block\UltimenuBlock
 */
class UltimenuBlock extends DeriverBase implements ContainerDeriverInterface {

  /**
   * The Plugin service.
   *
   * @var \Drupal\ultimenu\UltimenuManagerInterface.
   */
  protected $ultimenuManager;

  /**
   * Constructs a new UltimenuBlock.
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
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('ultimenu.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    // Provide a block plugin definition for each ultimenu.
    foreach ($this->ultimenuManager->getUltimenuBlocks() as $key => $name) {
      $menu_key = 'ultimenu-' . $key;
      $this->derivatives[$menu_key] = $base_plugin_definition;
      $this->derivatives[$menu_key]['admin_label'] = t("Ultimenu: @name", array('@name' => $name));
    }
    return parent::getDerivativeDefinitions($base_plugin_definition);
  }

}
