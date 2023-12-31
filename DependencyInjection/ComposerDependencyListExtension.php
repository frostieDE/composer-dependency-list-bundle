<?php

namespace FrostieDE\ComposerDependencyListBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ComposerDependencyListExtension extends Extension {

    public function load(array $configs, ContainerBuilder $container): void {
        $config = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $container->setParameter('composer_dependency_list.lock_file', $config['lock_file']);
        $container->setParameter('composer_dependency_list.list_template', $config['list_template']);
        $container->setParameter('composer_dependency_list.license_template', $config['license_template']);
    }
}