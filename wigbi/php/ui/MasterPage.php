<?php

/**
 * Wigbi MasterPage class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi MasterPage class.
 * 
 * This class can be used to setup page templates that can be used
 * by several pages. Master page defines content areas that can be
 * populated by each page that uses it, using open(..) and close().
 * 
 * Pages that use a master page must NOT generate content out of a
 * content area, since this will cause the content to be displayed
 * at the very top of the page.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
class MasterPage
{
	private static $_contentAreas = array();
	private static $_currentContent;
	private static $_filePath;
	
	/**
	 * Get/set the poath to the master page file.
	 * 
	 * @param	string	$newValue	Optional set value.
	 */
	public static function filePath($newValue = null)
	{
		if (func_num_args() > 0)
			MasterPage::$_filePath = func_get_arg(0);
		return MasterPage::$_filePath;
	}
}

?>