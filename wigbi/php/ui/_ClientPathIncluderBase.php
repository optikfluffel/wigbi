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
 * For now, the class only handles single files. Directories are a
 * bit more complex and requires glob-operations, path cleanup etc.
 * It will probably be implemented in later versions.
 * 
 * TODO: Implement directory path includes that includes all files
 * in a directory.
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
	 * Include a certain file.
	 */
	abstract protected function includeFile($path);
	
	/**
	 * Include a certain path, either a file or a folder.
	 */
	public function includePath($path)
	{
		$this->includeFile($path);
	}
}

?>