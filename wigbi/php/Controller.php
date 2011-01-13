<?php

/**
 * Wigbi.PHP.Controller class file.
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
 * The Wigbi.PHP.Controller class.
 * 
 * This class represents a general controller that can be used in an
 * MVC-based application. The class is static, since only one single
 * controller can exist during a request.
 * 
 * This class is really basic as of now, since it is being tried out
 * in various applications. It is initialized with query variables:
 * 
 * <ul>
 * 	<li>Controller::name() - by default $_GET["controller"]</li>
 * 	<li>Controller::action() - by default $_GET["action"]</li>
 * </ul>
 * 
 * If this pattern is not used, the controller class can be manually
 * initialized with the init method.
 * 
 * To add a view to the page, just use the View::add(...) method. To
 * pass data to the view, use the second optional parameter. See the
 * View class documentation for further information. 
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			0.5
 * 
 * static
 */
class Controller
{	
	/**#@+
	 * @ignore
	 */
	private static $_action = "";
	private static $_name = "";
	/**#@-*/
	
	
	
	/**
	 * Get/set the name of the current action.
	 * 
	 * If no value exists, the property returns "index".
	 * 
	 * @access	public
	 * 
	 * @param		string	$value	Optional set value.
	 * @return	string		 			The name of the current action.
	 */
	public function action($value = "")
	{
		if(func_num_args() != 0)
			Controller::$_action = func_get_arg(0);
		if (Controller::$_action)
			return Controller::$_action;
		if (!array_key_exists("action", $_GET))
			return "index";
		return $_GET["action"];
	}
	
	/**
	 * Get/set the name of the current controller.
	 * 
	 * @access	public
	 * 
	 * @param		string	$value	Optional set value.
	 * @return	string		 			The name of the controller.
	 */
	public function name($value = "")
	{
		if(func_num_args() != 0)
			Controller::$_name = func_get_arg(0);
		if (Controller::$_name)
			return Controller::$_name;
		if (!array_key_exists("controller", $_GET))
			return "";
		return $_GET["controller"];
	}
}

?>