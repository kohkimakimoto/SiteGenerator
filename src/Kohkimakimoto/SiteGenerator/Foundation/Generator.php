<?php
namespace Kohkimakimoto\SiteGenerator\Foundation;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Yaml\Yaml;
use \Michelf\MarkdownExtra;

class Generator
{
    protected $config;
    protected $input;
    protected $output;

    public function __construct($config, $input, $output)
    {
        $this->config = $config;
        $this->input = $input;
        $this->output = $output;
    }

    public function run()
    {
        $input = $this->input;
        $output = $this->output;

        $output->writeln("<info>Start generating.</info>");
        
        $this->processPublic();
        $this->processViews();

        $output->writeln("<info>Done.</info>");
    }

    protected function processPublic()
    {
        $this->output->writeln("<info>Process:</info> <comment>public</comment>");
        $fs = new Filesystem();
        $finder = new Finder();

        if ($this->config->public) {
            $finder->files()->in($this->config->public);
            foreach ($finder as $file) {
                $src = $file->getRealpath();
                $dest = $this->config->dest.str_replace($this->config->public, "", $src);
                $fs->copy($src, $dest);

                if ($this->output->isVerbose()) {
                    $this->output->writeln("  <info>Put:</info> $dest (from <comment>$src</comment>)");
                } else {
                    $this->output->writeln("  <info>Put:</info> $dest");
                }
            }
        }
    }

    protected function processViews()
    {
        $this->output->writeln("<info>Process:</info> <comment>views</comment>");
        $fs = new Filesystem();
        $finder = new Finder();

        if ($this->config->views) {
            $finder->files()->in($this->config->views);
            foreach ($finder as $file) {
                $src = $file->getRealpath();
                $dest = $this->config->dest.str_replace($this->config->views, "", $src);
                $dest = preg_replace("/(.+)(\.[^.]+$)/", "$1", $dest);
                if (strpos(basename($dest), ".") === false) {
                    $dest .= ".html";
                }

                // At first, all templates are precessed as PHP template.
                $content = $this->processPHPView($src);
                // At second, yaml front matter(like the jekyll) is precessed.
                list($params, $content) = $this->processYamlFrontMatter($content);

                // At third, parse a specific format by extention.
                preg_match("/(\.[^.]+$)/", $src, $matches);
                $ext = $matches[0];                    
                if ($ext == ".md") {
                    $content = $this->processMarkdownView($content);                    
                }
                
                // process a layout
                $content = $this->processLayout($params, $content);

                // output
                file_put_contents($dest, $content);

                if ($this->output->isVerbose()) {
                    $this->output->writeln("  <info>Put:</info> $dest (from <comment>$src</comment>)");
                } else {
                    $this->output->writeln("  <info>Put:</info> $dest");
                }
            }
        }
    }

    protected function processPHPView($src)
    {
        ob_start();
        include $src;
        $content = ob_get_clean();
        return $content;
    }

    protected function processYamlFrontMatter($content)
    {
        $yaml = array();
        $parts = preg_split('/[\n]*[-]{3}[\n]/', $content, 3);
        if (count($parts) >= 3) {
            // has yaml front matter
            $yaml = Yaml::parse($parts[1]);
            $content = $parts[2];
        }

        return array($yaml, $content);
    }

    protected function processMarkdownView($content)
    {
        return MarkdownExtra::defaultTransform($content);
    }

    protected function processLayout($params, $content)
    {
        extract($params);

        if (isset($layout)) {
            $finder = new Finder();
            if ($this->config->layouts) {
                $finder->files()->name("$layout.*")->in($this->config->layouts);
                if (count($finder)) {
                    foreach ($finder as $file) {
                        $layoutPath = $file->getRealpath();
                        ob_start();
                        include $layoutPath;
                        $content = ob_get_clean();
                        break;
                    }
                }
            }
        }

        return $content;
    }


}