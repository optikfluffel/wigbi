<?php
/**
 * Wigbi.JS.Core.WigbiDataPlugin class file.
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
 * The Wigbi.JS.Core.WigbiDataPlugin class.
 * 
 * This class is used to provide data plugins with base functionality.
 * In order to work properly, all data plugin classes must inherit it.
 * Since Wigbi auto-generates JavaScript classes for all data plugins
 * that are added, this is automatically taken care of.
 * 
 * Most class methods are asynchronous and are based on the PHP class,
 * which is executed via the Wigbi.ajax(...) method. All asynchronous
 * methods expose the result as a parameter to the callback method. 
 * 
 * See the documentation for the corresponding PHP class for further
 * information about how to work with data plugins.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS.Core
 * @version			1.0.0
 * 
 * @abstract
 */
abstract class WigbiDataPlugin_ extends WigbiClass_
{
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 */
	public function __construct() { }
	
	
		
	/**
	 * Get the object ID, which is set when the object is saved.
	 * 
	 * @access	public
	 * 
	 * @return	string	The object ID.
	 */
	public function id() { return ""; }
	
	
	
	/**
	 * [ASYNC] Add an object to a data list.
	 * 
	 * Callback method signature: onAddListItem[bool success] 
	 * 
	 * @access	public
	 * 
	 * @param	string		$listName		The name of the list to add the object to.
	 * @param	string		$objectId		The ID of the object to add to the list.
	 * @param	function	$onAddListItem	Raised when the AJAX call returns a response.
	 */
	public function addListItem($listName, $objectId, $onAddListItem) { }
	
	/**
	 * [ASYNC] Delete an object from a data list.
	 * 
	 * Callback method signature: onDeleteListItem(bool success)
	 * 
	 * @access	public
	 * 
	 * @param	string		$listName	The name of the list to delete from.
	 * @param	string		$objectId	The ID of the object to remove from the list.
	 * @param	function	$onDelete	Raised when the AJAX call returns a response.
	 */
	public function deleteListItem($listName, $objectId, $onDeleteListItem) { }
	
	/**
	 * [ASYNC] Delete the object from the database.
	 * 
	 * This method is not called delete, since that word is reserved.
	 * 
	 * Callback method signature: onDeleteObject(bool success)
	 * 
	 * @access	public
	 * 
	 * @param	function	$onDeleteObject	Raised when the AJAX call returns a response.
	 */
	public function deleteObject($onDelete) { }
	
	/**
	 * [ASYNC] Get objects from a data list.
	 *
	 * This method is a convenient way of retrieving objects without
	 * having to use a complex search operation.
	 * 
	 * Callback method signature: onGetListItems(array objects, int maxCount, string className)
	 * 
	 * @access	public
	 * 
	 * @param	string		$listName		The name of the list.
	 * @param	int			$skipCount		The number of rows to skip before starting to retrieve objects; default 0.
	 * @param	int			$maxCount		The max number of objects to return; default 100.
	 * @param	function	$onGetListItems	Raised when the AJAX call returns a response.
	 */
 	public function getListItems($listName, $skipCount = 0, $maxCount = 100, $onGetListItems) { }
	
	/**
	 * [ASYNC] Load an object from the database, using its ID.
	 * 
	 * Callback method signature: onLoad(object loadedObject)
	 * 
	 * @access	public
	 * 
	 * @param	string		$loadId	The ID of the object to load.
	 * @param	function	$onLoad	Raised when the AJAX call returns a response.
	 */
	public function load($id, $onLoad) { }
	
	/**
	 * [ASYNC] Load an object from the database, using any property.
	 * 
	 * Callback method signature: onLoadBy(object loadedObject)
	 * 
	 * @access	public
	 * 
	 * @param	string		$propertyName	The name of the property.
	 * @param	string		$propertyValue	The property value.
	 * @param	function	$onLoadBy		Raised when the AJAX call returns a response.
	 */
	public function loadBy($propertyName, $propertyValue, $onLoadBy) { }

