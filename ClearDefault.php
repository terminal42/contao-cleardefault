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
			$objWidget->style .= '" onblur="if (this.value==\'\') { this.value=\'' . str_replace("'", "\'", $objWidget->value) . '\'; $(this).addClass(\'cleardefault\'); }" onfocus="if (this.value==\'' . str_replace("'", "\'", $objWidget->value) . '\') { this.value=\'\'; $(this).removeClass(\'cleardefault\'); this.select(); }';
			
			// Cannot use $this->Input->post() because it would find session data
			if (!strlen($_POST[$objWidget->name]) || $_POST[$objWidget->name] == $objWidget->value)
			{
				$objWidget->class = 'cleardefault';
			}
		}
		
		return $objWidget;
	}
	
	
	/**
	 * Validate "cleardefault"-Field, if not the default value was submitted
	 */
	public function validateFormField($objWidget, $formId)
	{
		if ($objWidget->cleardefault)
		{
			$objField = $this->Database->prepare("SELECT * FROM tl_form_field WHERE id=?")
									   ->limit(1)
									   ->execute($objWidget->id);
									   
			if ($objField->value == $objWidget->value)
			{
				if ($objWidget->mandatory)
				{
					$objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['mandatory'], $objWidget->label));
				}
				else
				{
					$objWidget->value = '';
				}
			}
		}
		
		return $objWidget;
	}
}

