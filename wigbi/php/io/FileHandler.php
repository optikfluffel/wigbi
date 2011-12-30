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
 * This class can be used to handle files. Since it implements the
 * IFileHandler interface it can easily be replaced or mocked away.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
class FileHandler implements IFileHandler
{
	/**
	 * Open an already existing file and fill it with some content.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function append($path, $content)
	{
		
	}
	
	/**
	 * Create a file and fill it with some content.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function create($path, $content)
	{
		
	}
	
	/**
	 * Delete a certain file.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function delete($path)
	{
		
	}
	
	/**
	 * Read the content of a certain file.
	 * 
	 * @return	string	The content of the file.
	 */
	public function read($path) 
	{
		
	}
}

?>