	/**
	 * [ASYNC] Load multiple objects from the database, using their ID.
	 * 
	 * This method returns the objects in the order specified by the
	 * provided ID array, provided that each ID exists.
	 * 
	 * Callback method signature: onLoadBy(array loadedObjects)  
	 * 
	 * @access	public
	 * 
	 * @param	array		$loadIds		The IDs of the objects to load.
	 * @param	function	$onLoadMultiple	Raised when the AJAX call returns a response.
	 */
	public function loadMultiple($ids, $onLoadMultiple) { }

	/**
	 * [ASYNC] Move an object back or forward within a data list.
	 *
	 * The move operation will only have a noticable effect on lists
	 * without a default sort rule, since the move operation affects
	 * the position column.
	 * 
	 * Callback method signature: onMoveListItem(bool success)  
	 * 
	 * @access	public
	 * 
	 * @param	string		$listName		The name of the list to move within.
	 * @param	string		$objectId		The ID of the item to move.
	 * @param	int			$numSteps		The number of steps, positive or negative, the object should be moved.
	 * @param	function	$onMoveListItem	Raised when the AJAX call returns a response.
	 */
	public function moveListItem($listName, $objectId, $numSteps, $onMoveListItem) { }

	/**
	 * [ASYNC] Move an object first within a data list. 
	 * 
	 * Callback method signature: onMoveListItemFirst(bool success)
	 * 
	 * @param	string		$listName				The name of the list.
	 * @param	string		$objectId				The ID of the item to move.
	 * @param	function	$onMoveListItemFirst	Raised when the AJAX call returns a response.
	 */
	public function moveListItemFirst($listName, $objectId, $onMoveListItemFirst) { }

	/**
	 * [ASYNC] Move an object last within a data list. 
	 * 
	 * Callback method signature: onMoveListItemLast(bool success)
	 * 
	 * @param	string		$listName			The name of the list.
	 * @param	string		$objectId			The ID of the item to move.
	 * @param	function	$onMoveListItemLast	Raised when the AJAX call returns a response.
	 */
	public function moveListItemLast($listName, $objectId, $onMoveListItemLast) { }
	
	/**
	 * [ASYNC] Save the object to the database.
	 * 
	 * Callback method signature: onSave(object savedObject)  
	 * 
	 * @access	public
	 * 
	 * @param	function	$onSave	Raised when the AJAX call returns a response.
	 */
	public function save($onSave) { }

	/**
	 * [ASYNC] Search for objects in the database.
	 * 
	 * This method accepts a SearchFilter object as well as a search
	 * filter string. The first option is more convenient, while the
	 * second is more flexible, since you are then free to build the
	 * search query exactly like you want it.
	 * 
	 * See the PHP class method documentation for further info about
	 * how to search for objects.
	 * 
	 * Callback method signature: onSearch(array(array objects, int maxCount))
	 * 
	 * @access	public
	 * 
	 * @param	mixed		$searchFilter	Either a SearchFilter object, or a search query.
	 * @param	function	$onSearch		Raised when the AJAX call returns a response.
	 * 
	 * @todo	Use a regexp to mask out the LIMIT instead of the current method.
	 */
	public function search($searchFilter, $onSearch) { }
	
	/**
	 * [ASYNC] Search for objects within a data list.
	 * 
	 * This method works just like the search method, except that it
	 * does not support any JOIN operations.
	 * 
	 * See the PHP class method documentation for further info about
	 * how to search for objects.
	 * 
	 * Callback method signature: onSearchListItems(array(array objects, int maxCount, string className))
	 * 
	 * @access	public
	 * 
	 * @param	string		$listName			The name of the list to search within.
	 * @param	string		$searchFilter		Either a SearchFilter object, or a search filter string; default empty.
	 * @param	function	$onSearchListItems	Raised when the AJAX call returns a response.
	 */
	public function searchListItems($listName, $searchFilter, $onSearchListItems) { }
	
	/**
	 * [ASYNC] Validate the object.
	 * 
	 * Override this method to set how an inheriting class is to be
	 * validated. The method returns a string array with validation
	 * messages, which is empty if no validation errors occured.
	 * 
	 * Callback method signature: onValidate(array validationResult)
	 * 
	 * @access	public
	 * 
	 * @param	function	$onValidate	Raised when the AJAX call returns a response.
	 */
	public function validate($onValidate) { }
}

?>