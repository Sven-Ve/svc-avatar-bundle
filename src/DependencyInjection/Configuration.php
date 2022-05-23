<?php

namespace Svc\AvatarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
  public function getConfigTreeBuilder(): TreeBuilder
  {
    $treeBuilder = new TreeBuilder('svc_avatar');
    $rootNode = $treeBuilder->getRootNode();

    $rootNode
    ->children()
      ->scalarNode('foregroundcolor')->info('Which foreground color should the text have?')->end()
      ->scalarNode('backgroundcolor')->cannotBeEmpty()->defaultValue('random')->info('Which background color should the image have?')->end()
      ->integerNode('size')->min(16)->defaultValue(64)->info('Avatar size (please double it for retina screens)')->end()
    ->end();

    return $treeBuilder;
  }
}
