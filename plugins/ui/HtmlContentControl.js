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
function HtmlContentControl(id)
{
	$.extend(this, new WigbiUIPlugin(id));
	var _this = this;
	
	
	this.submit = function()
	{
		var obj = new HtmlContent();
		obj.load(_this.getElement("objectId").val(), function() {
			obj.name(_this.getElement("nameInput").val());
			obj.title(_this.getElement("titleInput").val());
			obj.content(_this.getElement("contentInput").val());
			try { obj.content(tinyMCE.get(_this.getElement("contentInput").attr("id")).getContent()); }
			catch(e) { }
			
			var submitButton = _this.getElement("submit");
			submitButton.attr("disabled", "disabled");
			
			obj.save(function() {
				submitButton.attr("disabled", "");
				_this.getElement("content").html(obj.content());
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


HtmlContentControl.add = function(id, objectId, objectName, embedForm, targetContainerId, onAdd)
{
	Wigbi.ajax("HtmlContentControl", null, "add", [id, objectId, objectName, embedForm], function(response) {		
		$("#" + targetContainerId).html(response);
		eval(id + " = new HtmlContentControl('" + id + "');");
		if (onAdd)
			onAdd(eval(id));
	});
};