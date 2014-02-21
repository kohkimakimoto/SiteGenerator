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
        if (!$fs->exists(getcwd()."/generator.yml")) {
            $fs->copy(__DIR__."/../Resources/generator.yml", getcwd()."/generator.yml");
            $output->writeln("<info>Created:</info> ".getcwd()."/generator.yml");
        }

        if (!$fs->exists($config->source)) {
            $fs->mkdir($config->source, 0755);
            $output->writeln("<info>Created:</info> ".$config->source);
        }

        if (!$fs->exists($config->public)) {
            $fs->mkdir($config->public, 0755);
            $output->writeln("<info>Created:</info> ".$config->public);
        }

        if (!$fs->exists($config->views)) {
            $fs->mkdir($config->views, 0755);
            $output->writeln("<info>Created:</info> ".$config->views);

            $fs->copy(__DIR__."/../Resources/source/views/index.md", $config->views."/index.md");
            $output->writeln("<info>Created:</info> ".$config->views."/index.md");
        }

        if (!$fs->exists($config->layouts)) {
            $fs->mkdir($config->layouts, 0755);
            $output->writeln("<info>Created:</info> ".$config->layouts);

            $fs->copy(__DIR__."/../Resources/source/layouts/default.php", $config->layouts."/default.php");
            $output->writeln("<info>Created:</info> ".$config->layouts."/default.php");
        }

        /*
        if (!$fs->exists($config->includes)) {
            $fs->mkdir($config->includes, 0755);
            $output->writeln("<info>Created:</info> ".$config->includes);
        }
        */

        if (!$fs->exists($config->helpers)) {
            $fs->mkdir($config->helpers, 0755);
            $output->writeln("<info>Created:</info> ".$config->helpers);
        }
        
        if (!$fs->exists($config->dest)) {
            $fs->mkdir($config->dest, 0755);
            $output->writeln("<info>Created:</info> ".$config->dest);
        }

        $output->writeln("<info>Done.</info>");
    }
}