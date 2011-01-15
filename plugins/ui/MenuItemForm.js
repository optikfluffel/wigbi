/**
 * Wigbi.Plugins.UI.MenuItemForm JavaScript class file.
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
 * The Wigbi.Plugins.UI.MenuItemForm JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function MenuItemForm(id)
{
	$.extend(this, new WigbiUIPlugin(id));
		var _this = this;
	
	
	this.obj = function(newVal)
	{
		if (typeof(newVal) != "undefined")
		{
			this.getElement("object").html(JSON.stringify(newVal));
			this.reset();
		}
		
		return this.getElementData("object", new MenuItem());
	};
	

	this.reset = function()
	{
		this.getElement("name").val(this.obj().name());
		this.getElement("url").val(this.obj().url());
		this.getElement("text").val(this.obj().text());
		this.getElement("tooltip").val(this.obj().tooltip());
	};

	this.submit = function()
	{
		var obj = this.obj();
		obj.name(this.getElement("name").val());
		obj.url(this.getElement("url").val());
		obj.text(this.getElement("text").val());
		obj.tooltip(this.getElement("tooltip").val());
		
		var button = this.getElement("submit");
		button.attr("disabled", "disabled");
		
		obj.save(function()
		{
			_this.obj(obj);
			button.attr("disabled", "");
			_this.onSubmit();
		});
	};

	
	this.onSubmit = function() {};
	
	
	this.getElement("form").submit(function() { _this.submit(); return false; });
};


MenuItemForm.add = function(id, objectId, objectName, targetContainerId, onAdd)
{
	Wigbi.ajax("MenuItemForm", null, "add", [id, objectId, objectName], function(response) 
	{
		$("#" + targetContainerId).html(response);
		eval(id + " = new MenuItemForm('" + id + "');");
		
		if (onAdd)
			onAdd(eval(id));
	});
};