<?php
/**
 * Wigbi.Plugins.Data.GuestbookEntry class file.
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
 * The Wigbi.Plugins.Data.GuestbookEntry class.
 * 
 * This class represents a guestbook entry. It can be applied to any
 * kind of objects, but will most probably be used by the User class.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
 */
class GuestbookEntry extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_senderId = "__GUID";
	public $_receiverId = "__GUID";
	public $_text = "__TEXT";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function receiverId($value = null) { return $this->getSet("_receiverId", $value); }
	public function senderId($value = null) { return $this->getSet("_senderId", $value); }
	public function text($value = null) { return $this->getSet("_text", $value); }
	
	
	public function validate()
	{
		$errorList = array();
		
		if (!trim($this->text()))
			array_push($errorList, "text_required");
			
		return $errorList;
	}
}

?>