<?php
/**
 * @file
 * Contains \Drupal\Tests\footermap\Unit\Plugin\Block\FootermapBlockTest.
 */

namespace Drupal\Tests\footermap\Unit\Plugin\Block;

use Drupal\Core\Config\Entity\ConfigEntityType;
use Drupal\Core\Form\FormState;
use Drupal\Core\Logger\LoggerChannel;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\Core\Menu\MenuLinkDefault;
use Drupal\Core\Menu\MenuLinkTreeElement;
use Drupal\footermap\Menu\AnonymousMenuLinkTreeManipulator;
use Drupal\footermap\Plugin\Block\FootermapBlock;
use Drupal\system\Entity\Menu;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Test footermap block methods.
 *
 * @group footermap
 */
class FootermapBlockTest extends UnitTestCase {

  /**
   * @var \Symfony\Component\DependencyInjection\ContainerBuilder
   */
  protected $container;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Create some menu entities.
    $menu1 = new Menu(['id' => 'menu1', 'description' => 'menu1', 'label' => 'menu1'], 'menu');
    $menu2 = new Menu(['id' => 'menu2', 'description' => 'menu2', 'label' => 'menu2'], 'menu');

    $link1 = ['title' => 'Link1'];
    $link1_definition = [
      'id' => 'menu_link1',
      'title' => 'Link1',
      'description' => 'A link',
      'enabled' => TRUE,
      'options' => [],
      'weight' => 0,
    ];

    $link1_child = ['title' => 'Child Link 1'];
    $link1_child_definition = [
      'id' => 'menu_link1_child',
      'title' => 'Child Link 1',
      'description' => 'A child link',
      'enabled' => TRUE,
      'options' => [],
      'weight' => 5,
    ];

    $link1_child2 = ['title' => 'Child Link 2'];
    $link1_child2_definition = [
      'id' => 'menu_link2',
      'title' => 'Child Link 2',
      'description' => 'A second link',
      'enabled' => TRUE,
      'options' => [],
      'weight' => -5,
    ];

    $configEntityType = new ConfigEntityType([
      'id' => 'menu',
      'label' => 'Menu',
      'handlers' => ['access' => 'Drupal\system\MenuAccessControlHandler'],
      'entity_keys' => ['id' => 'id', 'label' => 'label'],
      'admin_permission' => 'administer menu',
    ]);

    // Mock Static Menu link overrides.
    $staticMenuLinkOverrides = $this->getMockBuilder('\Drupal\Core\Menu\StaticMenuLinkOverridesInterface')
      ->disableOriginalConstructor()
      ->getMock();

    // Create menu link plugin instances.
    $menu1_link1 = new MenuLinkDefault($link1, 'menu_link1', $link1_definition, $staticMenuLinkOverrides);
    $menu1_link1_child = new MenuLinkDefault($link1_child, 'menu_link1_child', $link1_child_definition, $staticMenuLinkOverrides);
    $menu1_link2_child = new MenuLinkDefault($link1_child2, 'menu_link1_child2', $link1_child2_definition, $staticMenuLinkOverrides);
    // Create menu link tree for menu1 with menu routes.
    $menu1_subtree = new MenuLinkTreeElement($menu1_link1_child, FALSE, 2, FALSE, []);
    $menu1_subtree2 = new MenuLinkTreeElement($menu1_link2_child, FALSE, 2, FALSE, []);
    $menu1_tree = new MenuLinkTreeElement($menu1_link1, TRUE, 1, FALSE, [$menu1_subtree, $menu1_subtree2]);

    // Mock config entity storage.
    $configEntityStorage = $this->getMockBuilder('\Drupal\Core\Config\Entity\ConfigEntityStorageInterface')
      ->disableOriginalConstructor()
      ->getMock();
    $configEntityStorage->expects($this->any())
      ->method('loadMultiple')
      ->willReturn([
        'menu1' => $menu1,
        'menu2' => $menu2
      ]);

