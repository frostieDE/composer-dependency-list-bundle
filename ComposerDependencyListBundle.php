<?php

namespace FrostieDE\ComposerDependencyListBundle;

use FrostieDE\ComposerDependencyListBundle\DependencyInjection\ComposerDependencyListExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ComposerDependencyListBundle extends Bundle {
    public function getContainerExtension() {
        return new ComposerDependencyListExtension();
    }
}