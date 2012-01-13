<?php

/**
 * The Wigbi ArrayBasedConfiguration class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ArrayBasedConfiguration class.
 * 
 * This class can be used to handle configuration data that is set
 * with an associative array.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Configuration
 * @version			2.0.0
 */
class ArrayBasedConfiguration implements IConfiguration
{
	private $_data;
	
	
	/**
	 * @param	array	$data	The configurational data.
	 */
	public function __construct($data)
	{
		$this->_data = $data;
	}
	

	/**
	 * Get the currently loaded configuration data. 
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
	 * If this method is called with one parameter, it will define
	 * the key and NOT the section. With two parameters, the first
	 * one will define the section and the section the key.
	 * 
	 * @param	string	$section	The configuration section, if any.
	 * @param	string	$key		The configuration key to retrieve.
	 * @return	string
	 */
	public function get($section, $key = null)
	{
		//Flip key and section of only one param is provided
		if (func_num_args() == 1)
		{
			$tmp = $section;
			$section = $key;
			$key = $tmp; 
		}
		
		//Get the correct section to work with
		$data = $this->_data;
		if ($section != null && isset($data[$section]))
			$data = $data[$section];
		
		//Either return match or null
		if (isset($data[$key]))
			return $data[$key];
		return null;
	}
}

?>