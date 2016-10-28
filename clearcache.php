<?php
@ini_set('zend.ze1_compatibility_mode', '0');
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('_JEXEC', 1);
define('JPATH_BASE', dirname(__DIR__));
 
// Load system defines
if (file_exists(JPATH_BASE . '/defines.php'))
{
    require_once JPATH_BASE . '/defines.php';
}
 
if (!defined('_JDEFINES'))
{
    require_once JPATH_BASE . '/includes/defines.php';
}
// Get the framework.
require_once JPATH_LIBRARIES . '/import.legacy.php';
 
// Bootstrap the CMS libraries.
require_once JPATH_LIBRARIES . '/cms.php';
/**
 * Clear cache all data
 *
 * @package  Joomla.Shell
 *
 * @since    1.0
 */

class Clearcache extends JApplicationCli
{
	/**
	 * Entry point for the script
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	public function execute()
	{
		$cache = JFactory::getCache();
	
		$cache->clean();
		$this->out('Cache Cleared');
		$this->out();
	}
}
JApplicationCli::getInstance('Clearcache')->execute();
