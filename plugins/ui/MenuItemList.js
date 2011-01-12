/**
 * Wigbi.Plugins.UI.MenuItemList JavaScript class file.
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
 * The Wigbi.Plugins.UI.MenuItemList JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function MenuItemList(id)
{
	$.extend(this, new WigbiUIPlugin(id));
	
	this._oldPosition = 0;
	this._newPosition = 0;
	
	this.canAdd = function() { return this.getElement("canAdd").val() == "1"; };
	this.canDelete = function() { return this.getElement("canDelete").val() == "1"; };
	this.canEdit = function() { return this.getElement("canEdit").val() == "1"; };
	this.canSort = function() { return this.getElement("canSort").val() == "1"; };
	this.cssClass = function() { return this.getElement("cssClass").val(); };
	this.parentItem = function() { return this.getElementData("object", new MenuItem()); };

	this.deleteListItem = function(itemId)
	{
		if (!this.canDelete())
			return;
			
		var _this = this;
		this.parentItem().deleteListItem("children", itemId, function() { _this.reload(); _this.onDeleteListItem(itemId); });
	};
	
	this.moveListItem = function(itemId, numSteps)
	{
		if (!this.canSort())
			return;
			
		var _this = this;
		this.parentItem().moveListItem("children", itemId, numSteps, function() { _this.onMoveListItem(itemId, numSteps); });
	};
	
	this.reload = function()
	{
		MenuItemList.add(id, this.parentItem().id(), "", this.cssClass(), this.canAdd(), this.canDelete(), this.canEdit(), this.canSort(), id + "-container", this.onReload);
	};

	this.onAddClicked = function() {};
	this.onDeleteListItem = function(itemId) {};
	this.onEditClicked = function(itemId) {};
	this.onMoveListItem = function(itemId, numSteps) {};
	this.onReload = function(itemId) {};
	
	if (this.canSort())
	{
		var _this = this;
		var ul = $("#" + id + ".cansort");
		ul.sortable({
	    start: function(e, ui) { _this.oldPosition = ul.children().index(ui.item[0]); },
	    update: function(e, ui){ _this.newPosition = ul.children().index(ui.item[0]); mil.moveListItem($(ui.item[0]).attr("id"), _this.newPosition - _this.oldPosition); }
		});
		ul.disableSelection();
	}
};


//[AJAX] Add a new plugin instance to the page
MenuItemList.add = function(id, parentObjectId, parentObjectName, cssClass, canAdd, canDelete, canEdit, canSort, targetContainerId, onAdd)
{
	Wigbi.ajax("MenuItemList", null, "add", [id, parentObjectId, parentObjectName, cssClass, canAdd, canDelete, canEdit, canSort], function(response) 
	{
		response = response.replace(/~\//gi, Wigbi.webRoot());
		
		$("#" + targetContainerId).html(response);
		eval(id + " = new MenuItemList('" + id + "');");
		
		if (onAdd)
			onAdd();
	});
};