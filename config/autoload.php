<?php


$path = 'system/modules/more_articles/';


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'tkapet',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Classes
    'ModuleMoreArticles'             => $path.'modules/ModuleMoreArticles.php',

));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'mod_more_articles'           => $path.'templates',
));
?>