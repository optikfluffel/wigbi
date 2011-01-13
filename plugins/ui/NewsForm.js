/**
 * Wigbi.Plugins.UI.NewsForm JavaScript class file.
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
 * The Wigbi.Plugins.UI.NewsForm JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function NewsForm(id)
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
		
		return this.getElementData("object", new News());
	};
	

	this.reset = function()
	{
		this.getElement("title").val(this.obj().title());
		this.getElement("content").val(this.obj().content());
		try { (tinyMCE.get(this.getElement("content").attr("id")).setContent(this.obj().content())); }
		catch(e) { }
	};

	this.submit = function()
	{
		var obj = this.obj();
		obj.title(this.getElement("title").val());
		obj.content(this.getElement("content").val());
		try { obj.setContent(tinyMCE.get(this.getElement("content").attr("id")).getContent()); }
		catch(e) { }
	
		var button = this.getElement("submitButton");
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


NewsForm.add = function(id, objectId, objectTitle, targetContainerId, onAdd)
{
	Wigbi.ajax("NewsForm", null, "add", [id, objectId, objectTitle], function(response) 
	{
		$("#" + targetContainerId).html(response);
		eval(id + " = new NewsForm('" + id + "');");
		
		if (onAdd)
			onAdd(eval(id));
	});
};