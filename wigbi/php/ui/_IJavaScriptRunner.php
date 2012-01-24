<?php

/**
 * Wigbi IJavaScriptRunner interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IJavaScriptRunner interface.
 * 
 * This interface can be implemented by any class that can be used
 * to execute JavaScript code with PHP.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
interface IJavaScriptRunner
{
	/**
	 * Display a message in an alert box.
	 */
	function alert($message, $addTags = true);
	
	/**
	 * Redirect the client to a certain URL, using location.href.
	 */
	function redirect($url, $addTags = true);
	
	/**
	 * Reload the current URL, using location.reload.
	 */
	function reload($addTags = true);
	
	/**
	 * Run a custom script.
	 */
	function run($script, $addTags = true);
}

?>