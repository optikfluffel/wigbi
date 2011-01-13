<?php
/**
 * Wigbi.PHP.Core.WigbiDataPlugin class file.
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
 * The Wigbi.PHP.Core.WigbiDataPlugin base class.
 * 
 * All data plugins must inherit this class, and call its constructor
 * from within their own. See any standard data plugin for examples.
 * 
 * Wigbi data plugins can be persisted to the database. To add a data
 * plugin to a Wigbi application, simply add the plugin class file to
 * the wigbi/plugins/data folder.
 * 
 * If the Runtime Build feature is enabled in the Wigbi configuration
 * file, Wigbi will generate a JavaScript class file for every plugin
 * that is added to the Wigbi application. 
 * 
 * 
 * DATABASE PERSISTENCY ******************************
 * 
 * When Wigbi is started, it will automatically setup a database and
 * make sure that it has all the tables it needs, provided that data
 * persistency and RTB is enabled in the Wigbi configuration file.
 * 
 * Wigbi will automatically create a database table for every plugin.
 * It uses the collectionName() property as table name and creates a
 * column for each public variable.
 * 
 * To avoid name conflicts, use this variable/property name pattern:
 * <ul>
 * 	<li>Variable - _x</li>
 * 	<li>Get property - function x()</li>
 * 	<li>Set property - function x(...)</li>
 * </ul>
 * 
 * Wigbi will set all database table columns, except ID, to NULL. If
 * this is not wanted, change the columns manually afterwards. Wigbi
 * will only ADD tables and columns, never delete them.
 * 
 * Wigbi will automatically set the value of the following variables,
 * if they exist when a data plugin is saved:
 * <ul>
 * 	<li>_createdDateTime - __DATETIME</li>
 * 	<li>_lastUpdatedDateTime - __DATETIME</li>
 * </ul>
 *  
 * 
 * VARIABLE TYPES AND DEFAULT VALUE ******************
 * 
 * The Wigbi persistency engine supports booleans, doubles, integers
 * and strings. To handle database types that are unavailable in PHP,
 * use string variables, which default values are divided into value
 * and type, as such: "[default value]__[type]".
 * 
 * All standard database types are supported, using the format above.
 * The following "extra" types are also supported:
 * <ul>
 *	<li><b><none></b></li>	= VARCHAR(255); e.g. "No specified type"</li>
 * 	<li><b><int></b>				= VARCHAR(<int>); e.g. "Twenty length string__20"</li>
 * 	<li><b>FILE</b>					= VARCHAR(255); e.g. "/img/profile.png__FILE"</li> 
 * 	<li><b>GUID</b>					= VARCHAR(40); e.g. "c70e694643a8d159c498054589d9356e__GUID"</li>
 * </ul>
 * 
 * The FILE type can be used to bind a certain file to an object. It
 * make sure that the file is deleted together with the object.
 * 
 * 
 * DATA LISTS **********************************
 * 
 * Data lists make it easy to create relationships between available
 * data plugins. For simplicity, this class uses the name "list" and
 * not "dataList" when naming properties and methods, e.g. "getList".  
 * 
 * Data lists contain <i>items</i>, which are ID pointers to objects.
 * A data plugin object must thus be saved to the database before it
 * can be used in list operations.
 * 
 * To register a data list, just call the registerList method in the
 * constructor. Wigbi will then create a database table for the list.
 * 
 * A data list can either be synced or non-synced. With synced lists,
 * objects are automatically deleted if they are removed from a list
 * or if the owner object is deleted. Non-synced lists, on the other
 * hand, will never delete any objects except the list item.
 * 
 * For instance, consider a User friend list. Just because a user is
 * removed from such a list, he/she should (probably) not be deleted.
 * Use a non-synced list in this case. Blog posts and images, on the
 * other hand, should probably be deleted with the user. If so, make
 * sure to use synced lists.
 * 
 * Finally, data lists can specify a sort rule that is automatically
 * used by the getListItems function. All valid SQL ORDER BY clauses
 * apply for this sort rule.
 * 
 * 
 * REGISTER AJAX FUNCTIONALITY *****************
 * 
 * A data plugin can tell Wigbi to include any of its methods in the
 * auto-generated JavaScript class so that they can be executed with
 * AJAX. TO do so, simply use the registerAjaxFunction method in the
 * class constructor for each method that you wish to register.
 * 
 * 
 * VALIDATION **********************************
 * 
 * This base class has a validate method, which can be overridden to
 * define how a data plugin is validated.
 * 
 * The validate method is available in the auto-generated JavaScript
 * class as well, which uses AJAX to call the PHP method. Validation
 * can therefore be specified at one single place, at the price of a
 * server roundtrip for each JavaScript validation operation. 
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP.Core
 * @version			1.0.0
 * 
 * @abstract
 */
