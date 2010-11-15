/**
 * Wigbi.Plugins.UI.HtmlContentForm JavaScript class file.
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
 * The Wigbi.Plugins.UI.HtmlContentForm JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function HtmlContentForm(id)
{
	//Inherit WigbiUIPlugin
	$.extend(this, new WigbiUIPlugin(id));
	
	
	//Get/set the object that is handled by the form
	this.obj = function(newVal)
	{
		if (typeof(newVal) != "undefined")
		{
			this.getElement("object").html(JSON.stringify(newVal));
			this.reset();
		}
		return this.getElementData("object", new HtmlContent());
	};
	

	//Reset the form
	this.reset = function()
	{
		this.getElement("name").val(this.obj().name());
		this.getElement("content").val(this.obj().content());
		try { (tinyMCE.get(this.getElement("content").attr("id")).setContent(this.obj().content())); }
		catch(e) { }
	};

	//Submit the form
	this.submit = function()
	{
		var obj = this.obj();
		obj.name(this.getElement("name").val());
		obj.content(this.getElement("content").val());
		try { obj.setContent(tinyMCE.get(this.getElement("content").attr("id")).getContent()); }
		catch(e) { }
		
		var button = this.getElement("submitButton");
		button.attr("disabled", "disabled");
		
		var _this = this;
		obj.save(function()
		{
			_this.obj(obj);
			button.attr("disabled", "");
			_this.onSubmit();
		});
	};

	//This event method is raised after a submit operation succeeds	
	this.onSubmit = function() {};
};


//[AJAX] Add a new plugin instance to the page
HtmlContentForm.add = function(id, objectId, objectName, targetContainerId, onAdd)
{
	Wigbi.ajax("HtmlContentForm", null, "add", [id, objectId, objectName], function(response) 
	{
		$("#" + targetContainerId).html(response);
		eval(id + " = new HtmlContentForm('" + id + "');");
		
		if (onAdd)
			onAdd();
	});
};