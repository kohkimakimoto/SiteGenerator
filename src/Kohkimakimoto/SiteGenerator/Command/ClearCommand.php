<?php
namespace Kohkimakimoto\SiteGenerator\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Kohkimakimoto\SiteGenerator\Command\Command;

class ClearCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("clear")
            ->setDescription("Crear dest contents.")
            ;        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getConfig();

        $fs = new Filesystem();

        $finder = new Finder();
        $finder
            ->ignoreVCS(true)
            ->files()
            ->followLinks()
            ->in($this->config->dest)
            ;

        foreach ($finder as $file) {
            $path = $file->getRealpath();
            if ($fs->exists($path)) {
                $fs->remove($path);
                $output->writeln("<info>Deleted: </info><comment>".$path."</comment>");
            }
        }

        $output->writeln("<info>Done.</info>");
    }
}