/**
 * Wigbi.Plugins.UI.HtmlContentControl JavaScript class file.
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
 * The Wigbi.Plugins.UI.HtmlContentControl JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function HtmlContentControl(id, htmlContentForm)
{
	//Inherit WigbiUIPlugin
	$.extend(this, new WigbiUIPlugin(id));
	
	
	//Get/set the object that is handled by the form
	this.obj = function(newVal)
	{
		if (typeof(newVal) != "undefined")
		{
			this.getElement("object").html(JSON.stringify(newVal));
			if (htmlContentForm && htmlContentForm.obj() != newVal)
				htmlContentForm.obj(newVal);
			this.reset();
		}
		
		return this.getElementData("object", new HtmlContent());
	};
	
	
	//Reset the control
	this.reset = function()
	{
		this.getElement("content").html(this.obj().content());
	};
	
	
	//Make sure that the control/form objects are in sync
	var _this = this;
	if (htmlContentForm)
		htmlContentForm.onSubmit = function() { _this.obj(htmlContentForm.obj()); };
};


//[AJAX] Add a new plugin instance to the page
HtmlContentControl.add = function(id, objectId, objectName, embedForm, targetContainerId, onAdd)
{
	embedForm = embedForm ? 1 : 0;
	
	Wigbi.ajax("HtmlContentControl", null, "add", [id, objectId, objectName, embedForm], function(response) 
	{
		$("#" + targetContainerId).html(response);
		eval(id + "Form" + " = new HtmlContentForm('" + id + "Form" + "');");
		eval(id + " = new HtmlContentControl('" + id + "', " + id + "Form);");
		
		if (onAdd)
			onAdd();
	});
};