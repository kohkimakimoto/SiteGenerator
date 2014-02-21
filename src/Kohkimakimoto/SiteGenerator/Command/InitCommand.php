<?php
namespace Kohkimakimoto\SiteGenerator\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Kohkimakimoto\SiteGenerator\Command\Command;

class InitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("init")
            ->setDescription("Create initial directories.")
            ;        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getConfig();

        $fs = new Filesystem();
        $fs->mkdir($config->source, 0755);
        $fs->mkdir($config->dest, 0755);
        $fs->mkdir($config->public, 0755);
        $fs->mkdir($config->views, 0755);
        $fs->mkdir($config->layouts, 0755);
        $fs->mkdir($config->includes, 0755);
        $fs->mkdir($config->helpers, 0755);
        $output->writeln("<info>Done.</info>");
    }
}