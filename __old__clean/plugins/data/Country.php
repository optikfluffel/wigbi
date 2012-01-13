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
 * This class represents a generak country, with just a name as well
 * as language code and name definitions.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
 */
class Country extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_name = "__50";
	public $_languageCode = "__10";
	public $_languageName = "__25";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	

	public function languageCode($value = null) { return $this->getSet("_languageCode", $value); }
	public function languageName($value = null) { return $this->getSet("_languageName", $value); }
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