
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
 * Rotating an Image
 * An application for rotating an image.
 *
 * @package  Joomla.Shell
 *
 * @since    1.0
 */
class Rotateimage extends JApplicationCli
{
	/**
	 * Entry point for the script
	 *
	 * Currently available options are grayscale, sketchy, brightness, embossed,
	 * edgedetect, negate and smooth.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function doExecute()
	{
		// Path and angle type are required values.
		// Path is /path/to/image
		// Angle is the angle to rotate
		// Background is background color for new areas
		// Createnew is whether to create a new image or replace the current. Right now it is always true

		// Long args
		$path = $this->input->get('path', null, 'FILE');
		$angle = $this->input->get('angle', 0, 'FLOAT');
		$background = $this->input->get('background', -1);
		$createNew = $this->input->get('createnew', true);

		// Short args
		if (!$path)
		{
			$path = $this->input->get('p', null, 'FILE');
		}
		if (!$angle)
		{
			$angle = $this->input->get('a', 0, 'FLOAT');
		}
		if (!$background)
		{
			$background = $this->input->get('b', -1);
		}
		if (!$createNew)
		{
			$createNew = $this->input->get('c', true);
		}

		$image = new JImage($path);
		$rotated = $image->rotate($angle, $background, $createNew);

		if ($createNew)
		{
			// Generate rotated image name
			$imgProperties	= $rotated->getImageFileProperties($path);
			$filename 		= pathinfo($image->getPath(), PATHINFO_FILENAME);
			$fileExtension 	= pathinfo($image->getPath(), PATHINFO_EXTENSION);
			$dirname		= pathinfo($image->getPath(), PATHINFO_DIRNAME);

			$newname = $dirname .  '/' . $filename . '_rotated_' . $angle . '.' . $fileExtension;
			$rotated->toFile($newname, $imgProperties->type);
		}
		else
		{
			$image->toFile($image->getPath(), $imgProperties->type);
		}

		$this->out('Image rotated.');
		$this->out();
	}
}

if (!defined('JSHELL'))
{
	JApplicationCli::getInstance('Rotateimage')->execute();
}
