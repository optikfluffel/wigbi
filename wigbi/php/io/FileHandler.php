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
	 * Delete a certain file.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function delete($path)
	{
		return unlink($path);
	}
	
	/**
	 * Check if a certain file exists.
	 * 
	 * @return	bool	Whether or not the file exists.
	 */
	function exists($path)
	{
		return file_exists($path);
	}
	
	/**
	 * Read the content of a certain file.
	 * 
	 * @return	string	The content of the file.
	 */
	public function read($path) 
	{
		return file_get_contents($path);
	}
	
	/**
	 * Write content to file.
	 * 
	 * @return	bool	Whether or not the operation succeeded.
	 */
	public function write($path, $mode, $content)
	{  
		$file = fopen($path, $mode) or die ("FileHandler.append - Error opening $path");
		fwrite($file, $content);
		fclose($file);
	}
}

?>