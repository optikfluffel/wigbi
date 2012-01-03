<?php

/**
 * The Wigbi FileBasedConfiguration class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi FileBasedConfiguration class.
 * 
 * This class can be used to handle configuration data that can be
 * loaded from a file.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Configuration
 * @version			2.0.0
 */
class FileBasedConfiguration implements IConfiguration
{
	private $_data;
	
	
	/**
	 * @param	string				$filePath	The path to the config file that is to be parsed, if any.
	 * @param	IConfigFileReader	$fileReader	The file reader that should be used to read the config file.
	 */
	public function __construct($filePath, $fileReader)
	{
		$this->_data = $fileReader->readFile($filePath);
	}
	

	/**
	 * Get the currently loaded configuration data.
	 * 
	 * The data structure depends on if the data contains sections. 
	 * 
	 * @return	array
	 */
	public function data()
	{
		if ($this->_data)
			return $this->_data;
		return array();
	}
	
	/**
	 * Get a certain configuration key value.
	 * 
	 * @param	string	$key		The configuration key to retrieve.
	 * @param	string	$section	The configuration section, if any.
	 * @return	string
	 */
	public function get($key, $section = null)
	{
		//Get the correct section to work with
		$data = $this->_data;
		if (isset($data[$section]))
			$data = $data[$section];
		
		//Either return match or null
		if (isset($data[$key]))
			return $data[$key];
		return null;
	}
}

?>