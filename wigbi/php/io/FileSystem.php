<?php

/**
 * The Wigbi FileHandler class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi FileHandler class.
 * 
 * This class can be used to handle the file system, like creating
 * and deleting files and directories.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
class FileSystem implements IFileSystem
{
	/**
	 * Create a certain directory.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function createDir($path)
	{
		return mkdir($path);
	}
	
	/**
	 * Delete a certain directory.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function deleteDir($path)
	{
		return rmdir($path);
	}
		
	/**
	 * Delete a certain file.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function deleteFile($path)
	{
		return unlink($path);
	}
	
	/**
	 * Check if a certain directory exists.
	 * 
	 * @return	bool
	 */
	function dirExists($path)
	{
		return is_dir($path);
	}
	
	/**
	 * Check if a certain file exists.
	 * 
	 * @return	bool	Whether or not the file exists.
	 */
	function fileExists($path)
	{
		return file_exists($path);
	}
	
	/**
	 * Find pathnames matching a pattern.
	 * 
	 * @return	array	A list of matching paths.
	 */
	public function glob($pattern, $flags = 0)
	{
		return glob($pattern, $flags);
	}
	
	/**
	 * Read the content of a certain file.
	 * 
	 * @return	string	The content of the file.
	 */
	public function readFile($path) 
	{
		return file_get_contents($path);
	}
	
	/**
	 * Write content to file.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function writeFile($path, $mode, $content)
	{  
		$file = fopen($path, $mode) or die ("FileHandler.append - Error opening $path");
		fwrite($file, $content);
		fclose($file);
	}
}

?>