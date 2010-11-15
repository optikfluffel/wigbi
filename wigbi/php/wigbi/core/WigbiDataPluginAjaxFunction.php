<?php

/**
 * Wigbi.PHP.Core.WigbiDataPluginAjaxFunction class file.
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
 * The Wigbi.PHP.Core.WigbiDataPluginAjaxFunction class.
 * 
 * This class can be used to define AJAX functions that are added to
 * the JavaScript classes that are automatically generated for every
 * data plugin that is added to a Wigbi application.
 * 
 * This class is only meant to be used by the WigbiDataPlugin class.
 * It has no relevance outside that context.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP.Core
 * @version			1.0.0
 */
class WigbiDataPluginAjaxFunction
{
	/**#@+
	 * @ignore
	 */
	private $_isStatic;
	private $_name;
	private $_parameters;
	/**#@-*/
		
	
	/**
	* Create an instance of the class.
	* 
	* @access	public
	*
	* @param	string	$name					The name of the function.
	* @param	array		$parameters		A sorted array of function parameter names; default empty.
	* @param	bool		$isStatic			Whether or not the function is static; default false.
	*/
	public function __construct($name, $parameters = array(), $isStatic = false)
	{
		$this->_name = $name;
		$this->_parameters = $parameters;
		$this->_isStatic = $isStatic;
	}


	
	/**
	 * Get whether or not the server-side function is static.
	 * 
	 * @access	public
	 * 
	 * @return	bool	Whether or not the server-side function is static.
	 */
	public function isStatic()
	{
		return $this->_isStatic;
	}

	/**
	 * Get the name of the server-side function the AJAX function should call.
	 * 
	 * @access	public
	 * 
	 * @return	string	The name of the sever-side function the AJAX function should call.
	*/
	public function name()
	{
		return $this->_name;
	}
	
	/**
	 * Get a sorted list of parameter names that the server-side function accepts.
	 * 
	 * @access	public
	 * 
	 * @return	array	A sorted list of parameter names that the server-side function accepts.
	 */
	public function parameters()
	{
		return $this->_parameters;
	}
}

?>