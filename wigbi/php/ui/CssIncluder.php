<?php

/**
 * The Wigbi CssIncluder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi CssIncluder class.
 * 
 * This class can be used to include CSS files to the page. It can
 * only handle single files and will add a link tag for every file.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
class CssIncluder extends ClientPathIncluderBase implements ICssIncluder
{
	/**
	 * Include a certain file by outputting a script include tag.
	 */
	public function includeFile($path)
	{
		print "<link rel=\"stylesheet\" type=\"text/css\" href=\"$path\" />";
	}
}

?>