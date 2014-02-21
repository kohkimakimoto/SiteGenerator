<?php
namespace Kohkimakimoto\SiteGenerator\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use Kohkimakimoto\SiteGenerator\Foundation\Config;

/**
 * Altax console application
 */
class Application extends \Symfony\Component\Console\Application
{
    const NAME = "SiteGenerator";
    const VERSION = "0.1.0";

    protected $config;

    public function __construct()
    {
        parent::__construct(self::NAME, self::VERSION);
    }

    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->setupConfig();
        $this->loadHelpers();
        $this->registerCommands();
        return parent::doRun($input, $output);
    }

    protected function setupConfig()
    {
        // setup environment
        if (!is_file(getcwd()."/generator.yml")) {
            $this->config = new Config();
        } else {
            $this->config = new Config(Yaml::parse(file_get_contents(getcwd()."/generator.yml")));
        }
    }

    protected function loadHelpers()
    {
        // load system helper
        require_once __DIR__."/../Foundation/helpers.php";

        // load user defined helper
        $finder = new Finder();
        if ($this->config->helpers && is_dir($this->config->helpers)) {
            $finder->files()->name('*.php')->in($this->config->helpers);
            foreach ($finder as $file) {
                $helper = $file->getRealpath();
                require_once $helper;
            }
        }

    }

    protected function registerCommands()
    {   
        // register commands
        $finder = new Finder();
        $finder->files()->name('*Command.php')->in(__DIR__."/../Command");
        foreach ($finder as $file) {
            if ($file->getFilename() === 'Command.php') {
                continue;
            }

            $class = "Kohkimakimoto\SiteGenerator\Command\\".$file->getBasename('.php');
            $r = new \ReflectionClass($class);
            $command = $r->newInstance($this->config);
            $this->add($command);
        }
    }
}