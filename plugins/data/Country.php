<?php
/**
 * Wigbi.Plugins.Data.Country class file.
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
 * The Wigbi.Plugins.Data.Country class.
 * 
 * This class represents a country, with a name, a language code and
 * a lat/long position. The class also has a city data list to which
 * City instances can be added.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class Country extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_name = "__50";
	public $_latitude = 0.0;
	public $_longitude = 0.0;
	public $_languageCode = "__10";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	

	public function languageCode($value = "")
	{
		if (func_num_args() != 0)
			$this->_languageCode = func_get_arg(0);
		return $this->_languageCode;
	}
	
	public function latitude($value = 0.0)
	{
		if (func_num_args() != 0)
			$this->_latitude = func_get_arg(0);
		return $this->_latitude;
	}

	public function longitude($value = 0.0)
	{
		if (func_num_args() != 0)
			$this->_longitude = func_get_arg(0);
		return $this->_longitude;
	}

	public function name($value = "")
	{
		if (func_num_args() != 0)
			$this->_name = func_get_arg(0);
		return $this->_name;
	}
	
	
	public function validate()
	{
		//Init error list
		$errorList = array();
			
		//Require that a name is defined
		if (!trim($this->name()))
			array_push($errorList, "name_required");

		//Return error list
		return $errorList;
	}
}
?>