<?php

/**
 * cleardefault extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2009-2014, terminal42 gmbh
 * @author     terminal42 gmbh <info@terminal42.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 * @link       http://github.com/terminal42/contao-cleardefault
 */



/**
 * Config
 */
$GLOBALS['TL_DCA']['tl_form_field']['config']['onload_callback'][] = array('tl_form_field_cleardefault', 'showJsLibraryHint');


class tl_form_field_cleardefault extends \Backend
{

    /**
	 * Show a hint if a JavaScript library needs to be included in the page layout
	 * @param object
	 */
	public function showJsLibraryHint($dc)
	{
		if ($_POST || Input::get('act') != 'edit') {
			return;
		}

		// Return if the user cannot access the layout module (see #6190)
		if (!\BackendUser::getInstance()->hasAccess('themes', 'modules') || !\BackendUser::getInstance()->hasAccess('layout', 'themes')) {
			return;
		}

	    \System::loadLanguageFile('tl_content');
		\Message::addInfo(sprintf($GLOBALS['TL_LANG']['tl_content']['includeTemplates'], 'j_cleardefault', 'j_cleardefault'));
	}
}
