<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009-2010
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
		if ($objWidget->cleardefault)
		{
			$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/cleardefault/html/cleardefault.js';
			
			$objWidget->style .= '" placeholder="' . specialchars($objWidget->value) . '';
			
			// Unset POST value if the default was submitted
			if ($_POST[$objWidget->name] == $objWidget->value)
			{
				$this->Input->setPost($objWidget->name, null);
				unset($_SESSION['FORM_DATA'][$objWidget->name]);
			}
		}
		
		return $objWidget;
	}
	
	
	/**
	 * Validate "cleardefault"-Field, if not the default value was submitted
	 */
	public function validateFormField($objWidget, $formId)
	{
		if ($objWidget->cleardefault && !$objWidget->value)
		{
			$objField = $this->Database->prepare("SELECT * FROM tl_form_field WHERE id=?")
									   ->limit(1)
									   ->execute($objWidget->id);
			
			$objWidget->value = $objField->value;
		}
		
		return $objWidget;
	}
}

