<?php

namespace FrostieDE\ComposerDependencyListBundle\Command;

use FrostieDE\ComposerDependencyList\Author;
use FrostieDE\ComposerDependencyList\ComposerDependenciesResolverInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('dependencies:list', description: 'Lists all composer dependencies.')]
class ListDependenciesCommand extends Command {

    private ComposerDependenciesResolverInterface $dependenciesResolver;

    public function __construct(ComposerDependenciesResolverInterface $dependenciesResolver, ?string $name = null) {
        parent::__construct($name);

        $this->dependenciesResolver = $dependenciesResolver;
    }

    public function execute(InputInterface $input, OutputInterface $output): int {
        $table = new Table($output);
        $table->setHeaders(['Project', 'License', 'Authors']);

        foreach($this->dependenciesResolver->getDependencies() as $dependency) {
            $authors = implode(', ', array_map(function(Author $author) {
                return $author->getName();
            }, $dependency->getAuthors()));

            $table
                ->addRow([
                    $dependency->getName(),
                    $dependency->getLicenseType(),
                    $authors
                ]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}