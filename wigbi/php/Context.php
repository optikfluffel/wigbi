<?php

/**
 * Wigbi.PHP.QueryDataHandler class file.
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
 * The Wigbi.PHP.Context class.
 * 
 * This class can be used to handle the various context arrays; for
 * instance _GET and _POST.
 * 
 * The class simplifies working with, for instance, query variables
 * and posted data, since non-existing array keys are automatically
 * handled by the class.
 * 
 * For now, only _GET and _POST are handled.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 * 
 * @static
 */
class Context
{
	/**
	 * Get the value of a certain element in the $_GET array.
	 * 
	 * @access	public
	 * 
	 * @param		string	$key	The name of the element to retrieve.
	 * @return	string				The element value; null if the key does not exist.
	 */
	public function get($key)
	{
		return array_key_exists($key, $_GET) ? $_GET[$key] : null;
	}
	
	/**
	 * Get the value of a certain element in the $_POST array.
	 * 
	 * @access	public
	 * 
	 * @param		string	$key	The name of the element to retrieve.
	 * @return	string				The element value; null if the key does not exist.
	 */
	public function post($key)
	{
		return array_key_exists($key, $_POST) ? $_POST[$key] : null;
	}
}

?>