abstract class WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	private static $_autoReset = true;
	
	private $_ajaxFunctions = array();
	private $_lists = array();
	private $_collectionName;
	
	public $_id = "__GUID";
	/**#@-*/


	
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 */
	public function __construct()
	{
		if (WigbiDataPlugin::autoReset())
		{
			WigbiDataPlugin::autoReset(false);
			$this->reset();
			WigbiDataPlugin::autoReset(true);
		}
	}
	
	
	
	/**
	 * Get all AJAX functions that have been registered for the class.
	 * 
	 * @access	public
	 * 
	 * @return	array	All AJAX functions that have been registered for the class.
	 */
	public function ajaxFunctions()
	{
		return $this->_ajaxFunctions;
	}
	
	/**
	 * Get/set whether or not objects should auto-reset when being created.
	 * 
	 * This property should always be true, except in the rare cases
	 * where one must know a variable's type and database type. Just
	 * ignore it.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	bool	Whether or not objects should auto-reset when being created.
	 */
	public static function autoReset($value = false)
	{
		if(func_num_args() != 0)
			WigbiDataPlugin::$_autoReset = func_get_arg(0);
		return WigbiDataPlugin::$_autoReset;
	}
	
	/**
	 * Get the plugin class name.
	 * 
	 * @access	public
	 * 
	 * @return	string	The plugin class name.
	 */
	public function className()
	{
		return get_class($this);
	}
	
	/**
	 * Get the plugin collection name.
	 * 
	 * This property returns the regular pluralis form of the class
	 * name. If the value is incorrect (for example, "wolf" becomes
	 * "wolfs" and not "wolves"), the value can be overridden.
	 * 
	 * @access	public
	 *
	 * @param		string	$value	Optional set value.
	 * @return	string					The plugin collection name.
	 */
	public function collectionName($value = "")
	{
		//Set the property if a value is provided
		if(func_num_args() != 0)
			$this->_collectionName = func_get_arg(0);
			
		//Return the collection name, if any
		if ($this->_collectionName)
			return $this->_collectionName;

		//Get the last and two last chars in the string			
		$last = (strlen($this->className()) > 0) ? substr($this->className(), strlen($this->className()) - 1) : "";
		$twoLast = (strlen($this->className()) > 1) ? substr($this->className(), strlen($this->className()) - 2) : "";
			
		//Cover for the three regular cases
		if ($last == "y")
			return substr($this->className(), 0, strlen($this->className()) - 1) . "ies";
		if ($last == "s" || $last == "x" || $twoLast == "ch" || $twoLast == "sh")
			return $this->className() . "es";
		if ($twoLast == "ss")	//Added 2010-05-16
			return $this->className() . "es";
		return $this->className() . "s";
	}
	
	/**
	 * Get all database variables for the object.
	 * 
	 * This function returns all class variables that will be saved
	 * to and loaded from the database.
	 * 
	 * @return	array	All database variables for the object.
	 */
	public function databaseVariables()
	{
		return WigbiDataPluginUtil::getPublicVariables($this);
	}
	
	/**
	 * Get all database variables for the base class.
	 * 
	 * This function returns all class variables that will be saved
	 * to and loaded from the database and are base class variables.
	 */
	public function databaseVariables_base()
	{
		$object = new WigbiDataPluginBaseClassUtil();
		return $object->databaseVariables();
	}
	
	/**
	 * Get all database variables for the base class.
	 * 
	 * This function returns all class variables that will be saved
	 * to and loaded from the database and are defined in the class.
	 */
	public function databaseVariables_self()
	{
		$result = array();
		
		foreach ($this->databaseVariables() as $variableName)
			if (!in_array($variableName, $this->databaseVariables_base()))
				array_push($result, $variableName);
		
		return $result;
	}
	
	/**
	 * Get the object ID.
	 * 
	 * This property is set when the object is saved.
	 * 
	 * @access	public
	 * 
	 * @return	string	The object ID.
	 */
	public function id()
	{
		return $this->_id;
	}
	
	/**
	 * Get all data lists that have been registered for the class.
	 * 
	 * @access	public
	 * 
	 * @return	array	All data lists that have been registered for the class.
	 */
	public function lists()
	{
		return $this->_lists;
	}
	
	/**
	 * Get all public variables for the object. 
	 * 
	 * @return	array	All public variables for the object.
	 */
	public function publicVariables()
	{
		return WigbiDataPluginUtil::getPublicVariables($this);
	}
	
	
	
	/**
	 * Add an object to a data list.
	 * 
	 * @access	public
	 * 
	 * @param		string	$listName	The name of the list to add the object to.
	 * @param		string	$objectId	The ID of the object to add to the list.
	 * @return	bool							Whether or not the operation succeeded.
	 */
	public function addListItem($listName, $objectId)
	{
		//Reset object
		$this->reset();

		//Abort if the parent or child have not been saved
		if (!$this->id() || !$objectId)
			return false;
			
		//Get the list, abort if none
		$list = $this->getList($listName);
		if (!$list)
			return false;
			
		//Abort if an object with the given ID does not exists
		eval('$tmpObj = new ' . $list->itemClass() . '();');
		$tmpObj->load($objectId);
		if ($tmpObj->id() != $objectId)
			return false;
			
		//Insert an object reference into the list, at the max position
		Wigbi::dbHandler()->query("SELECT MAX(position) AS position FROM " . $list->tableName() . " WHERE ownerId = '" . $list->ownerId() . "'");
		$row = Wigbi::dbHandler()->getNextRow();
		$position = $row["position"];
		Wigbi::dbHandler()->query("INSERT INTO " . $list->tableName() . " (ownerId, itemId, position) VALUES ('" . $list->ownerId() . "','" . $objectId . "'," . ($position + 1) . ")");
		
		//Return success
		return true;
	}
	
	/**
	 * Delete the object from the database.
	 * 
	 * @access	public
	 * 
	 * @return	bool		Whether or not the operation succeeded.
	 */
	public function delete()
	{
		//Reset the objet
		$this->reset();
		
		//Abort if no id is given
		if (!$this->id())
			return false;

		//Delete each all data list items
		foreach ($this->lists() as $list)
		{
			//Handle synced and non-synced lists differently
			if (!$list->isSynced())
			{
				Wigbi::dbHandler()->query("DELETE FROM " . $list->tableName() . " WHERE ownerId = '" . $this->id() . "'");
			}
			else
			{
				//Init ID array
				$idArray = array();
				
				//Select all IDs to the array to avoid nested db calls
				Wigbi::dbHandler()->query("SELECT itemId FROM " . $list->tableName() . " WHERE ownerId = '" . $this->id() . "'");
				$row = Wigbi::dbHandler()->getNextRow();
				while ($row)
				{
					array_push($idArray, $row["itemId"]);
					$row = Wigbi::dbHandler()->getNextRow();
				}
				
				//Delete each item
				foreach ($idArray as $id)
					$this->deleteListItem($list->name(), $id);
			}
		}

		//Delete any possible related files
		WigbiDataPlugin::autoReset(false);
		eval('$tmpObj = new ' . $this->className() . '();');
		foreach ($tmpObj as $property=>$value)
			if (strtolower(WigbiDataPlugin::getVariableType($value)) == 'file')
				if (file_exists(Wigbi::serverRoot() . $this->$property))
					unlink(Wigbi::serverRoot() . $this->$property);
		WigbiDataPlugin::autoReset(true);
		
		//Catch id, then reset base variables
		$id = $this->_id;
		$this->_id = "";
					
		//Finally, delete the object from the database
		return Wigbi::dbHandler()->query("DELETE FROM " . $this->collectionName() . " WHERE id = '" . $id . "'");
	}
	
	/**
	 * Delete an object from a data list.
	 * 
	 * @access	public
	 * 
	 * @param		string	$listName	The name of the list to delete from.
	 * @param		string	$objectId	The ID of the object to remove from the list.
	 * @return	bool							Whether or not the operation succeeded.
	 */
	public function deleteListItem($listName, $objectId)
	{
		//Reset object
		$this->reset();
		
		//Abort if the parent has not been saved
		if (!$this->id())
			return false;
			
		//Get the list, abort if none
		$list = $this->getList($listName);
		if (!$list)
			return false;
			
		//Abort if an object with the given ID does not exists
		eval('$object = new ' . $list->itemClass() . '();');
		$object->load($objectId);
		if ($object->id() != $objectId)
			return false;
			
		//If the list is synced, delete the object
		if ((bool)$list->isSynced())
			$object->delete();
		
		//Delete the list table row
		return Wigbi::dbHandler()->query("DELETE FROM " . $list->tableName() . " WHERE ownerId = '" . $list->ownerId() . "' AND itemId = '" . $objectId . "'");
	}
	
	/**
	 * Get a certain data list.
	 * 
	 * @access	public
	 * 
	 * @param	string				$name	The name of the data list.
	 * @return	WigbiDataPluginList			The data list, if any.
	 */
	public function getList($name)
	{
		if (!array_key_exists($name, $this->_lists))
			return null;
		return $this->_lists[$name];
	}
	
	/**
	 * Get objects from a data list.
	 *
	 * This method is a convenient way of retrieving objects without
	 * having to use a complex search operation.
	 * 
	 * The result is a 3 element array, where the first element is a
	 * list with resulting objects, the second an int with the total
	 * number of items and the third the class name of the objects.
	 * 
	 * @access	public
	 * 
	 * @param		string	$listName		The name of the list.
	 * @param		int			$skipCount	The number of rows to skip before starting to retrieve objects; default 0.
 	* @param		int			$maxCount		The max number of objects to return; default 100.
	 * @return	array								False if error, else result array.
	 */
 	public function getListItems($listName, $skipCount = 0, $maxCount = 100)
	{
		//Get the list, abort if none
		$list = $this->getList($listName);
		if (!$list)
			return false;
		
		//Setup a search filter
		$tmpFilter = new SearchFilter();
		$tmpFilter->setPaging($skipCount, $maxCount);
		
		//Apply either default or position sort
		if ($list->sortRule())
			$tmpFilter->addSortRule($list->sortRule());
		else
			$tmpFilter->addSortRule(" sub.position ASC ");
		
		//Return the search result
		return $this->searchListItems($listName, $tmpFilter);
	}

	/**
	 * Get the type of a certain data plugin variable.
	 * 
	 * This method will return gettype for all types except strings.  
	 * For strings, the method will return the type that is defined
	 * after __ in the string.
	 * 
	 * @param		mixed	$variable	The variable to return type for.
	 * @return									The variable type.
	 * 
	 * @static
	 */
	public static function getVariableDatabaseType($variable)
	{
		//Get the variable type
		$type = WigbiDataPlugin::getVariableType($variable);
		
		//Booleans => BINARY
		if (gettype($variable) == "boolean")
			return "BINARY";
			
		//Strings are special
		if (gettype($variable) == "string")
		{
			//Define charset
			$charSet = " CHARACTER SET utf8 COLLATE utf8_unicode_ci ";
			
			//Handle all possible scenarios
			switch (strtolower($type))
			{
				case (int)$type > 0:
					return "VARCHAR($type) $charSet";
					
				case "guid":
				case in_array($type, Wigbi::dataPluginClasses()):
					return "VARCHAR(40)";
					
				case "file":
					return "VARCHAR(255) $charSet";
				
				case strpos(" " . $type, "VARCHAR") > 0:
				case in_array(strtolower($type), array("longtext", "mediumtext", "text", "tinytext")):
					return $type . " " . $charSet;
					
				default:
					return $type;
			}
		}
		
		//All other types are handled "as is"
		return $type;
	}
	
	/**
	 * Get the database type of a certain data plugin variable.
	 * 
	 * @param		mixed	$variable	The variable to return type for.
	 * @return									The variable type.
	 * 
	 * @static
	 */
	public static function getVariableType($variable)
	{
		if (gettype($variable) != "string")
			return gettype($variable);
		if (!strrpos(" " . $variable, "__"))
			return "255";
		return strrev(substr(strrev($variable), 0, strrpos(strrev($variable), "__")));
	}
	
	/**
	 * Get the value of a certain data plugin variable.
	 * 
	 * This method will return the plain value for all types except
	 * strings. For strings, the method will return the string that
	 * is defined before __ in the string.
	 * 
	 * @param		mixed	$variable	The variable to return value for.
	 * @return									The variable value.
	 * 
	 * @static
	 */
	public static function getVariableValue($variable)
	{
		if (gettype($variable) != "string")
			return $variable;
		if (strrpos(" " . $variable, "__"))
			return substr($variable, 0, strrpos($variable, "__"));
		return $variable;
	}
	
	/**
	 * Load an object from the database, using its ID.
	 * 
	 * @access	public
	 * 
	 * @param		string	$loadId	The ID of the object to load.
	 * @return	Seed						The loaded object, if any.
	 */
	public function load($id)
	{
		return $this->loadBy("id", $id);
	}
	
	/**
	 * Load an object from the database, using any property.
	 * 
	 * @access	public
	 * 
	 * @param		string	$propertyName		The name of the property.
	 * @param		string	$propertyValue	The property value.
	 * @return	mixed										The loaded object, if any.
	 */
	public function loadBy($propertyName, $propertyValue)
	{
		//Reset object
		$this->reset();
		
		//Retrieve data from database and parse row, if any
		Wigbi::dbHandler()->query("SELECT * FROM " . $this->collectionName() . " WHERE " . $propertyName . " = '" . str_replace("'", "''", $propertyValue) . "'");
		$row = Wigbi::dbHandler()->getNextRow();
		if ($row)
			$this->parseArray($row);
			
		//Bind all lists to the object
		foreach ($this->lists() as $list)
			$list->ownerId($this->id());

		//Return the object id
		return $this;
	}

	/**
	 * Load multiple objects from the database, using their ID.
	 * 
	 * This method returns the objects in the order specified by the
	 * provided ID array, provided that each ID exists.  
	 * 
	 * @access	public
	 * 
	 * @param		array	$loadIds	The IDs of the objects to load.
	 * @return	array						The loaded objects, if any.
	 */
	public function loadMultiple($ids)
	{
		//Init result
		$result = array();
		
		//Abort if no IDs
		if (!$ids || sizeof($ids) == 0)
			return $result;
		
		//Build query
		$query = "SELECT * FROM " . $this->collectionName() . " WHERE id = '" . $ids[0] . "'";
		foreach ($ids as $loadId)
			$query .= "OR id = '" . $loadId . "'";

		//Retrieve data from database
		Wigbi::dbHandler()->query($query);
		$row = Wigbi::dbHandler()->getNextRow();
		
		//Try to parse each object
		while ($row)
		{
			//Create and add object to array
			eval('$tmpObj = new ' . $this->className() . '();');
			$tmpObj->reset();
			$tmpObj->parseArray($row);
			array_push($result, $tmpObj);
			
			//Move to next row
			$row = Wigbi::dbHandler()->getNextRow();
		}
		
		//Put the unsorted result in an associative array
		$associative = array();
		foreach ($result as $object)
			$associative[$object->id()] = $object;
		
		//Reset result, then sort the objects
		$result = array();
		foreach ($ids as $id)
			if (array_key_exists($id, $associative))
				array_push($result, $associative[$id]);
		
		//Return the array
		return $result;
	}

	/**
	 * Initialize the object, using another object, an ID or a property.
	 * 
	 * This method is mainly intended to be used by UI plugins, where an
	 * object is either bound to the plugin directly, or loaded by ID or
	 * a custom property.
	 * 
	 * $objectOrId can either be an object instance or an object ID. The
	 * object can also be loaded by a custom property using $loadByValue
	 * and $loadByPropertyName.
	 * 
	 * The method returns the final object since if $objectOrId could be
	 * an object, and $this cannot be re-assigned.
	 * 
	 * @access	public
	 * 
	 * @param		mixed						$objectOrId					An object or object ID, if any.
	 * @param		string					$loadByValue				The loadBy value, default blank.
	 * @param		string					$loadByPropertyName	The loadBy property name, default blank.
	 * @return	WigbiDataPlugin											The initialized object.
	 */
	public function loadOrInit($objectOrId, $loadByValue = "", $loadByPropertyName = "")
	{
		if ($objectOrId && is_string($objectOrId))
			$this->load($objectOrId);
		else if ($objectOrId && get_class($objectOrId) == get_class($this))
			return $objectOrId;
		else if ($loadByValue && $loadByPropertyName)
			$this->loadBy($loadByPropertyName, $loadByValue);
			
		return $this;
	}


	/**
	 * Move an object back or forward within a data list.
	 *
	 * The move operation will only have a noticable effect on lists
	 * without a default sort rule, since the move operation affects
	 * the position column.
	 * 
	 * @access	public
	 * 
	 * @param		string	$listName	The name of the list to move within.
	 * @param		string	$objectId	The ID of the item to move.
	 * @return	bool							Whether or not the operation succeeded.
	 * @param		int			$numSteps	The number of steps, positive or negative, the object should be moved.
	 */
	public function moveListItem($listName, $objectId, $numSteps)
	{
		//Reset object
		$this->reset();
		
		//Abort if the parent has not been saved
		if (!$this->id())
			throw new Exception("idRequired");
			
		//Get the list, abort if none
		$list = $this->getList($listName);
		if (!$list)
			throw new Exception("listDoesNotExists");
			
		//Abort if an object with the given ID does not exists
		eval('$object = new ' . $list->itemClass() . '();');
		$object->load($objectId);
		if ($object->id() != $objectId)
			throw new Exception("objectIdInvalid");

		//Try to retrieve the object from the list
		Wigbi::dbHandler()->query("SELECT position FROM " . $list->tableName() . " WHERE itemId = '" . $objectId . "'");
		$row = Wigbi::dbHandler()->getNextRow();
		if (!$row)
			throw new Exception("noDbRow");
		
		//Get the current position
		$currentPosition = (int)$row["position"];
		
		//Increase/decrease position integer correctly
		if ($numSteps > 0)
		{
			//Get the desired position
			Wigbi::dbHandler()->query("SELECT position FROM " . $list->tableName() . " WHERE position > " . $currentPosition . " ORDER BY position LIMIT " . $numSteps);
			$newPosition = 0;
			while ($row = Wigbi::dbHandler()->getNextRow())
				$newPosition = (int)$row["position"];
			
			//Update all items if position exists
			if ($newPosition)
			{
				Wigbi::dbHandler()->query("UPDATE " . $list->tableName() . " SET position = position - 1 WHERE position > " . $currentPosition . " ORDER BY position LIMIT " . $numSteps);
				Wigbi::dbHandler()->query("UPDATE " . $list->tableName() . " SET position = " . $newPosition . " WHERE itemId = '" . $objectId . "'");
			}
		} 
		else if ($numSteps < 0)
		{			
			//Get the desired position
			Wigbi::dbHandler()->query("SELECT position FROM " . $list->tableName() . " WHERE position < " . $currentPosition . " ORDER BY position DESC LIMIT " . (-1 * $numSteps));
			$newPosition = 0;
			while ($row = Wigbi::dbHandler()->getNextRow())
				$newPosition = (int)$row["position"];
				
			//Update all items if position exists
			if ($newPosition)
			{
				Wigbi::dbHandler()->query("UPDATE " . $list->tableName() . " SET position = position + 1 WHERE position < " . $currentPosition . " ORDER BY position DESC LIMIT " . (-1 * $numSteps));
				Wigbi::dbHandler()->query("UPDATE " . $list->tableName() . " SET position = " . $newPosition . " WHERE itemId = '" . $objectId . "'");	
			}		
		}
		
		//Return success
		return true;
	}

	/**
	 * Move an object first within a data list. 
	 * 
	 * @param	string	$listName	The name of the list.
	 * @param	string	$objectId	The ID of the item to move.
	 * @return	bool				Whether or not the operation succeeded.
	 */
	public function moveListItemFirst($listName, $objectId)
	{
		return $this->moveListItem($listName, $objectId, -1000000000);
	}

	/**
	 * Move an object last within a data list. 
	 * 
	 * @param	string	$listName	The name of the list.
	 * @param	string	$objectId	The ID of the item to move.
	 * @return	bool				Whether or not the operation succeeded.
	 */
	public function moveListItemLast($listName, $objectId)
	{
		return $this->moveListItem($listName, $objectId, 1000000000);
	}

	/**
	 * Parse values from an associative array.
	 * 
	 * @param	array	$objectArray	The associative array to parse.
	 */
	public function parseArray($objectArray)
	{
		$this->parseObject(json_decode(json_encode($objectArray)));
	}
	
	/**
	 * Parse values from a JSON formatted string.
	 * 
	 * @param	string	$objectString	The string to parse.
	 */
	public function parseJson($objectString)
	{
		$this->parseObject(json_decode($objectString));
	}
	
	/**
	 * Parse values from another object.
	 * 
	 * @param	mixed	$object	The object to parse.
	 */
	public function parseObject($object)
	{
		foreach ($object as $property=>$value)
		{
			//Adjust property if needed
			if (substr($property, 0, 1) != "_")
				$property = "_" . $property;
				
			//Abort if no such property exists
			if (!property_exists($this->className(), $property))
				continue;
				
			//Handle different types
			switch (gettype($this->$property))
			{
				case "boolean":
					$this->$property = ($value == 1 || $value == "1");
					break;
				case "double":
					$this->$property = (double)$value;
					break;
				case "float":
					$this->$property = (float)$value;
					break;
				case "integer":
					$this->$property = (int)$value;
					break;
				default:
					$this->$property = $value;
					break;
			}
		}
	}
	
	/**
	 * Register an AJAX function.
	 * 
	 * All registered AJAX functions are appended to the JavaScript
	 * file that is automatically generated for each data plugin.
	 * 
	 * @param	string	$name		The name of the function to register.
	 * @param	string	$parameters	The parameters that are to be used in the function.
	 * @param	boolean	$isStatic	Whether or not the function is static; default false.
	 */
	public function registerAjaxFunction($name, $parameters, $isStatic=false)
	{
		array_push($this->_ajaxFunctions, new WigbiDataPluginAjaxFunction($name, $parameters, $isStatic));
	}

	/**
	 * Register a data list.
	 *  
	 * @param	string	$name				The name of the list.
	 * @param	string	$itemClass	The name of the class that is stored in the list.
	 * @param	bool		$isSynced		Whether or not the list is synced; default false.
	 * @param	string	$sortRule		The default sort rule; default null.
	 */
	public function registerList($name, $itemClass, $isSynced=false, $sortRule=null)
	{
		$this->_lists[$name] = new WigbiDataPluginList($name, $this->className(), $itemClass, $isSynced, $sortRule);
	}
	
	/**
	 * Reset the object.
	 * 
	 * Reset the object to make sure that all variables are cleared
	 * of their type definitions (for instance, __20).
	 */
	public function reset()
	{
		//Create a reference object
		eval('$tmpObj = new ' . $this->className() . '();');

		//Set the default value of all unchanged database variables
		foreach ($this->databaseVariables() as $property)
		{
			if ($this->$property != $tmpObj->$property)
				continue;
			$this->$property = WigbiDataPlugin::getVariableValue($this->$property);
		}
	}
	
	/**
	 * Save the object to the database.
	 * 
	 * @access	public
	 * 
	 * @return	WigbiDataPlugin	The saved object.
	 */
	public function save()
	{
		//Reset object to remove any variable type data
		$this->reset();
		
		//Set id if none is set
		if (!$this->id())
			$this->_id = sha1(uniqid());
		
		//If ID is set, check if object exists
		Wigbi::dbHandler()->query("SELECT id FROM " . $this->collectionName() . " WHERE id='" . $this->id() . "'");
		$exists = (bool)Wigbi::dbHandler()->getNextRow();
				
		//Insert object if not existed, else update
		if (!$exists)
		{
			//Init query strings
			$keyString = "";
			$valueString = "";
			
			//Handle all database variables
			foreach ($this->databaseVariables() as $property)
			{
				//Strip the _ from the column name, if needed
				$columnName = $property;
				if (substr($property, 0, 1) == "_")
					$columnName = substr($property, 1, strlen($property));
					
				//Update createdDateTime and lastUpdatedDateTime property (if available)
				if ($columnName == "createdDateTime" || $columnName == "lastUpdatedDateTime")
					$this->$property = date("Y-m-d H:i:s");
				
				//Build key and value strings
				$keyString = $keyString . "," . $columnName;
				$valueString = $valueString . ",'" . str_replace("'", "''", $this->$property) . "'";
			}

			//Insert into database
			Wigbi::dbHandler()->query("INSERT INTO " . $this->collectionName() . " (" . substr($keyString,1) . ") VALUES (" . substr($valueString,1) . ")");
		}
		else
		{
			//Init query string
			$keyString = "";
			
			//Handle all database variables
			foreach ($this->databaseVariables() as $property)
			{
				//Strip the _ from the column name, if needed
				$columnName = $property;
				if (substr($property, 0, 1) == "_")
					$columnName = substr($property, 1, strlen($property));
					
				//Update createdDateTime and lastUpdatedDateTime property (if available)
				if ($columnName == "lastUpdatedDateTime")
					$this->$property = date("Y-m-d H:i:s");
					
				//Build key string
				$keyString = $keyString . "," . $columnName . "='" . str_replace("'", "''",  $this->$property) . "'";
			}
					
			//Update in database
			Wigbi::dbHandler()->query("UPDATE " . $this->collectionName() . " SET " . substr($keyString,1) . " WHERE id = '" . $this->id() . "'");
		}
		
		//Reload the object, then return it
		$this->load($this->id());
		return $this;
	}

	/**
	 * Search for objects in the database.
	 * 
	 * The method returns an array, where the first element contains
	 * the objects that matched the search operation, with regard to
	 * any applied LIMIT. The second element contains an integer for
	 * the TOTAL number of objects that matched the search operation,
	 * without regard to any applied LIMIT.
	 * 
	 * This method accepts a SearchFilter object as well as a search
	 * filter string. The first option is more convenient, while the
	 * second is more flexible, since you are then free to build the
	 * search query exactly like you want it.
	 *
	 * This method adds the search prefix 'SELECT [collectionName].*
	 * FROM [collectionName]' before the search filter string, so do
	 * not add any such information if you provide the method with a
	 * search filter string.
	 * 
	 * If you need to use join operations, which is not supported by
	 * the SearchFilter class, add them to the very beginning of the
	 * search filter string, for instance:
	 * 
	 * ', Tags WHERE Users.id = Tags.id'
	 * 
	 * For now, add the LIMIT criteria last to the search filter, if
	 * you provide the method with a search filter string. Otherwise,
	 * the totalCount will not work properly.
	 * 
	 * @access	public
	 * 
	 * @param		mixed	$searchFilter	Either a SearchFilter object, or a search query; default empty.
	 * @return	array								[0] All objects that matches the search, if any [1] Total count
	 * 
	 * @todo	Use a regexp to mask out the LIMIT instead of the current method.
	 */
	public function search($searchFilter = "")
	{
		//If a SearchFilter object is provided, convert it to a string
		if (!is_string($searchFilter))
			$searchFilter = $searchFilter->toString();
		
		//Define total count query (rewrite in future version)
		$totalCountQuery = "SELECT COUNT(*) AS totalCount FROM " . $this->collectionName() . " " . $searchFilter;
		$totalCountArray = explode('LIMIT', $totalCountQuery);
		$totalCountQuery = $totalCountArray[0];
		
		//Search for the total count
		$totalCount = 0;
		Wigbi::dbHandler()->query($totalCountQuery);
		$row = Wigbi::dbHandler()->getNextRow();
		$totalCount = (int)$row["totalCount"];
		
		//Define the search query
		$searchQuery = "SELECT " . $this->collectionName() . ".* FROM " . $this->collectionName() . " ";
		Wigbi::dbHandler()->query($searchQuery . $searchFilter);

		//Put all objects into an array
		$objects = array();
		while ($row = Wigbi::dbHandler()->getNextRow())
		{
			eval('$tmpObj = new ' . $this->className() . '();');
			$tmpObj->parseArray($row);
			array_push($objects, $tmpObj);
		}
		
		//Return the objects and total count
		return array($objects, $totalCount);		
	}
	
	/**
	 * Search for objects within a data list.
	 * 
	 * The method returns an array, where the first element contains
	 * the objects that matched the search operation, with regard to
	 * any applied LIMIT. The second element contains an integer for
	 * the TOTAL number of objects that matched the search operation,
	 * without regard to any applied LIMIT. The final, third element
	 * is a string with the class name of the loaded objects. 
	 * 
	 * All in all, this method works just like the search method, so
	 * see it for further info. One difference between them, however,
	 * is that this method does not support any JOIN operations.
	 * 
	 * The result is a 3 element array, where the first element is a
	 * list with resulting objects, the second an int with the total
	 * number of items and the third the class name of the objects.
	 * 
	 * @access	public
	 * 
	 * @param		string	$listName			The name of the list to search within.
	 * @param		string	$searchFilter	Either a SearchFilter object, or a search filter string; default empty.
	 * @return	array									False if error, else result array.
	 */
	public function searchListItems($listName, $searchFilter = "")
	{
		//Reset object
		$this->reset();
		
		//Abort if the parent has not been saved
		if (!$this->id())
			return false;
		
		//Get the list, abort if none
		$list = $this->getList($listName);
		if (!$list)
			return false;

		//If a SearchFilter object is provided, convert it to a string
		if (!is_string($searchFilter))
			$searchFilter = $searchFilter->toString();
		
		//Create an object instance
		eval('$tmpObj = new ' . $list->itemClass() . '();');
		
		//Define total count query (rewrite in future version)
		$totalCountQuery  = "SELECT COUNT(*) AS totalCount FROM " . $tmpObj->collectionName() . " main ";
		$totalCountQuery .= "INNER JOIN " . $list->tableName() . " sub ON main.id = sub.itemId ";
		$totalCountQuery .= "WHERE sub.ownerId = '" . $list->ownerId() . "' ";
		$totalCountQuery .= str_replace("WHERE", "AND", $searchFilter);
		$totalCountArray = explode('LIMIT', $totalCountQuery);
		$totalCountQuery = $totalCountArray[0];
		
		//Search for the total count
		$totalCount = 0;
		Wigbi::dbHandler()->query($totalCountQuery);
		$row = Wigbi::dbHandler()->getNextRow();
		$totalCount = (int)$row["totalCount"];
		
		//Init result array
		$result = array();
		
		//Delete all list objects that do not exists any longer
		$query = "DELETE FROM " . $list->tableName() . " WHERE itemId NOT IN ";
		$query .= "(SELECT id FROM " . $tmpObj->collectionName() . ")";
		Wigbi::dbHandler()->query($query);

		//Perform search
		$query = "SELECT * FROM " . $tmpObj->collectionName() . " main ";
		$query .= "INNER JOIN " . $list->tableName() . " sub ON main.id = sub.itemId ";
		$query .= "WHERE sub.ownerId = '" . $list->ownerId() . "' ";
		$query .= str_replace("WHERE", "AND", $searchFilter);
		Wigbi::dbHandler()->query($query);
		
		//Put ID:s into a sorted array for a multiple load
		$ids = array();
		while ($row = Wigbi::dbHandler()->getNextRow())
			array_push($ids, $row["id"]);
				
		//Return the objects and total count
		return array($tmpObj->loadMultiple($ids), $totalCount, $tmpObj->className());		
	}
	
	/**
	 * Setup the database so that it can store the data plugin.
	 * 
	 * @access	public
	 */
	public function setupDatabase()
	{
		//Define the character set
		$charSet = " CHARACTER SET utf8 COLLATE utf8_unicode_ci ";

		//Try to create the object table
		Wigbi::dbHandler()->query("CREATE TABLE " . $this->collectionName() . " (id VARCHAR(40) " . $charSet . " NOT NULL, PRIMARY KEY(id))" . $charSet);
		
		//Create a column for each public variable
		foreach ($this->databaseVariables() as $property)
		{
			//Strip the _ from the column name, if needed
			$columnName = $property;
			if (substr($property, 0, 1) == "_")
				$columnName = substr($property, 1, strlen($property));
			
			//Skip id
			if ($columnName == "id")
				continue;
				
			//Execute the table query
			Wigbi::dbHandler()->query("ALTER TABLE " . $this->collectionName() . " ADD ". $columnName . " " . WigbiDataPlugin::getVariableDatabaseType($this->$property));
		}
		
		//Create all object lists that are connected to the object
		foreach ($this->lists() as $list)
			Wigbi::dbHandler()->query("CREATE TABLE " . $list->tableName() . " (ownerId VARCHAR(40) NOT NULL, itemId VARCHAR(40) NOT NULL, position INT NOT NULL, PRIMARY KEY(ownerId, itemId))");
	}
	
	/**
	 * Create a JavaScript variable of the object.
	 * 
	 * This function returns a JavaScript code snippet that creates
	 * a JavaScript variable of the object.
	 * 
	 * @access	public
	 * 
	 * @param		string		$variableName	The name of the JavaScript variable.
	 * @param		bool			$addScriptTag	Whether or not to add a script tag; default false.
	 * @return	string									The resulting JavaScript code.
	 */
	public function toJsVariable($variableName, $addScriptTag = false)
	{
		$result  = "var " . $variableName . " = new " . $this->className() . "();";
		$result .= '$.extend(' . $variableName . ", JSON.parse('" . json_encode($this) . "'));";
		if ($addScriptTag)
			$result = '<script type="text/javascript">' . $result . '</script>';
		return $result;
	}
	
	/**
	 * Validate the object.
	 * 
	 * Override this method to set how an inheriting class is to be
	 * validated. The method returns a string array with validation
	 * messages, which is empty if no validation errors occured.
	 * 
	 * @access	public
	 * 
	 * @return	array	Validation errors list; empty if valid.
	 */
	public function validate()
	{
		return array();
	}
}


/**#@+
 * @ignore
 */

/**
 * Util class that is used to return all public object variables.
 * 
 * This is not intended to be used anywhere else.
 */
class WigbiDataPluginUtil
{
	/**
	 * Get all public variables of an object.
	 * 
	 * This method can not be defined in the WigbiDataPlugin class,
	 * since that would make it return all variables regardless of
	 * their visibility.
	 */
	public static function getPublicVariables($object)
	{
		$result = array();
		foreach ($object as $property=>$value)
			array_push($result, $property);
		return $result;
	}
}

/**
 * Util class that is used to create a "base" class.
 * 
 * This is not intended to be used anywhere else.
 */
class WigbiDataPluginBaseClassUtil extends WigbiDataPlugin { }

/**#@-*/

?>