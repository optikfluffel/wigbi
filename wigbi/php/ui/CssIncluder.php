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
 * This class can be used to include JavaScript files / folders by
 * adding a separate script tag for each file.
 * 
 * The class will automatically prefix local paths with the client
 * root, so it expects all local paths to application relative. It
 * will leave absolute (begins with /) and global (http, https etc)
 * paths just as they are, however.
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
		$path = $this->adjustPath($path);
		print "<link rel=\"stylesheet\" type=\"text/css\" href=\"$path\" />";
	}
}

?>