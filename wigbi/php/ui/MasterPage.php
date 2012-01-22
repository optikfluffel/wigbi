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
	private static $_currentContentArea;
	private static $_file;
	private static $_fileIncluder;
	
	/**
	 * Close the last opened content area.
	 * 
	 * @return	string	The resulting content of the content area.
	 */	
	public static function close()
	{
		MasterPage::content(MasterPage::$_currentContentArea, ob_get_clean());
	}
	
	
	/**
	 * Build the master page.
	 */
	public static function build()
	{
		if (!MasterPage::$_file)
			return;
		
		MasterPage::fileIncluder()->includeFile(MasterPage::$_file);
	}
	
	/**
	 * Print or set the content of a certain content area.
	 * 
	 * Instead of using open and close, this method can be used to
	 * instantly populate a content area.
	 * 
	 * Note that the method does not return a value. It prints the
	 * value, since that is what how it is intended to be used.
	 * 
	 * Also note that the method will NOT print anything, if it is
	 * used with a second set value.
	 * 
	 * @param	string	$contentAreaName	The name of the content area.
	 * @param	string	$value				Optional set value.
	 */
	public static function content($contentArea, $value = null)
	{
		if (func_num_args() > 1)
		{
			MasterPage::$_contentAreas[$contentArea] = $value;
			return;
		}
		
		
		if (array_key_exists($contentArea, MasterPage::$_contentAreas))
			print MasterPage::$_contentAreas[$contentArea];
	}
	
	/**
	 * Get/set the path to the master page file.
	 * 
	 * This function can be called anytime before build, but it is
	 * convenient to define it topmost in the page.
	 * 
	 * @param	string	$newValue	Optional set value.
	 */
	public static function file($newValue = null)
	{
		if (func_num_args() > 0)
			MasterPage::$_file = func_get_arg(0);
		return MasterPage::$_file;
	}
	
	/**
	 * Get/set the file includer used to require the master page file.
	 * 
	 * If no file includer is set, a FileIncluder instance is used.
	 * 
	 * @param	IFileIncluder	$newIncluder	Optional set value.
	 */
	public static function fileIncluder($newIncluder = null)
	{
		if (func_num_args() > 0)
			MasterPage::$_fileIncluder = func_get_arg(0);
		
		if (!MasterPage::$_fileIncluder)
		 	MasterPage::$_fileIncluder = new PhpFileIncluder();
		
		return MasterPage::$_fileIncluder;
	}
	
	/**
	 * Open a certain content area for writing.
	 * 
	 * Content can be added to the area either with print, echo or
	 * by ending the php tag, adding the content, and then finally
	 * re-opening the php tag.
	 * 
	 * @param	string	$contentArea	The name of the content area to populate.
	 */
	public static function open($contentArea)
	{
		MasterPage::$_currentContentArea = $contentArea;
		ob_start();
	}
}

?>