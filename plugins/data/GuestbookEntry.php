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
 * This class represents a guestbook entry that can be applied to an
 * object of any kind, although it most probably will be used to let
 * two persons to communicate. 
 * 
 * The easiest way to connect a guestbok entry to another Wigbi data
 * plugin class is to add a synced data list to the target class and
 * add the entry to the list. This will make sure that the guestbook
 * entry is deleted together with the object. 
 * 
 * The senderId and receiverId properties can also be used as object
 * references to provide fully traceable guestbook entries.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class GuestbookEntry extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_senderId = "__GUID";
	public $_receiverId = "__GUID";
	public $_createdDateTime = "__DATETIME";
	public $_text = "__TEXT";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function createdDateTime()
	{
		return $this->_createdDateTime;
	}

	public function receiverId($value = "")
	{
		if (func_num_args() != 0)
			$this->_receiverId = func_get_arg(0);
		return $this->_receiverId;
	}

	public function senderId($value = "")
	{
		if (func_num_args() != 0)
			$this->_senderId = func_get_arg(0);
		return $this->_senderId;
	}

	public function text($value = "")
	{
		if (func_num_args() != 0)
			$this->_text = func_get_arg(0);
		return $this->_text;
	}
	
	
	public function validate()
	{
		//Init error list
		$errorList = array();
		
		//Require that a text is defined
		if (!trim($this->text()))
			array_push($errorList, "text_required");
			
		//Return error list
		return $errorList;
	}
}

?>