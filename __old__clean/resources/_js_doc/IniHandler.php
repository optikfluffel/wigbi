<?php
/**
 * Wigbi.JS.IniHandler class file.
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
 * The Wigbi.JS.IniHandler class.
 * 
 * This class can be used to handle INI data. It works just like the
 * corresponding PHP class, but one IMPORTANT difference between the
 * two classes is that the PHP class is initialized with a file path
 * while the JavaScript class uses an associative array.  
 * 
 * See the documentation for the corresponding PHP class for further
 * information about how to work with INI files.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 */
class IniHandler_ extends WigbiClass_
{	
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	array	$data	The INI data that should be handled by the class.
	 */
	public function __construct($data) { }
	
	
	
	/**
	 * Get/set the currently loaded ini data.
	 * 
	 * The structure of this property depends on if the parsed file
	 * did contain any sections. See parse_ini_file for further info. 
	 * 
	 * @access	public
	 * 
	 * @param	array	Optional set value.
	 * @return	array	The currently loaded ini data.
	 */
	public function data($value = "") { return array(); }
	
	
	
	/**
	 * Get a parameter from the currently loaded ini data.
	 * 
	 * The section parameter is optional and should only be provided
	 * if the currently loaded data contains any sections.
	 * 
	 * @access	public
	 * 
	 * @param	string	$parameter	The parameter to retrieve.
	 * @param	string	$section	The parameter section, if the INI data contains sections; default blank.
	 * @return	string				Parameter value, if any.
	 */
	public function get($parameter, $section = "") { return null; }
}
?>