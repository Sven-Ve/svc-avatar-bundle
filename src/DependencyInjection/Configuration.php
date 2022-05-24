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
      ->scalarNode('fontcolor')->info('Hex color for the font, without the hash (#)')->end()
      ->scalarNode('backgroundcolor')->defaultValue('random')->info('Hex color for the image background, without the hash (#). Default: random')->end()
      ->integerNode('size')->min(16)->defaultValue(64)->info('Integer specifying the image size')->end()
      ->booleanNode('rounded')->defaultValue(false)->info('Boolean specifying if the returned image should be a circle. Default: false')->end()
      ->booleanNode('bold')->defaultValue(false)->info('Boolean specifying if the returned letters should use a bold font. Default: false')->end()
      ->booleanNode('retina')->defaultValue(true)->info('Boolean specifying if we optimize for a retina display (double the image resolution, only used in the avatar_img tag). Default: true')->end()
    ->end();

    return $treeBuilder;
  }
}
