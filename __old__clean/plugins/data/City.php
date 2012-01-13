<?php
/**
 * Wigbi.Plugins.Data.City class file.
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
 * The Wigbi.Plugins.Data.City class.
 * 
 * This class represents a city, with a name and a lat/long position.
 * A city can also be set to belong to a country.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
 */

class City extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_name = "__50";
	public $_latitude = 0.0;
	public $_longitude = 0.0;
	public $_countryId = "__GUID";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function countryId($value = null) { return $this->getSet("_countryId", $value); }
	public function latitude($value = null) { return $this->getSet("_latitude", $value); }
	public function longitude($value = null) { return $this->getSet("_longitude", $value); }
	public function name($value = null) { return $this->getSet("_name", $value); }
	
	
	public function validate()
	{
		$errorList = array();
			
		if (!trim($this->name()))
			array_push($errorList, "name_required");

		return $errorList;
	}
}
?>