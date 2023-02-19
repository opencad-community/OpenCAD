<?php
namespace Opencad\App\Navigation;

interface NavItemInterface {
  public function getLabel(): string;
  public function getUrl(): string;
  public function getChildren(): array;
  public function addChild(NavItemInterface $item);
}
