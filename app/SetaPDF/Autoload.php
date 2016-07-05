<?php

/**
 * Global autoload function for SetaPDF class files
 *
 * @param string $class The classname
 * @return void
 */
function setapdf_autoload($class)
{
    static $path = null;

    $pieces = explode('\\', $class);
    $class = array_pop($pieces);

    if (strpos($class, 'SetaPDF_') === 0) {
        if (null === $path) {
            $path = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
        }

        $filename = str_replace('_', '/', $class) . '.php';
        $fullpath = $path . DIRECTORY_SEPARATOR . $filename;

        require_once $fullpath;
    }
}

spl_autoload_register('setapdf_autoload');