<?php
namespace Kohkimakimoto\SiteGenerator\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Kohkimakimoto\SiteGenerator\Command\Command;
use Kohkimakimoto\SiteGenerator\Foundation\Generator;
use Kohkimakimoto\SiteGenerator\HttpServer\HttpServer;

class GenerateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("generate")
            ->setDescription("Generate a site from source.")
            ->setDefinition(array(
                new InputOption('watch', null, InputOption::VALUE_NONE, 'Watch source and regenerate site as changes are made.'),
                new InputOption('server', null, InputOption::VALUE_NONE, 'Start an HTTP server to host your generated site'),
            ))
            ;        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $watch = $input->getOption('watch') ?: false;
        $server = $input->getOption('server') ?: false;
        $config = $this->getConfig();

        $generator = new Generator($this->getConfig(), $input, $output);

        if ($server) {

            $httpServer = new HttpServer(
                $config,
                $output
            );
            
            if ($watch) {
                $httpServer->addPeriodicTimer(1, function() use ($generator) {
                    clearstatcache();
                    $generator->run();
                });
            }

            $httpServer->run();

        } else {
            do {
                $generator->run();

                if ($watch) {
                    sleep(1);
                    clearstatcache();
                }

            } while ($watch);
        }
    }
}