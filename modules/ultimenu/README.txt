ULTIMENU MODULE
================================================================================
Ultimenu is the UltimatelyDeadSimple&trade; megamenu ever with dynamic region
creation.

An Ultimenu block is based on a menu.
Ultimenu regions are based on the menu items.
The result is a block contains regions containing blocks, as opposed to: a
region contains blocks.

The module manages the toggle of Ultimenu blocks, regions, and a skins library,
while leaving the management of block, menu and regions to Drupal.

At individual Ultimenu block, you can define a unique skin and the flyout
orientation.

You don't have to write regions in the theme .info, however you can always
permanently store resulting region definitions in it. See Notes below for
possible handle of confusion.


FEATURES
--------------------------------------------------------------------------------
1. Multiple instance of Ultimenus based on system and menu modules.
2. Dynamic regions based on menu items which is toggled without touching .info.
3. Render menu description.
4. Menu description above menu title.
5. Add title class to menu item list.
6. Add mlid class to menu item list.
7. Add menu counter class
8. Remove browser tooltip.
9. Use mlid, not title for Ultimenu region key.
10. Custom skins, or theme default "css/ultimenu" directory for auto discovery.
11. Individual flyout orientation: horizontal to bottom or top, vertical to
    left or right.
12. Pure CSS3 animation and basic styling is provided without assumption.
    Please see and override the ultimenu.css for more elaborate positioning,
    either left, centered or right to menu list or menu bar.
13. With the goodness of blocks and regions, you can embed almost anything:
    views, panels, blocks, menu_block, boxes, slideshow..., except a toothpick.

All 1-9 is off by default.


REQUIREMENTS
--------------------------------------------------------------------------------
- Drupal core optional menu.module should be enabled.


USAGE
--------------------------------------------------------------------------------
1. Enable or install the module.

2. Visit admin/structure/ultimenu to manage the Ultimenu blocks, regions, a skin
   library and a few goodies.
   Toggle Ultimenu blocks:
   o Click menus you want to use for Ultimenu blocks, say "Main navigation".
   o Save.

3. Once a menu is enabled, dynamic regions will be available to toggle. Only
   enabled regions (based on enabled menu items) will be visible at block/
   context admin.
   Toggle Ultimenu regions:
   o Click on menu item title where you want to add popup submenus (regions),
   o Save.

4. Visit admin/structure/block
   o Click "Place block" button on any region (header, sidebar, footer
     or navigation region, except Ultimenu regions), say "Primary menu".
     This Ultimenu block acts as Ultimenu region container.
   o On modal, search for "Ultimenu: Main navigation", and click "Place block".
     The Ultimenu regions are still empty here.
   o Search for each Ultimenu regions, say "Ultimenu:main: About".
     Add other blocks to the "Ultimenu:main: About" region, and repeat.


WHY ANOTHER MEGAMENU?
--------------------------------------------------------------------------------
I tried one or two, not all, and read some, but found no similar approach.
Unless I missed one. Please file an issue if any similar approach worth a merge.


HOW CAN YOU HELP?
--------------------------------------------------------------------------------
Please consider helping in the issue queue, provide improvement, or helping with
documentation.


RELATED MODULES
--------------------------------------------------------------------------------
http://drupal.org/project/om_maximenu - OM Maximenu
http://drupal.org/project/megamenu - Megamenu
http://drupal.org/project/superfish - Superfish
http://drupal.org/project/menu_views - Menu Views
http://drupal.org/project/1077858 - MuchoMenu
http://drupal.org/project/gigamenu - Giga Menu
http://drupal.org/project/menu_minipanels - Menu Minipanels
http://drupal.org/sandbox/ravigupta/1099796 - Mega Dropdown
http://drupal.org/project/menu_attach_block - Menu Attach Block


NOTES
--------------------------------------------------------------------------------
Whenever a menu item is removed/disabled, the relevant region will be removed.
If you manually copy/store them in theme .info, regions will always be visible,
which is another case.
Dynamic region is indeed removed, but system now displays your written regions.
However you can force disabling unwanted Ultimenu regions via UI if so required,
altering the system.

Make sure to clear the cache to see the new regions.


STYLINGS
--------------------------------------------------------------------------------
Classes:
  .ultimenu: the menu UL tag.
  .ultimenu > li: the menu LI tag.
  .ultimenu__flyout: the ultimenu region aka flyout.
  .ultimenu__link: the menu-item A tag.
  .has-ultimenu: contain the flyout, to differ from regular list like
  when using border-radius.

A very basic layout is provided to display them properly. Skinning is all yours.
To position the flyout may depend on design.
Use relative UL to have a very wide flyout that will stick to menu UL.
Use relative LI to have a smaller flyout that will stick to menu LI.

To center the flyout, use negative margin technique:

  .ultimenu__flyout {
    left: 50%;
    margin-left: -480px; /* half of width */
    width: 960px;
  }

Adjust the margin and width accordingly. The rule: margin is half of width.

More ideas for positioning:
- Centered to menu bar, like ESPN
- Always left to menu bar
- Always right to menu bar
- Centered to menu item
- Left to menu item, like Reuters
- Right to menu item

When placing vertical Ultimenu in sidebar, make sure to add position relative
to the sidebar selector, and add proper z-index, otherwise it is possible that
the flyout will be dropped behind some content area.


AUTHOR/MAINTAINER/CREDITS
--------------------------------------------------------------------------------
Gaus Surahman <gausarts [at] gmail.com>
https://drupal.org/user/159062

Need customization, or part timer? Feel free to contact me.
