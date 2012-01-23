<?php

/**
 * The Wigbi IPhpFileIncluder interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IPhpFileIncluder interface.
 * 
 * This interface can be implemented by any class that can be used
 * to include and require PHP files and folders.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
interface IPhpFileIncluder
{	
	/**
	 * Include a certain path.
	 */
	function includePath($path, $once = false);
	
	/**
	 * Require a certain file.
	 */
	function requirePath($path, $once = false);
}

?>