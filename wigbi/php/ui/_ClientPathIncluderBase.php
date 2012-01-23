<?php

/**
 * The Wigbi ClientPathIncluderBase class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ClientPathIncluderBase class.
 * 
 * This base class can be inherited by classes that can be used to
 * include client paths, like JavaScript and CSS files.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
abstract class ClientPathIncluderBase
{
	/**
	 * Apply the client root path to local, non-absolute paths.
	 * 
	 * @return 	string
	 */
	protected function adjustPath($path)
	{
		if ($this->pathIsApplicationRelative($path))
			return Wigbi::clientRoot($path);
		return $path;
	}
	
	/**
	 * Chech whether or not a path is application relative. 
	 * 
	 * @return 	bool
	 */
	public function pathIsApplicationRelative($path)
	{
		$protocol = strstr($path, "://", true);
		if (strlen($protocol) > 0)
			return false;
		
		if (substr($path, 0, 1) == "/")
			return false;
		
		return true;
	}
}

?>