<?php
namespace Opencad\App\Navigation;

use Opencad\App\Navigation\NavItemInterface;


class NavItem implements NavItemInterface
{
  private $label;
  private $url;
  private $children;

  public function __construct(string $label, string $url)
  {
    $this->label = $label;
    $this->url = $url;
    $this->children = array();
  }

  public function getLabel(): string
  {
    return $this->label;
  }

  public function getUrl(): string
  {
    return $this->url;
  }

  public function addChild(NavItemInterface $item)
  {
    $this->children[] = $item;
  }

  public function getChildren(): array
  {
    return $this->children;
  }
}
