<?php

use Opencad\App\Navigation\NavItem;
use Opencad\App\PluginManager\PluginInterface;


class MyPlugin implements PluginInterface
{
  public function execute()
  {
    // $this->addNavItemsWithChildren();
    // $this->addNavItemToHome();
    // $this->addNavItemToAboutUs();
  }

  public function addNavItemsWithChildren()
  {
    // In this method,
    // you can see that the plugin creates a parent nav bar (PluginParent),
    // and then it creates 3 children nested under the nav bar.
    global $navItems;

    // Create the parent item
    $parent = new NavItem('PluginParent', '#');

    // Add the child items to the parent item
    $PluginChild1 = new NavItem('PluginChild1', '/PluginChild1');
    $PluginChild2 = new NavItem('PluginChild2', '/PluginChild2');
    $PluginChild3 = new NavItem('PluginChild3', '/PluginChild3');

    $parent->addChild($PluginChild1);
    $parent->addChild($PluginChild2);
    $parent->addChild($PluginChild3);

    // Add the parent item to the nav items array
    $navItems[] = $parent;
  }

  public function addNavItemToHome()
  {
    // Very similar to the addNavItemsWithChildren but this time,
    // it will add a nested item nav item under the "home" parent.
    global $navItems;

    $item = new NavItem('Nested Item', '/nested');
    $parent = $navItems[0];
    $parent->addChild($item);
  }

  public function addNavItemToAboutUs()
  {
    // If you wanted to add some children to the "about us" tab for example,
    // you can loop through the labels and find the about us label,
    // then you set that as the parent, then add the children to it.
    global $navItems;

    // Retrieve the parent item
    $parent = null;

    foreach ($navItems as $item) {
      if ($item->getLabel() === 'About') {
        $parent = $item;
        break;
      }
    }

    // Create and add the child items
    $aboutUs1 = new NavItem('AboutUs1', '/AboutUs1');
    $aboutUs2 = new NavItem('AboutUs2', '/AboutUs2');
    $aboutUs3 = new NavItem('AboutUs3', '/AboutUs3');

    if ($parent !== null) {
      $parent->addChild($aboutUs1);
      $parent->addChild($aboutUs2);
      $parent->addChild($aboutUs3);
    }
  }

}

return new MyPlugin();