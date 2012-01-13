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
	
	
	this.setObject = function(obj)
	{
		this.getElement("idInput").val(obj.id());
		this.getElement("parentIdInput").val(obj.parentId());
		this.getElement("nameInput").val(obj.name());
		this.getElement("urlInput").val(obj.url());
		this.getElement("textInput").val(obj.text());
		this.getElement("tooltipInput").val(obj.tooltip());
	}
	
	this.submit = function()
	{
		var obj = new MenuItem();
		obj.load(_this.getElement("idInput").val(), function() {
			obj.parentId(_this.getElement("parentIdInput").val());
			obj.name(_this.getElement("nameInput").val());
			obj.url(_this.getElement("urlInput").val());
			obj.text(_this.getElement("textInput").val());
			obj.tooltip(_this.getElement("tooltipInput").val());
			
			var submitButton = _this.getElement("submit");
			submitButton.attr("disabled", "disabled");
			
			obj.save(function() {
				submitButton.attr("disabled", "");
				_this.setObject(obj);
				_this.onSubmit(obj);
			});
		});
	};
	
	
	this.onSubmit = function(obj) {};
	
	
	var form = this.getElement("form");
	if (form) {
		form.submit(function() {
			_this.submit();
			return false;
		});
	}
};


MenuItemForm.add = function(id, objectId, objectName, targetContainerId, onAdd)
{
	Wigbi.ajax("MenuItemForm", null, "add", [id, objectId, objectName], function(response) {		
		$("#" + targetContainerId).html(response);
		eval(id + " = new MenuItemForm('" + id + "');");
		if (onAdd)
			onAdd(eval(id));
	});
};