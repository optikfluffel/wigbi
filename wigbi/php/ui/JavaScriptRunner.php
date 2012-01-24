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
class JavaScriptRunner implements IJavaScriptRunner
{
	/**
	 * Display a message in an alert box, using alert.
	 */
	public function alert($message, $addTags = true)
	{
		$this->run("alert('$message');", $addTags);	
	}
	
	/**
	 * Redirect the client to a certain URL, using location.href.
	 */
	public function redirect($url, $addTags = true)
	{
		$this->run("location.href=\"$url\";", $addTags);
	}
	
	/**
	 * Reload the current URL, using location.reload.
	 */
	public function reload($addTags = true)
	{
		$this->run("location.reload();", $addTags);
	}
	
	/**
	 * Add a custom script to the page.
	 */
	public function run($script, $addTags = true)
	{
		print $addTags ? "<script type=\"text/javascript\">$script</script>" : $script;	
	}
}

?>