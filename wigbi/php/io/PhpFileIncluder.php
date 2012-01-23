<?php

/**
 * The Wigbi PhpFileIncluder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi PhpFileIncluder class.
 * 
 * This class can be used to include PHP files and folders, either
 * once or each time a file is provided.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
class PhpFileIncluder implements IPhpFileIncluder
{	
	/**
	 * Include a certain file.
	 */
	public function includePath($path, $once = false)
	{
		if ($once)
			return include_once($path);
		return include($path);
	}
	
	/**
	 * Require a certain file.
	 */
	public function requirePath($path, $once = false)
	{
		if ($once)
			return require_once($path);
		return require($path);
	}
}

?>