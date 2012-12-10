
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
 * Filter Image
 * An application for applying a filter to an image.
 *
 * @package  Joomla.Shell
 *
 * @since    1.0
 */
class Filterimage extends JApplicationCli
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
		// path and filter type are required values.
		// path is /path/to/image
		// filter is the filter to apply such as grayscale.

		// Long args
		$path = $this->input->get('path', null, 'FILE');
		$filter = $this->input->get('filter');
		$foptions = $this->input->get('foptions', array());

		// Short args
		if (!$path)
		{
			$path = $this->input->get('p', null, 'FILE');
		}
		if (!$filter)
		{
			$filter = $this->input->get('f');
		}
		if (!$foptions)
		{
			$foptions = $this->input->get('fo', array());
		}

		$image = new JImage($path);

		$imgProperties = $image->getImageFileProperties($path);

		// Generate filtered image name
		$filename 		= pathinfo($image->getPath(), PATHINFO_FILENAME);
		$fileExtension 	= pathinfo($image->getPath(), PATHINFO_EXTENSION);
		$dirname		= pathinfo($image->getPath(), PATHINFO_DIRNAME);

		$filteredFileName = $dirname .  '/' . $filename . '_' . $filter . '.' . $fileExtension;

		// $foptions refers to an array of options for the specific filter
		$newImage = $image->filter($filter, $foptions);
		//$newImage = $image;
		$newImage->toFile($filteredFileName, $imgProperties->type);

		// $options refers to the toFile options.
		//$filteredImage->toFile($filterdFileName, $type, (array) $options);

		$this->out('Filtered Image created');
		$this->out();

	}
}

if (!defined('JSHELL'))
{
	JApplicationCli::getInstance('Filterimage')->execute();
}
