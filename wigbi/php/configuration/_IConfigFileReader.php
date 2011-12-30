<?php

/**
 * The Wigbi IConfigFileReader interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IConfigFileReader interface.
 * 
 * This interface can be implemented by any class that can be used
 * to read configuration data from a configuration file.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Configuration
 * @version			2.0.0
 */
interface IConfigFileReader
{
	/**
	 * Read the content of a configuration file.
	 * 
	 * The method must return a dictionary, where the elements are
	 * either string values or sub-dictionaries.
	 * 
	 * @return	mixed	Config dictionary if the file could be parsed, otherwise false;
	 */
	function readFile($path);
}

?>