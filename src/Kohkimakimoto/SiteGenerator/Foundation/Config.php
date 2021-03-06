<?php
namespace Kohkimakimoto\SiteGenerator\Foundation;

class Config
{
    protected $parameters;
    public $source;
    public $dest;
    public $public;
    public $views;
    public $layouts;
    public $includes;
    public $helpers;
    public $server;

    public function __construct($config = array())
    {
        if (isset($config['parameters'])) {
            $this->parameters = $config['parameters'];
        } else {
            $this->parameters = array();
        }

        $this->source = $this->processPath(isset($config['source']) ? $config['source'] : "source");
        $this->dest = $this->processPath(isset($config['dest']) ? $config['dest'] : "dest");
        $this->public = $this->processPath(isset($config['public']) ? $config['public'] : $this->source."/public");
        $this->views = $this->processPath(isset($config['views']) ? $config['views'] : $this->source."/views");
        $this->layouts = $this->processPath(isset($config['layouts']) ? $config['layouts'] : $this->source."/layouts");
        $this->includes = $this->processPath(isset($config['includes']) ? $config['includes'] : $this->source."/includes");
        $this->helpers = $this->processPath(isset($config['helpers']) ? $config['helpers'] : $this->source."/helpers");
        $this->server = array();
        $this->server["port"] = isset($config['server']['port']) ? $config['server']['port'] : "1234";
        $this->server["host"] = isset($config['server']['host']) ? $config['server']['host'] : "0.0.0.0";
    }

    public function getParameter($key, $default = null)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : $default;
    }

    protected function processPath($path, $basePath = null)
    {
        if ($basePath === null) {
            $basePath = getcwd();
        }

        // replace `source` and `dest`
        if ($this->source) {
            $path = str_replace("%source%", $this->source, $path);
        }
        if ($this->dest) {
            $path = str_replace("%dest%", $this->dest, $path);
        }

        // get absolute path
        if (strpos($path, '/') !== 0) {
            $path = $basePath."/".$path;
        }

        return $path;
    }

}
