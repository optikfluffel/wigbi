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
 * This class is fully described in the class documentation that can
 * be found at http://www.wigbi.com/documentation or downloaded as a
 * part of the Wigbi source code download.
 * 
 * This class is a lot smaller than the corresponding PHP class, due
 * to the fact that most functionality is accessed with asynchronous
 * AJAX calls. Thus, data lists and other such important features of
 * the PHP class are not implemented in this class. 
 *  
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS.Core
 * @version			1.0.0
 */
function WigbiDataPlugin()
{
	//Private variables
	this._id = "";


	//Inherit from WigbiClass
	$.extend(this, new WigbiClass());
    

	//Get the ID of the plugin
	this.id = function() { return this._id; };
	

	//Add an object to a data list
	this.addListItem = function(listName, objectId, onAddListItem)
	{
		Wigbi.ajax(this.className(), this, "addListItem", [listName, objectId], onAddListItem);
	};
	
	//Delete an object from a data list
	this.deleteListItem = function(listName, objectId, onDeleteListItem)
	{
		Wigbi.ajax(this.className(), this, "deleteListItem", [listName, objectId], onDeleteListItem);
    },
	
	//Delete the object from the database
	this.deleteObject = function(onDeleteObject)
	{
		var _this = this;
		
		Wigbi.ajax(this.className(), this, "delete", [], function(response)
		{
			if (response)
				_this._id = "";
				
			if (onDeleteObject)
				onDeleteObject(response);
		});	
	};
	
	//Get objects from a data list
	this.getListItems = function(listName, skipCount, maxCount, onGetListItems)
	{
		if (!skipCount)
			skipCount = 0;

		if (!maxCount)
			maxCount = 100;
			
		Wigbi.ajax(this.className(), this, "getListItems", [listName, skipCount, maxCount], function(response)
		{
			for (var i=0; i<response[0].length; i++)
			{
				eval("var tmpObj = new " + response[2] + "();");
				$.extend(tmpObj, response[0][i]);
				response[0][i] = tmpObj;
			}
			
			if (onGetListItems)
				onGetListItems(response);
		});
	};
	
	//Load an object from the database, using its ID
	this.load = function(id, onLoad)
	{
		this.loadBy("id", id, onLoad);
	};
	
	//Load an object from the database, using any property
	this.loadBy = function(propertyName, propertyValue, onLoadBy)
	{
		var _this = this;
		
		Wigbi.ajax(this.className(), this, "loadBy", [propertyName, propertyValue], function(response)
		{
			$.extend(_this, response);
			
			if (onLoadBy)
				onLoadBy(_this);
		});
	};
	
	//Load multiple objects from the database, using their ID
	this.loadMultiple = function(ids, onLoadMultiple)
	{
		var _this = this;
		
		Wigbi.ajax(this.className(), this, "loadMultiple", [ids], function(response)
		{
			var result = [];
			
			for (var i=0; i<response.length; i++)
			{
				eval("var tmpObj = new " + _this.className() + "();");
				$.extend(tmpObj, response[i]);
				result.push(tmpObj);
			}
			
			if (onLoadMultiple)
				onLoadMultiple(result);
		});
	};
	
	//Move an object back or forward within a data list
	this.moveListItem = function(listName, objectId, numSteps, onMoveListItem)
	{
		Wigbi.ajax(this.className(), this, "moveListItem", [listName, objectId, numSteps], onMoveListItem);	
	};	
	
	//Move an object first within a data list
	this.moveListItemFirst = function(listName, objectId, onMoveListItemFirst)
	{
		Wigbi.ajax(this.className(), this, "moveListItemFirst", [listName, objectId], onMoveListItemFirst);	
	};	
	
	//Move an object last within a data list
	this.moveListItemLast = function(listName, objectId, onMoveListItemLast)
	{
		Wigbi.ajax(this.className(), this, "moveListItemLast", [listName, objectId], onMoveListItemLast);	
	};	
	
	//Save the object to the database
	this.save = function(onSave)
	{
		var _this = this;
		
		Wigbi.ajax(this.className(), this, "save", [], function(response)
		{
			$.extend(_this, response);
			
			if (onSave)
				onSave(_this);
		});	
	};
	
	//Search for objects in the database.
	this.search = function(searchFilter, onSearch)
	{	
		var _this = this;
		
		if (typeof(searchFilter) == "object")
			searchFilter = searchFilter.toString();
		
		Wigbi.ajax(this.className(), this, "search", [searchFilter], function(response)
		{
			for (var i=0; i<response[0].length; i++)
			{
				eval("var tmpObj = new " + _this.className() + "();");
				$.extend(tmpObj, response[0][i]);
				response[0][i] = tmpObj;
			}
			
			if (onSearch)
				onSearch(response);
		});
	};
	
	//Search for objects within a data list
	this.searchListItems = function(listName, searchFilter, onSearchListItems)
	{
		if (typeof(searchFilter) == "object")
			searchFilter = searchFilter.toString();
			
		Wigbi.ajax(this.className(), this, "searchListItems", [listName, searchFilter], function(response)
		{
			for (var i=0; i<response[0].length; i++)
			{
				eval("var tmpObj = new " + response[2] + "();");
				$.extend(tmpObj, response[0][i]);
				response[0][i] = tmpObj;
			}
			
			if (onSearchListItems)
				onSearchListItems(response);
		});
	};
	
	//Validate the object
	this.validate = function(onValidate)
	{
		Wigbi.ajax(this.className(), this, "validate", [], onValidate); 
	}
};