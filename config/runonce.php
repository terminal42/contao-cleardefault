<?php

/**
 * cleardefault extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2014, terminal42 gmbh
 * @author     terminal42 gmbh <info@terminal42.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 * @link       http://github.com/terminal42/contao-cleardefault
 */


class ClearDefaultRunonce extends Controller
{

	/**
	 * Initialize the object
	 */
	public function __construct()
	{
		parent::__construct();

		// Fix potential Exception on line 0 because of __destruct method (see http://dev.contao.org/issues/2236)
		$this->import((TL_MODE=='BE' ? 'BackendUser' : 'FrontendUser'), 'User');
		$this->import('Database');
	}


	/**
	 * Execute all runonce files in module config directories
	 */
	public function run()
	{
		if (!$this->Database->fieldExists('cleardefault', 'tl_form_field'))
		{
			return;
		}

		if (!$this->Database->fieldExists('placeholder', 'tl_form_field'))
		{
			$this->Database->query("ALTER TABLE tl_form_field ADD `placeholder` varchar(255) NOT NULL default ''");
		}

		$this->Database->query("UPDATE tl_form_field SET placeholder=value, value='' WHERE cleardefault='1' AND placeholder=''");
		$this->Database->query("ALTER TABLE tl_form_field DROP `cleardefault`");
	}
}


/**
 * Instantiate controller
 */
$objClearDefaultRunonce = new ClearDefaultRunonce();
$objClearDefaultRunonce->run();

