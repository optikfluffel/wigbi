<?php

/**
 * The Wigbi FileIncluder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi FileIncluder class.
 * 
 * This class can be used to include and require files. Since it's
 * implementing IFileIncluder, it can be mocked in test contexts.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
class FileIncluder implements IFileIncluder
{	
	/**
	 * Include a certain file.
	 */
	public function includeFile($path)
	{
		include($path);
	}
	
	/**
	 * Include a certain file once.
	 */
	public function includeFileOnce($path)
	{
		include_once($path);
	}
	
	/**
	 * Require a certain file.
	 */
	public function requireFile($path)
	{
		require($path);
	}
	
	/**
	 * Require a certain file once.
	 */
	public function requireFileOnce($path)
	{
		require_once($path);
	}
}

?>