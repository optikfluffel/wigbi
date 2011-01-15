<?php

/**
 * Wigbi.PHP.JavaScript class file.
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
 * The Wigbi.PHP.JavaScript class.
 * 
 * This class can be used to execute JavaScript functions in PHP. It
 * adds the proper JavaScript code to the executing page, so that it
 * is executed once the page loads at the client.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 * 
 * @static
 */
class JavaScript
{	
	/**
	 * Display a message in an alert box, using the alert function.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$message	The message to alert.
	 */
	public static function alert($message)
	{
		print "<script type=\"text/javascript\">alert('$message');</script>";	
	}
	
	/**
	 * Redirect the client to a certain URL, using location.href.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$url	The url to redirect the client to.
	 */
	public static function redirect($url)
	{
		print "<script type='text/javascript'>location.href='" . $url . "';</script>";
	}
	
	/**
	 * Reload the current URL, using the location.reload function.
	 * 
	 * @access	public
	 * @static
	 */
	public static function reload()
	{
		print "<script type='text/javascript'>location.reload();</script>";
	}
}

?>