<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009-2012
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Provide function to add clear default functionality to form fields
 */
class ClearDefault extends Frontend
{

	/**
	 * Add cleardefault-javascript
	 */
	public function addAttributes($objWidget, $formId)
	{
		if ($objWidget->placeholder != '')
		{
			$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/cleardefault/html/cleardefault.js';

			// Unset POST value if the default was submitted
			if ($this->Input->post($objWidget->name, true) == $objWidget->placeholder)
			{
				$this->Input->setPost($objWidget->name, null);
				unset($_SESSION['FORM_DATA'][$objWidget->name]);
			}

			global $objPage;

			// Create class that will output the placeholder attribute
			if ($objPage->outputFormat == 'xhtml')
			{
				$strClass = get_class($objWidget);

				if (!class_exists($strClass . 'ClearDefault', false))
				{
					eval('
class ' . $strClass . 'ClearDefault extends ' . $strClass . '
{
	public function getAttributes($arrStrip=array())
	{
		$strPlaceholder = $this->placeholder;
		$strAttributes = parent::getAttributes($arrStrip);

		if ($strPlaceholder != \'\')
		{
			$strAttributes .= \' placeholder="\' . $strPlaceholder . \'"\';
		}

		return $strAttributes;
	}
}');
				}

				// Serialize widget and unserialize into new class
				$strObject = serialize($objWidget);
				$intClassLength = strlen($strClass);
				$intClassChars = strlen($intClassLength);
				$strObject = 'O:' . strlen($strClass.'ClearDefault') . ':"' . $strClass.'ClearDefault":' . substr($strObject, ($intClassChars + $intClassLength + 6));

				$objWidget = unserialize($strObject);
			}
		}

		return $objWidget;
	}
}

