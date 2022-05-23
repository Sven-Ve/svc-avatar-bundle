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
      ->scalarNode('backgroundcolor')->cannotBeEmpty()->defaultValue('random')->info('Which background color should the image have?')->end()
    ->end();

    return $treeBuilder;
  }
}
