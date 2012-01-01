<?php

/**
 * The Wigbi DirectoryHandler class Directory.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi DirectoryHandler class.
 * 
 * This class can be used to handle directories in the file system.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
class DirectoryHandler implements IDirectoryHandler
{	
	/**
	 * Create a certain directory.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function create($path)
	{
		return mkdir($path);
	}
	
	/**
	 * Delete a certain directory.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function delete($path)
	{
		return rmdir($path);
	}
	
	/**
	 * Check if a certain directory exists.
	 * 
	 * @return	bool
	 */
	function exists($path)
	{
		return is_dir($path);
	}
}

?>