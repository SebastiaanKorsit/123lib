<?php

require_once 'autoload.php';

class ExtendedFilesystemLoader implements Mustache_Loader
{
    private $baseDirs;
    private $extension = '.mustache';
    private $templates = array();

    /**
     * Mustache filesystem Loader constructor.
     *
     * Passing an $options array allows overriding certain Loader options during instantiation:
     *
     *     $options = array(
     *         // The filename extension used for Mustache templates. Defaults to '.mustache'
     *         'extension' => '.ms',
     *     );
     *
     * @throws Mustache_Exception_RuntimeException if $baseDir does not exist.
     *
     * @param string $baseDirs Base directories containing Mustache template files.
     * @param array  $options Array of Loader options (default: array())
     */
    public function __construct($baseDirs, array $options = array())
    {
        $this->baseDirs = $baseDirs;

        foreach ($baseDirs as &$baseDir) {
            if (strpos($baseDir, '://') === -1) {
                $baseDir = realpath($baseDir);
            }

            if (!is_dir($baseDir)) {
                throw new Mustache_Exception_RuntimeException(sprintf('FilesystemLoader baseDir must be a directory: %s', $baseDir));
            }
        }
        
        if (array_key_exists('extension', $options)) {
            if (empty($options['extension'])) {
                $this->extension = '';
            } else {
                $this->extension = '.' . ltrim($options['extension'], '.');
            }
        }
    }

    /**
     * Load a Template by name.
     *
     *     $loader = new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views');
     *     $loader->load('admin/dashboard'); // loads "./views/admin/dashboard.mustache";
     *
     * @param string $name
     *
     * @return string Mustache Template source
     */
    public function load($name)
    {
        if (!isset($this->templates[$name])) {
            $this->templates[$name] = $this->loadFile($name);
        }

        return $this->templates[$name];
    }

    /**
     * Helper function for loading a Mustache file by name.
     *
     * @throws Mustache_Exception_UnknownTemplateException If a template file is not found.
     *
     * @param string $name
     *
     * @return string Mustache Template source
     */
    protected function loadFile($name)
    {
        $fileName = $this->getFileName($name);

        if (!file_exists($fileName)) {
            throw new Mustache_Exception_UnknownTemplateException($name);
        }

        return file_get_contents($fileName);
    }

    /**
     * Helper function for getting a Mustache template file name.
     *
     * @param string $name
     *
     * @return string Template file name
     */
    protected function getFileName($name)
    {
        foreach ($this->baseDirs as $baseDir) {
            $fileName = $baseDir . '/' . $name;
            if (file_exists($fileName)) {
                return $fileName;
            }
        }

        return $name;
    }
}