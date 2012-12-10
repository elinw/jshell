
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
 * An application for creating a thumbnail or set of thumbnails for all images in a folder.
 * This will wipe out old thumbnails in the destination folder
 *
 * @package  Joomla.Shell
 *
 * @since    1.0
 */
class Createthumbnailsfolder extends JApplicationCli
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
		jimport('joomla.filesystem.folder');

		// path and size are required values.
		// path is /path/to/imagefolder
		// size is size of the thumbnail a string or array: '150x75' or  array('150x75','250x150')

		// Long args
		$path = $this->input->get('path', null, 'PATH');
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

		$imageArray = (array) JFolder::files($path, $filter = '.', $recurse = false, $full = false, $exclude = array('.svn', 'CVS', '.DS_Store', '__MACOSX', 'index.html'));

		foreach ($imageArray as $image)
		{
			$image = new JImage( $path . '/' . $image);
			$image->createThumbs($size);
		}
		
		$this->out('Thumbnails created');
		$this->out();
	}
}

if (!defined('JSHELL'))
{
	JApplicationCli::getInstance('Createthumbnailsfolder')->execute();
}
