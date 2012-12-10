#!/usr/bin/php
<?php
/**
 * @package    Joomla.Shell
 *
 * @copyright  Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Initialize Joomla framework
const _JEXEC = 1;

const JSHELL = 1;

@ini_set('zend.ze1_compatibility_mode', '0');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load system defines
if (file_exists(dirname(__DIR__) . '/defines.php'))
{
	require_once dirname(__DIR__) . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', dirname(__DIR__));
	require_once JPATH_BASE . '/includes/defines.php';
}
	define('JPATH_JSHELL', JPATH_BASE .'/jshell');

// Get the framework.
require_once JPATH_LIBRARIES . '/import.php';


/**
 * Job to run cli commands
 *
 * @package  Joomla.CLI
 *
 * @since    1.0
 */
class JShell extends JApplicationCli
{
	/**
	 * Entry point for the script
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	public function doExecute()
	{
		foreach ($this->input->args as $arg)
		{
			require_once($arg . '.php');
			$class = ucfirst($arg);
			$command = new $class;
			$command->execute();
			
		}
	}
}

JApplicationCli::getInstance('JShell')->execute();

