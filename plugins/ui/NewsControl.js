/**
 * Wigbi.Plugins.UI.NewsControl JavaScript class file.
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
 * The Wigbi.Plugins.UI.NewsControl JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function NewsControl(id, newsForm)
{
	$.extend(this, new WigbiUIPlugin(id));
	var _this = this;
	
	
	this.obj = function(newVal)
	{
		if (typeof(newVal) != "undefined")
		{
			this.getElement("object").html(JSON.stringify(newVal));
			if (newsForm && newsForm.obj() != newVal)
				newsForm.obj(newVal);
			this.reset();
		}
		
		return this.getElementData("object", new News());
	};
	
	
	this.reset = function()
	{
		this.getElement("content").html(this.obj().content());
	};
	
	
	if (newsForm)
		newsForm.onSubmit = function() { _this.obj(newsForm.obj()); };
};


NewsControl.add = function(id, objectId, objectTitle, embedForm, targetContainerId, onAdd)
{
	embedForm = embedForm ? 1 : 0;
	
	Wigbi.ajax("NewsControl", null, "add", [id, objectId, objectTitle, embedForm], function(response) 
	{
		$("#" + targetContainerId).html(response);
		eval(id + "Form" + " = new NewsForm('" + id + "Form" + "');");
		eval(id + " = new NewsControl('" + id + "', " + id + "Form);");
		
		if (onAdd)
			onAdd(eval(id));
	});
};