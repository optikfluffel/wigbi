<?php

/**
 * Wigbi JavaScriptRunner class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi JavaScriptRunner class.
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
	 * Display a message in an alert box, using alert.
	 */
	public static function alert($message, $addTags = true)
	{
		JavaScript::run("alert('$message');", $addTags);	
	}
	
	/**
	 * Redirect the client to a certain URL, using location.href.
	 * 
	 * @param	string	$url	The url to redirect the client to.
	 */
	public static function redirect($url, $addTags = true)
	{
		JavaScript::run("location.href=\"$url\";", $addTags);
	}
	
	/**
	 * Reload the current URL, using location.reload.
	 */
	public static function reload($addTags = true)
	{
		JavaScript::run("location.reload();", $addTags);
	}
	
	/**
	 * Add a script to the page.
	 */
	public static function run($script, $addTags = true)
	{
		print $addTags ? "<script type=\"text/javascript\">$script</script>" : $script;	
	}
}

?>