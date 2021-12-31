<?php

namespace FrostieDE\ComposerDependencyListBundle;

use FrostieDE\ComposerDependencyListBundle\DependencyInjection\ComposerDependencyListExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ComposerDependencyListBundle extends Bundle {
    public function getContainerExtension(): ?ExtensionInterface {
        return new ComposerDependencyListExtension();
    }
}