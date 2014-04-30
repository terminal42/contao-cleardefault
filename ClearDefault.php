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
 * Provide function to add clear default functionality to form fields
 */
class ClearDefault extends \Frontend
{

	/**
	 * Add cleardefault-javascript
	 */
	public function addAttributes($objWidget, $formId)
	{
		if ($objWidget->placeholder != '' && $objWidget->placeholder == \Input::post($objWidget->name, true))
		{
			\Input::setPost($objWidget->name, null);
			unset($_SESSION['FORM_DATA'][$objWidget->name]);
		}

		return $objWidget;
	}
}

