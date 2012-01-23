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
 * The class can handle both file and directory paths. If the path
 * is a directory path, the class will include all files within it.
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
	private $_fileSystem;
	private $_fileType;
	
	 
	/**
	 * @param	IFileSystem		$fileSystem		The IFileSystem to use for file system operations.
	 * @param	string			$fileType		The file extension to handle with the includer.
	 */
	public function __construct($fileSystem, $fileType)
	{
		$this->_fileSystem = $fileSystem;
		$this->_fileType = $fileType;
	}
	
	
	/**
	 * Include all files in a certain directory.
	 */
	protected function includeDirectory($path)
	{
		foreach ($this->_fileSystem->glob($path . "/*." . $this->_fileType) as $file)
			$this->includeFile($file);
	}
	
	/**
	 * Include all files in a certain directory.
	 */
	abstract protected function includeFile($path);
	
	/**
	 * Include a certain path, either a file or a folder.
	 */
	public function includePath($path)
	{
		if ($this->_fileSystem->dirExists($path))
			return $this->includeDirectory($path);
		
		$this->includeFile($path);
	}
}

?>