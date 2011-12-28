<?php

/**
 * The Wigbi.PHP.FileBasedConfiguration class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi.PHP.FileBasedConfiguration class.
 * 
 * This class can be used to access configuration data that can be
 * retrieved from a file.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Configuration
 * @version			2.0.0
 */
class FileConfiguration implements IConfiguration
{
	/**
	 * Create an instance of the class.
	 * 
	 * @param	string				$filePath	The path to the config file that is to be parsed, if any.
	 * @param	IConfigFileReader	$fileReader	The file reader that should be used to read the config file.
	 */
	public function __construct($filePath, $fileReader)
	{
	}
	

	/**
	 * Get a certain configuration key value.
	 * 
	 * @param	string	$key		The configuration key to retrieve.
	 * @param	string	$section	The configuration section, if any.
	 * @return	string
	 */
	public function get($key, $section = "")
	{
		return null;
	}
}

?>