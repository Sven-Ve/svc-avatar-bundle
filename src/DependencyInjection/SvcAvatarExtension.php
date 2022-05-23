<?php

namespace Svc\AvatarBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SvcAvatarExtension extends Extension
{
  public function load(array $configs, ContainerBuilder $container)
  {
    $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.xml');

    $configuration = $this->getConfiguration($configs, $container);
    $config = $this->processConfiguration($configuration, $configs);

    $definition = $container->getDefinition('svc_avatar.twig_runtime');
    $definition->setArgument(0, $config['size']);
    $definition->setArgument(1, $config['backgroundcolor']);
    $definition->setArgument(2, $config['fontcolor'] ?? null);
    $definition->setArgument(3, $config['rounded'] ?? false);
    $definition->setArgument(4, $config['bold'] ?? false);
  }
}
