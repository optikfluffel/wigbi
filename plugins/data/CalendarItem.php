<?php
/**
 * Wigbi.Plugins.Data.MenuItem class file.
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
 * The Wigbi.Plugins.Data.MenuItem class.
 * 
 * This class represents a calendar event that has a start/end time.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.2
 */
class CalendarItem extends WigbiDataPlugin
{
	public $_title = "__50";
	public $_startDateTime = "__DATETIME";
	public $_endDateTime = "__DATETIME";
	public $_fullDay = true;
	public $_description = "__TEXT";
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function description($value = null) { return $this->getSet("_description", $value); }
	public function endDateTime($value = null) { return $this->getSet("_endDateTime", $value); }
	public function fullDay($value = null) { return $this->getSet("_fullDay", $value); }
	public function startDateTime($value = null) { return $this->getSet("_startDateTime", $value); }
	public function title($value = null) { return $this->getSet("_title", $value); }
	
	
	public function validate()
	{
		$errorList = array();
		
		if (!trim($this->title()))
			array_push($errorList, "title_required");
		if (!trim($this->startDateTime()))
			array_push($errorList, "startDateTime_required");
			
		return $errorList;
	}
}
?>