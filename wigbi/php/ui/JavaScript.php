<?php

/**
 * Wigbi JavaScript class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi JavaScript class.
 * 
 * This class can be used to execute JavaScript code with PHP. The
 * JS code is printed to the the page and executed once the client
 * loads the page.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
class JavaScript
{
	/**
	 * Display a message in an alert box, using the alert function.
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
	 * @param	string	$url	The url to redirect the client to.
	 */
	public static function redirect($url)
	{
		print "<script type='text/javascript'>location.href='" . $url . "';</script>";
	}
	
	/**
	 * Reload the current URL, using the location.reload function.
	 */
	public static function reload()
	{
		print "<script type='text/javascript'>location.reload();</script>";
	}
}

?>