<?php

/**
 * cleardefault extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2014, terminal42 gmbh
 * @author     terminal42 gmbh <info@terminal42.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 * @link       http://github.com/terminal42/contao-cleardefault
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'ClearDefault'         => 'system/modules/cleardefault/ClearDefault.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'moo_cleardefault'      => 'system/modules/cleardefault/templates',
    'j_cleardefault'        => 'system/modules/cleardefault/templates',
));
