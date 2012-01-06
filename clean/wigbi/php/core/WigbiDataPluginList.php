<?php

/**
 * Wigbi.PHP.Core.WigbiDataPluginList class file.
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
 * The Wigbi.PHP.Core.WigbiDataPluginList class.
 * 
 * This class can be used to make a WigbiDataPlugin object contain a
 * list of other WigbiDataPlugin objects. For instance, User objects
 * could store other User objects in a list called "friends".
 * 
 * This class is not intended to be manually used. Instead, it is to
 * be used through the WigbiDataPlugin class' various list functions.
 * 
 * 
 * SYNCED VS. NON-SYNCED LISTS ***********************
 * 
 * A data plugin list can either be synced or non-synced. For synced
 * lists, objects are automatically deleted if they are removed from
 * the list or if the parent object is deleted. Non-synced lists, on
 * the other hand, will never delete any object within it.
 * 
 * For instance, consider a User friend list. Just because a user is
 * removed from the list does not mean that he/she should be deleted.
 * In this case, use a non-synced list. On the other hand, if a user
 * has a blog, the blog and all its posts should probably be deleted
 * together with the user. In this case, use a synced list. 
 * 
 * 
 * DEFAULT SORT RULE *********************************
 * 
 * A data plugin list can be set to have a default sort rule that is
 * applied when objects are retrieved with the getListItems() method.
 * For instance, the friend list above should maybe use "name()", so
 * that all users are listed alphabetically.
 * 
 * Using a default sort rule is optional. If none is set, list items
 * will be returned in the order they were added to the list.    
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP.Core
 * @version			1.0.0
 */
class WigbiDataPluginList
{	
	/**#@+
	 * @ignore
	 */
	private $_isSynced;
	private $_itemClass;
	private $_name;
	private $_ownerClass;
	private $_ownerId;
	private $_sortRule;
	/**#@-*/

	
	/**
	 * Create an instance of the class.
	 * 
	 * This constructor is not intended to be manually used. Instead,
	 * it is used by the WigbiDataPlugin registerList function.
	 * 
	 * @access	public
	 * 
	 * @param	string	$name					The name of the list.
	 * @param	string	$ownerClass		The name of the class to which the list belongs.
	 * @param	string	$itemClass		The name of the class that is stored in the list.
	 * @param	bool		$isSynced			Whether or not the list is synced; default false.
	 * @param	string	$sortRule			The default sort rule; default null.
	 */
	public function __construct($name, $ownerClass, $itemClass, $isSynced = false, $sortRule = null)
	{
		$this->_name = $name;
		$this->_ownerClass = $ownerClass;
		$this->_itemClass = $itemClass;
		$this->_isSynced = $isSynced;
		$this->_sortRule = $sortRule;
	}
	
	
	
	/**
	 * Get whether or not the list is synced.
	 * 
	 * @access	public
	 * 
	 * @return	bool	Whether or not the list is synced.
	 */
	public function isSynced()
	{
		return $this->_isSynced;
	}
	
	/**
	 * Get the name of the class that is stored in the list.
	 * 
	 * @access	public
	 * 
	 * @return	string	The name of the class that is stored in the list.
	 */
	public function itemClass()
	{
		return $this->_itemClass;
	}
	
	/**
	 * Get the name of the list.
	 * 
	 * @access	public
	 * 
	 * @return	string	The name of the list.
	 */
	public function name()
	{
		return $this->_name;
	}
	
	/**
	 * Get the name of the class to which the list belongs.
	 * 
	 * @access	public
	 * 
	 * @return	string	The name of the class to which the list belongs.
	 */
	public function ownerClass()
	{
		return $this->_ownerClass;
	}
	
	/**
	 * Get the ID of the object to which the list belongs.
	 * 
	 * @access	public
	 * 
	 * @return	string	The ID of the object to which the list belongs.
	 */
	public function ownerId($value = "")
	{
		if(func_num_args() != 0)
			$this->_ownerId = func_get_arg(0);
		return $this->_ownerId;
	}
	
	/**
	 * Get the default sort rule, if any.
	 * 
	 * @access	public
	 * 
	 * @return	string	The default sort rule.
	 */
	public function sortRule()
	{
		return $this->_sortRule;
	}
	
	/**
	 * Get the name of the database table that handles the list.
	 * 
	 * @access	public
	 * 
	 * @return	string	The name of the database table that handles the list.
	 */
	public function tableName()
	{
		return $this->ownerClass() . "_" . $this->name();
	}
}

?>