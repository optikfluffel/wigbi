<?php

/**
 * The Wigbi IDirectoryHandler interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IDirectoryHandler interface.
 * 
 * This interface can be implemented by any class that can be used
 * to handle folders.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
interface IDirectoryHandler
{	
	/**
	 * Create a certain directory.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	function create($path);
	
	/**
	 * Delete a certain directory.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	function delete($path);
	
	/**
	 * Check if a certain directory exists.
	 * 
	 * @return	bool	Whether or not the file exists.
	 */
	function exists($path);
}

?>