<?php

namespace FrostieDE\ComposerDependencyListBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder('composer_dependency_list');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('composer_dependency_list');
        }

        $rootNode
            ->children()
                ->scalarNode('lock_file')->defaultValue('%kernel.project_dir%/composer.lock')->end()
                ->scalarNode('list_template')->defaultValue('@ComposerDependencyList/list.html.twig')->end()
                ->scalarNode('license_template')->defaultValue('@ComposerDependencyList/license.html.twig')->end()
            ->end();

        return $treeBuilder;
    }
}