    // Mock the entity manager.
    $entityManager = $this->getMockBuilder('\Drupal\Core\Entity\EntityManagerInterface')
      ->disableOriginalConstructor()
      ->getMock();
    $entityManager->expects($this->any())
      ->method('getStorage')
      ->with('menu')
      ->willReturn($configEntityStorage);
    $entityManager->expects($this->any())
      ->method('getDefinition')
      ->with('menu')
      ->willReturn($configEntityType);

    // Mock the menu link tree manager
    $menuLinkTree = $this->getMockBuilder('\Drupal\Core\Menu\MenuLinkTreeInterface')
      ->disableOriginalConstructor()
      ->getMock();
    $menuLinkTree->expects($this->any())
      ->method('load')
      ->with('menu1', $this->getMenuParameters())
      ->willReturn([$menu1_tree]);
    $menuLinkTree->expects($this->any())
      ->method('transform')
      ->willReturn([$menu1_tree]);

    // Mock the plugin manager for menu link
    $menuLinkPluginManager = $this->getMockBuilder('\Drupal\Core\Menu\MenuLinkManagerInterface')
      ->disableOriginalConstructor()
      ->getMock();

    // Mock the Logger Channel factory.
    $loggerChannelFactory = $this->getMockBuilder('\Drupal\Core\Logger\LoggerChannelFactoryInterface')
      ->disableOriginalConstructor()
      ->getMock();
    $loggerChannelFactory->expects($this->any())
      ->method('get')
      ->with('footermap')
      ->willReturn(new LoggerChannel('footermap'));

    // Mock the Access Manager.
    $access_manager = $this->getMockBuilder('\Drupal\Core\Access\AccessManagerInterface')
      ->disableOriginalConstructor()
      ->getMock();

    //  Mock an anonymous user session.
    $account = $this->getMockBuilder('\Drupal\Core\Session\AnonymousUserSession')
      ->disableOriginalConstructor()
      ->getMock();

    // Mock the entity query factory.
    $query_factory = $this->getMockBuilder('\Drupal\Core\Entity\Query\QueryFactory')
      ->disableOriginalConstructor()
      ->getMock();

    $anonymousTreeManipulator = new AnonymousMenuLinkTreeManipulator($access_manager, $account, $query_factory);

    $this->container = new ContainerBuilder();

    $this->container->set('entity.manager', $entityManager);
    $this->container->set('menu.link_tree', $menuLinkTree);
    $this->container->set('plugin.manager.menu.link', $menuLinkPluginManager);
    $this->container->set('string_translation', $this->getStringTranslationStub());
    $this->container->set('footermap.anonymous_tree_manipulator', $anonymousTreeManipulator);
    $this->container->set('footermap.anonymous_user', $account);
    $this->container->set('logger.factory', $loggerChannelFactory);

