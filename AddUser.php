<?php
/**
 * @package    Joomla.Shell
 *
 * @copyright  Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

if (!defined('_JEXEC'))
{
	// Initialize Joomla framework
	define('_JEXEC', 1);
}

@ini_set('zend.ze1_compatibility_mode', '0');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load system defines
if (file_exists(dirname(__DIR__) . '/defines.php'))
{
	require_once dirname(__DIR__) . '/defines.php';
}

if (!defined('JPATH_BASE'))
{
	define('JPATH_BASE', dirname(__DIR__));
}

if (!defined('_JDEFINES'))
{
	require_once JPATH_BASE . '/includes/defines.php';
}

// Get the framework.
require_once JPATH_LIBRARIES . '/import.php';


/**
 * Add user
 *
 * @package  Joomla.Shell
 *
 * @since    1.0
 */
class Adduser extends JApplicationCli
{
	/**
	 * Entry point for the script
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function doExecute()
	{
		// username, name, email, groups are required values.
		// password is optional
		// Groups is the array of groups in a csv list

		// Long args
		$username = $this->input->get('username', null,'STRING');
		$name = $this->input->get('name');
		$email = $this->input->get('email', '', 'EMAIL');
		$groups = $this->input->get('groups', null, 'STRING');

		// Short args
		if (!$username)
		{
			$username = $this->input->get('u', null, 'STRING');
		}
		if (!$name)
		{
			$name = $this->input->get('n');
		}
		if (!$email)
		{
			$email = $this->input->get('e', null, 'EMAIL');
		}
		if (!$groups)
		{
			$groups = $this->input->get('g', null, 'STRING');
		}

		$user = new JUser();

		$array = array();
		$array['username'] = $username;
		$array['name'] = $name;
		$array['email'] = $email;

		$user->bind($array);
		$user->save();

		$grouparray = explode(',', $groups);var_dump($grouparray);
		JUserHelper::setUserGroups($user->id, $grouparray);
		foreach ($grouparray as $groupId)
		{
			JUserHelper::addUserToGroup($user->id, $groupId);
		}

		$this->out('User Created');

		$this->out();
	}

}

if (!defined('JSHELL'))
{
	JApplicationCli::getInstance('Adduser')->execute();
}
