<?php

/**
 * Wigbi.PHP.IniHandler class file.
 * 
 * Wigbi is free software. You can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *  
 * Wigbi is distributed in the hope that it will be useful, but WITH
 * NO WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public
 * License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 * along with Wigbi. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The Wigbi.PHP.IniHandler class.
 * 
 * This class can be used to parse an INI file and load all sections
 * and parameters within it. Sections are supported but optional.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 */
class IniHandler
{
	/**#@+
	 * @ignore
	 */
	private $_data = array();
	private $_filePath;
	/**#@-*/
	
	
	
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	string	$filePath	The path to the INI file that is to be parsed, if any.
	 */
	public function __construct($filePath = null)
	{
		if ($filePath)
			$this->parseFile($filePath);
	}
	
	
	
	/**
	 * Get the currently loaded ini data.
	 * 
	 * The structure of this property depends on if the parsed file
	 * did contain any sections. See parse_ini_file for further info. 
	 * 
	 * @access	public
	 * 
	 * @return	array	The currently loaded ini data.
	 */
	public function data()
	{
		if ($this->_data)
			return $this->_data;
		return array();
	}
	
	/**
	 * Get the path to the currently loaded file. 
	 * 
	 * @access	public
	 * 
	 * @return	string	The path to the currently loaded file.
	 */
	public function filePath()
	{
		return $this->_filePath;
	}
	
	
	
	/**
	 * Get a parameter from the currently loaded ini data.
	 * 
	 * The section parameter is optional and should only be provided
	 * if the currently loaded data contains any sections.
	 * 
	 * @access	public
	 * 
	 * @param		string	$parameter	The parameter to retrieve.
	 * @param		string	$section		The parameter section, if the INI data contains sections; default blank.
	 * @return	string							Parameter value, if any.
	 */
	public function get($parameter, $section = "")
	{
		//Get the correct section to work with
		$data = $this->_data;
		if (isset($data[$section]))
			$data = $data[$section];
		
		//Either return match or null
		if (isset($data[$parameter]))
			return $data[$parameter];
		return null;
	}
	
	/**
	 * Parse an INI file and all its sections and parameters.
	 * 
	 * @access	public
	 * 
	 * @param		string	$filePath	The path to the INI file that is to be parsed, if any.
	 * @return	mixed							Parsed array if the file could be parsed, otherwise false;
	 */
	public function parseFile($filePath)
	{
		$this->_filePath = $filePath;
		
		if (is_file($filePath))
		{
			$this->_data = parse_ini_file($filePath, true);
			return $this->_data;
		}
		
		return false;
	}
}

?>