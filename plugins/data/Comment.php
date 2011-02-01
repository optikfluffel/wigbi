<?php
/**
 * Wigbi.Plugins.Data.Comment class file.
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
 * The Wigbi.Plugins.Data.Comment class.
 * 
 * This class represents a general comment that can be applied to an
 * object of any kind, even "non-existing", non-stored objects.
 * 
 * The comment author can be defined in various ways. If it is bound
 * to an object with an ID, then simply use the authorId prop. If no
 * ID exists, though, the author can be identified with name, e-mail
 * and URL.
 * 
 * The object to which the comment applies can also be identified in
 * two ways. If it is bound to an object with an ID, then simply use
 * the receiverId prop. If no ID exists, though, the receiver can be
 * identified with the receiverName property, which must be unique.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
 */
class Comment extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_authorId = "__GUID";
	public $_authorName = "__50";
	public $_authorEmail = "__50";
	public $_authorUrl = "__50";
	public $_receiverId = "__GUID";
	public $_receiverName = "__50";
	public $_text = "__TEXT";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function authorEmail($value = null) { return $this->getSet("_authorEmail", $value); }
	public function authorId($value = null) { return $this->getSet("_authorId", $value); }
	public function authorName($value = null) { return $this->getSet("_authorName", $value); }
	public function authorUrl($value = null) { return $this->getSet("_authorUrl", $value); }
	public function receiverId($value = null) { return $this->getSet("_receiverId", $value); }
	public function receiverName($value = null) { return $this->getSet("_receiverName", $value); }
	public function text($value = null) { return $this->getSet("_text", $value); }
	
	
	public function validate()
	{
		$errorList = array();
		
		if ($this->authorEmail() && !ValidationHandler::isEmail($this->authorEmail()))
			array_push($errorList, "email_invalid");
		if (!trim($this->text()))
			array_push($errorList, "text_required");

		return $errorList;
	}
}
?>