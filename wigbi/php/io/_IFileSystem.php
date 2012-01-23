<?php

/**
 * The Wigbi IFileHandler interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IFileHandler interface.
 * 
 * This interface can be implemented by any class that can be used
 * to handle the file system.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
interface IFileSystem
{
	/**
	 * Create a certain directory.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	function createDir($path);
	
	/**
	 * Delete a certain directory.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	function deleteDir($path);
	
	/**
	 * Delete a certain file.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	function deleteFile($path);
	
	/**
	 * Check if a certain directory exists.
	 * 
	 * @return	bool	Whether or not the file exists.
	 */
	function dirExists($path);
	
	/**
	 * Check if a certain file exists.
	 * 
	 * @return	bool	Whether or not the file exists.
	 */
	function fileExists($path);
	
	/**
	 * Read the content of a certain file.
	 * 
	 * @return	string	The content of the file.
	 */
	function readFile($path);
	
	/**
	 * Write content to file.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	function writeFile($path, $mode, $content);
}

?>