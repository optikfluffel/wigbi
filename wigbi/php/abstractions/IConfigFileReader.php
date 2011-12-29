<?php

/**
 * The Wigbi.PHP.IFileReader interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi.PHP.IFileReader interface.
 * 
 * This interface can be implemented by any class that can be used
 * to read file content.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Abstractions
 * @version			2.0.0
 */
interface IConfigFileReader
{
	/**
	 * Read the content of a file.
	 * 
	 * This method must return a dictionary where the elements are
	 * either string values or sub-dictionaries.
	 * 
	 * @return	mixed	Config dictionary if the file could be parsed, otherwise false;
	 */
	function readFile($path);
}

?>