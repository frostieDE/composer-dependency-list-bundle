<?php

namespace FrostieDE\ComposerDependencyListBundle\Controller;

use FrostieDE\ComposerDependencyList\ComposerDependenciesResolverInterface;
use FrostieDE\ComposerDependencyList\Dependency;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {


    public function __construct(private readonly ComposerDependenciesResolverInterface $dependencyResolver, private readonly string $listTemplate, private readonly string $licenseTemplate) { }

    #[Route("/list", name: "list_composer_dependencies")]
    public function listDependencies(): Response {
        $dependencies = $this->dependencyResolver->getDependencies();

        return $this->render($this->listTemplate, [
            'dependencies' => $dependencies
        ]);
    }

    #[Route('/license/{project}', name: "show_license", requirements: ["project" => ".+"])]
    public function showLicense(string $project): Response {
        $dependency = $this->getDependency($project);

        if($dependency === null) {
            throw new NotFoundHttpException();
        }

        $licensePath = $dependency->getLicensePath();
        $license = null;

        if(is_file($licensePath) && is_readable($licensePath)) {
            $license = file_get_contents($licensePath);
        }

        return $this->render($this->licenseTemplate, [
            'dependency' => $dependency,
            'license' => $license
        ]);
    }

    /**
     * @param string $project
     * @return Dependency|null
     */
    private function getDependency(string $project): ?Dependency {
        $dependencies = $this->dependencyResolver->getDependencies();

        foreach($dependencies as $dependency) {
            if($dependency->getName() === $project) {
                return $dependency;
            }
        }

        return null;
    }
}