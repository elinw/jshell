
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
 * Create Thumbnails
 * An application for creating a thumbnail or set of thumbnails for a given image.
 *
 * @package  Joomla.Shell
 *
 * @since    1.0
 */
class Createthumbnails extends JApplicationCli
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
		// path and size are required values.
		// path is /path/to/image
		// size is size of the thumbnail a string or array: '150x75' or  array('150x75','250x150')

		// Long args
		$path = $this->input->get('path', null, 'FILE');
		$size = $this->input->get('size');
		$method = $this->input->get('creationmethod','self::SCALE_INSIDE', 'RAW');
		$thumbsFolder = $this->input->get('thumbsFolder', null, 'FILE');

		// Short args
		if (!$path)
		{
			$path = $this->input->get('p', null, 'FILE');
		}
		if (!$size)
		{
			$size = $this->input->get('s');
		}
		if (!$method)
		{
			$method = $this->input->get('c','self::SCALE_INSIDE', 'RAW');
		}
		if (!$thumbsFolder)
		{
			$thumbsFolder = $this->input->get('t', null, 'FILE');
		}

		$image = new JImage($path);
	
		$image->createThumbs($size);
		$this->out('Thumbnail created');
		$this->out();

	}
}

if (!defined('JSHELL'))
{
	JApplicationCli::getInstance('Createthumbnails')->execute();
}