    \Drupal::setContainer($this->container);
  }

  /**
   * @covers \Drupal\footermap\Plugin\Block\FootermapBlock::create
   */
  public function testStaticCreate() {
    $block = $this->getPlugin();
    $this->assertInstanceOf('\Drupal\footermap\Plugin\Block\FootermapBlock', $block);
  }

  /**
   * @covers \Drupal\footermap\Plugin\Block\FootermapBlock::__construct
   */
  public function testInitialize() {
    $configuration = [
      'label' => 'Footermap',
      'display_label' => TRUE
    ];
    $plugin_id = 'footermap';
    $plugin_definition = [
      'plugin_id' => $plugin_id,
      'provider' => 'footermap'
    ];

    $block = new FootermapBlock(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $this->container->get('entity.manager'),
      $this->container->get('menu.link_tree'),
      $this->container->get('plugin.manager.menu.link'),
      $this->container->get('logger.factory')
    );
    $this->assertInstanceOf('\Drupal\footermap\Plugin\Block\FootermapBlock', $block);
  }

  /**
   * @covers \Drupal\footermap\Plugin\Block\FootermapBlock::defaultConfiguration
   */
  public function testDefaultConfiguration() {
    $expected = [
      'footermap_recurse_limit' => 0,
      'footermap_display_heading' => 1,
      'footermap_avail_menus' => [],
      'footermap_top_menu' => ''
    ];
    $block = $this->getPlugin();
    $this->assertEquals($expected, $block->defaultConfiguration());
  }

  /**
   * Assert that site map is built.
   */
  public function testBuild() {
    $block = $this->getPlugin();
    $block->setConfigurationValue('footermap_avail_menus', ['menu1' => 'menu1']);

    // Assert that site map is built with children.
    $map = $block->build();
    $this->assertArrayHasKey('#footermap', $map);
    $this->assertArrayHasKey('#attached', $map);
    $this->assertEquals('Footermap', $map['#title']);
    $this->assertCount(1, $map['#footermap']['menu1']['#items']);
    $this->assertEquals('Link1', $map['#footermap']['menu1']['#items']['menu-0']['#title']);
    $children = &$map['#footermap']['menu1']['#items']['menu-0']['#children'];
    $this->assertEquals('Child Link 1', $children['menu-0']['#title']);

    // Assert that the site map has the menu links with #weight property equal
    // to the menu link weight.
    $this->assertEquals(-5, $children['menu-1']['#weight']);
    $this->assertEquals(5, $children['menu-0']['#weight']);
  }

  /**
   * @covers \Drupal\footermap\Plugin\Block\FootermapBlock::blockForm
   */
  public function testBlockForm() {
    $form_state = new FormState();
    $block = $this->getPlugin();
    $block->setConfigurationValue('footermap_avail_menus', ['menu1' => 'menu1']);

    $form = $block->blockForm([], $form_state);

    $this->assertEquals($form['footermap_avail_menus']['#options'], ['menu1' => 'menu1', 'menu2' => 'menu2']);
    $this->assertArrayHasKey('footermap_recurse_limit', $form);
    $this->assertArrayHasKey('footermap_top_menu', $form);
    $this->assertArrayHasKey('footermap_display_heading', $form);
  }

  /**
   * @covers \Drupal\footermap\Plugin\Block\FootermapBlock::access
   */
  public function testAccess() {
    $block = $this->getPlugin();
    $account = $this->container->get('footermap.anonymous_user');

    $this->assertInstanceOf('\Drupal\Core\Access\AccessResultAllowed', $block->access($account, TRUE));
    $this->assertTrue($block->access($account));
  }

  /**
   * @covers \Drupal\footermap\Plugin\Block\FootermapBlock::getCacheContexts
   */
  public function testGetCacheContexts() {
    $block = $this->getPlugin();
    $this->assertEquals(['languages'], $block->getCacheContexts());
  }

  /**
   * Create an instance of the footermap block.plugin.
   *
   * @returns \Drupal\footermap\Plugin\Block\FootermapBlock
   *   A block plugin instance.
   */
  protected function getPlugin() {
    $configuration = [
      'label' => 'Footermap',
      'display_label' => TRUE
    ];
    $plugin_id = 'footermap';
    $plugin_definition = [
      'plugin_id' => $plugin_id,
      'provider' => 'footermap'
    ];

    return FootermapBlock::create($this->container, $configuration, $plugin_id, $plugin_definition);
  }

  /**
   * Get the menu parameters to pass into menu tree parameters.
   *
   * @param integer $limit
   *   (Optional) The recurse limit
   * @param string $menu
   *   (Optional) The menu plugin id.
   * @returns \Drupal\Core\Menu\MenuTreeParameters
   *   Menu tree parameter class.
   */
  protected function getMenuParameters($limit = FALSE, $menu = FALSE) {
    $parameters = new MenuTreeParameters();
    $parameters->onlyEnabledLinks();
    $parameters->excludeRoot();

    if ($limit) {
      $parameters->setMaxDepth($limit);
    }

    if ($menu) {
      $parameters->setRoot($menu);
    }

    return $parameters;
  }
}
