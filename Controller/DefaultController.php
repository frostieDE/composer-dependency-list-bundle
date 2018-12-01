<?php

namespace FrostieDE\ComposerDependencyListBundle\Controller;

use FrostieDE\ComposerDependencyList\ComposerDependenciesResolverInterface;
use FrostieDE\ComposerDependencyList\Dependency;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {

    private $dependencyResolver;

    public function __construct(ComposerDependenciesResolverInterface $dependencyResolver) {
        $this->dependencyResolver = $dependencyResolver;
    }

    /**
     * @Route("/list", name="list_composer_dependencies")
     */
    public function listDependencies() {
        $dependencies = $this->dependencyResolver->getDependencies();
        $template = $this->getParameter('composer_dependency_list.list_template');

        return $this->render($template, [
            'dependencies' => $dependencies
        ]);
    }

    /**
     * @Route("/license/{project}", name="show_license", requirements={"project"= ".+"})
     */
    public function showLicense($project) {
        $dependency = $this->getDependency($project);

        if($dependency === null) {
            throw new NotFoundHttpException();
        }

        $template = $this->getParameter('composer_dependency_list.license_template');

        $licensePath = $dependency->getLicensePath();
        $license = null;

        if(is_file($licensePath) && is_readable($licensePath)) {
            $license = file_get_contents($licensePath);
        }

        return $this->render($template, [
            'dependency' => $dependency,
            'license' => $license
        ]);
    }

    /**
     * @param $project
     * @return Dependency|null
     */
    private function getDependency($project) {
        $dependencies = $this->dependencyResolver->getDependencies();

        foreach($dependencies as $dependency) {
            if($dependency->getName() === $project) {
                return $dependency;
            }
        }

        return null;
    }
}