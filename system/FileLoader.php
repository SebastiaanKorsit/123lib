<?php

require_once 'mustache.php-2.5.1/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();



class FileLoader extends Mustache_Loader_FilesystemLoader implements Mustache_Loader_MutableLoader
{
    private $aliases = array();

    public function __construct($baseDir, array $aliases = array())
    {
        Mustache_Loader_FilesystemLoader::__construct($baseDir, array());
        $this->setTemplates($aliases);
    }

    public function load($name)
    {
        if (!isset($this->aliases[$name])) {
            throw new Mustache_Exception_UnknownTemplateException($name);
        }

        return parent::load($this->aliases[$name]);
    }

    public function setTemplates(array $templates)
    {
        $this->aliases = $templates;
    }

    public function setTemplate($name, $template)
    {
        $this->aliases[$name] = $template;
    }
}