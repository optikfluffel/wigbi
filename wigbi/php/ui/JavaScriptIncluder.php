<?php

/**
 * The Wigbi JavaScriptIncluder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi JavaScriptIncluder class.
 * 
 * This class can be used to include js files to the page. It only
 * handles single files, and will add a script tag for every file.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
class JavaScriptIncluder implements IJavaScriptIncluder
{ 
	/**
	 * Output a script tag to a certain JavaScript file path.
	 * 
	 * If a ~/ is used at the beginning of the path, it's replaced
	 * with Wigbi::clientRoot().
	 */
	public function includePath($path)
	{
		$path = str_replace("~/", Wigbi::clientRoot(), $path);
		print "<script type=\"text/javascript\" src=\"$path\"></script>";
	}
}

?>