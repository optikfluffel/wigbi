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
 * to handle files.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Abstractions
 * @version			2.0.0
 */
interface IFileHandler
{	
	/**
	 * Delete a certain file.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	function delete($path);
	
	/**
	 * Read the content of a certain file.
	 * 
	 * @return	string	The content of the file.
	 */
	function read($path);
	
	/**
	 * Write content to file.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	function write($path, $mode, $content);
}

?>