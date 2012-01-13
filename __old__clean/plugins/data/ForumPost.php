<?php
/**
 * Wigbi.Plugins.Data.ForumPost class file.
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
 * The Wigbi.Plugins.Data.ForumPost class.
 * 
 * This class represents a general forum post that can be added to a
 * certain forum thread.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.3
 */
class ForumPost extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_createdById = "__GUID";
	public $_forumThreadId = "__GUID";
	public $_content = "__TEXT";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function content($value = null) { return $this->getSet("_content", $value); }
	public function createdById($value = null) { return $this->getSet("_createdById", $value); }
	public function forumThreadId($value = null) { return $this->getSet("_forumThreadId", $value); }
	
	
	public function validate()
	{
		$errorList = array();
		
		if (!trim($this->content()))
			array_push($errorList, "content_required");

		return $errorList;
	}
}
?>