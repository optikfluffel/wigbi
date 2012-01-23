<?php

/**
 * The Wigbi PhpIncluder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi PhpIncluder class.
 * 
 * This class can be used to include PHP files and folders. It can
 * automatically include all PHP files in a certain folder.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
class PhpIncluder implements IPhpIncluder
{
	/**
	 * Include all files in a certain folder.
	 */
	private function includeFolder($path, $once = false)
	{
		foreach (glob($path . "/*.php") as $file)
			$this->includePath($file, $once);
	}
	
	/**
	 * Include a certain path.
	 */
	public function includePath($path, $once = false)
	{
		if (is_dir($path))
			return $this->includeFolder($path, $once);
				
		if ($once)
			return include_once($path);
		
		return include($path);
	}
	
	/**
	 * Require all files in a certain folder.
	 */
	private function requireFolder($path, $once = false)
	{
		foreach (glob($path . "/*.php") as $file)
			$this->requirePath($file, $once);
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