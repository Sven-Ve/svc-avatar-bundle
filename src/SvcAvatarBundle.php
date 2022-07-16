<?php

namespace Svc\AvatarBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class SvcAvatarBundle extends AbstractBundle
{
  public function configure(DefinitionConfigurator $definition): void
  {
    $definition->rootNode()
      ->children()
        ->scalarNode('fontcolor')->info('Hex color for the font, without the hash (#)')->end()
        ->scalarNode('backgroundcolor')->defaultValue('random')->info('Hex color for the image background, without the hash (#). Default: random')->end()
        ->integerNode('size')->min(16)->defaultValue(64)->info('Integer specifying the image size')->end()
        ->booleanNode('rounded')->defaultValue(false)->info('Boolean specifying if the returned image should be a circle. Default: false')->end()
        ->booleanNode('bold')->defaultValue(false)->info('Boolean specifying if the returned letters should use a bold font. Default: false')->end()
        ->booleanNode('retina')->defaultValue(true)->info('Boolean specifying if we optimize for a retina display (double the image resolution, only used in the avatar_img tag). Default: true')->end()
      ->end();
  }

  public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
  {
    $container->import('../config/services.yaml');

    $container->services()
      ->get('Svc\AvatarBundle\Twig\AvatarRuntime')
      ->arg(0, $config['size'] ?? 32)
      ->arg(1, $config['backgroundcolor'] ?? 'random')
      ->arg(2, $config['fontcolor'] ?? null)
      ->arg(3, $config['rounded'] ?? false)
      ->arg(4, $config['bold'] ?? false)
      ->arg(5, $config['retina'] ?? true)
    ;
  }
}
