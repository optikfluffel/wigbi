<?php

/**
 * Wigbi.PHP.MasterPage class file.
 * 
 * Wigbi is free software. You can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *  
 * Wigbi is distributed in the hope that it will be useful, but WITH
 * NO WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public
 * License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 * along with Wigbi. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The Wigbi.PHP.MasterPage class.
 * 
 * This class can be used to create page templates that can be used
 * by many pages. A master page is a template that a page can apply
 * variables and content to.
 *  
 * To use master pages with Wigbi, follow these steps:
 * 
 * <ol>
 * 	<li>In the PAGE, include "wigbi/wigbi.php" topmost.</li>
 * 	<li>In the PAGE, start and stop Wigbi within content areas that are NOT used by the master page.</li>
 * 	<li>In the MASTER PAGE, start Wigbi within the HEAD tag and stop it at the end of the page.</li>
 * 	<li>In the PAGE, populate content areas with <i>open(...)</i> and <i>close</i>.</li>
 * 	<li>In the MASTER PAGE, retrieve content area content with <i>content(...)</i>.</li>
 * 	<li>In the PAGE, set variables with <i>variable(...)</i>.</li>
 * 	<li>In the MASTER PAGE, get available variables with <i>variable(...)</i>.</li>
 * 	<li>In the PAGE, call <i>MasterPage::build()</i> to generate the final output.</li>
 * 	<li>Remember to stop Wigbi in both the page and the master page!</li>
 * </ol>
 * 
 * A page that uses a master page must NOT generate content outside
 * of a open/close pair since such content is displayed at the very
 * top of the page, before the master page content.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.1.0
 * 
 * @static
 */
class MasterPage
{	
	/**#@+
	 * @ignore
	 */ 
	private static $_contentAreas = array();
	private static $_currentContentArea;
	private static $_filePath;
	/**#@-*/
	
	
	
	/**
	 * Get all the content areas that have been populated so far.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	array	All the content areas that have been populated so far.
	 */
	public static function contentAreas()
	{
		return MasterPage::$_contentAreas;
	}
	
	/**
	 * Get/set the poath to the master page file.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$newValue	Optional set value; default null.
	 */
	public static function filePath($newValue = null)
	{
		if (func_num_args() > 0)
			MasterPage::$_filePath = func_get_arg(0);
		return MasterPage::$_filePath;
	}
	
	
	
	/**
	 * Build the master page, using the file path to require the master page file.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$templateFile	Optional file path; default null.
	 */
	public static function build()
	{
		require_once surl(MasterPage::$_filePath);
	}
	
	/**
	 * Close the last opened content area.
	 * 
	 * @access	public
	 * @static
	 */	
	public static function closeContentArea()
	{
		MasterPage::$_contentAreas[MasterPage::$_currentContentArea] = ob_get_clean();
	}
	
	/**
	 * Get the content of a certain content area.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$contentAreaName	The name of the content area.
	 */
  public static function getContent($contentAreaName)
  {
  	if (array_key_exists($contentAreaName, MasterPage::$_contentAreas))
  		return MasterPage::$_contentAreas[$contentAreaName];
		return "";
	}
	
	/**
	 * Open a certain content area for writing.
	 * 
	 * Content can be defined with print, echo or by ending the php
	 * tag, adding the content, then re-opening the php tag.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$contentAreaName	The name of the content area.
	 */
	public static function openContentArea($contentAreaName)
	{
		MasterPage::$_currentContentArea = $contentAreaName;
		ob_start();
  }
}

?>