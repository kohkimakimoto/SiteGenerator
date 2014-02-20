<?php
namespace Kohkimakimoto\SiteGenerator\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Kohkimakimoto\SiteGenerator\Command\Command;
use Kohkimakimoto\SiteGenerator\Foundation\Generator;

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
                new InputOption('host', null, InputOption::VALUE_REQUIRED, 'Host'),
                new InputOption('port', null, InputOption::VALUE_REQUIRED, 'Port'),
            ))
            ;        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $watch = $input->getOption('watch') ?: false;
        $server = $input->getOption('server') ?: false;

        $generator = new Generator($this->getConfig());

        if ($server) {



        } else {
            do {
                $generator->run($input, $output);

                if ($watch) {
                    sleep(2);
                    clearstatcache();
                }

            } while ($watch);
        }
    }
}