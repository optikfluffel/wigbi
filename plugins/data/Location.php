<?php
/**
 * Wigbi.Plugins.Data.Location class file.
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
 * The Wigbi.Plugins.Data.Location class.
 * 
 * This class represents general location with a name, a description
 * as well as a latitute and longitude.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
 */
class Location extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_name = "__50";
	public $_description = "__TEXT";
	public $_latitude = 0.0;
	public $_longitude = 0.0;
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function description($value = null) { return $this->getSet("_description", $value); }
	public function latitude($value = null) { return $this->getSet("_latitude", $value); }
	public function longitude($value = null) { return $this->getSet("_longitude", $value); }
	public function name($value = null) { return $this->getSet("_name", $value); }
	
	
	public function validate()
	{
		$errorList = array();

		return $errorList;
	}
}
?>