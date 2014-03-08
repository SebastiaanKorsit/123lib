<?php

require_once '123lib/layout/mustache/autoload.php';
require_once '123lib/layout/mustache/ExtendedFilesystemLoader.php';

class VariableFilesystemLoader extends ExtendedFilesystemLoader implements Mustache_Loader_MutableLoader
{
    private $aliases = array();

    public function __construct($baseDirs, array $aliases = array())
    {
        ExtendedFilesystemLoader::__construct($baseDirs, array());
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

