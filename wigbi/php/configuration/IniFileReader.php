<?php

/**
 * The Wigbi.PHP.IniFileReader class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi.PHP.IniFileReader class.
 * 
 * This class can be used to parse an ini config file and load all
 * sections parameters within it.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Configuration
 * @version			2.0.0
 */
class IniFileReader implements IConfigFileReader
{
	/**
	 * Read the content of a file.
	 * 
	 * @return	mixed	Parsed array if the file could be parsed, otherwise null;
	 */
	public function readFile($path)
	{
		if (!is_file($path))
			return null;
		
		return parse_ini_file($path, true);
	}
}

?>