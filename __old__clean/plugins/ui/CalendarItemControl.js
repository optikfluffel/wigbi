/**
 * Wigbi.Plugins.UI.CalendarItemControl JavaScript class file.
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
 * The Wigbi.Plugins.UI.CalendarItemControl JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function CalendarItemControl(id)
{
	$.extend(this, new WigbiUIPlugin(id));
	var _this = this;
	
	
	this.setObject = function(obj)
	{
		_this.getElement("title").html(obj.title());
		_this.getElement("description").html(obj.description());
				
		this.getElement("idInput").val(obj.id());
		this.getElement("titleInput").val(obj.title());
		this.getElement("startDateTimeInput").val(obj.startDateTime());
		this.getElement("endDateTimeInput").val(obj.endDateTime());
		
		var checkbox = this.getElement("fullDayInput");
		checkbox.removeAttr("checked");
		if (obj.fullDay())
			checkbox.attr("checked", "checked");
		
		this.getElement("descriptionInput").val(obj.description());
		try { tinyMCE.get(_this.getElement("descriptionInput").attr("id")).setContent(obj.description()); }
		catch(e) { }
	}
	
	this.submit = function()
	{
		var obj = new CalendarItem();
		obj.load(_this.getElement("idInput").val(), function() {
			var startDateTime = _this.getElement("startDateTimeInput").val();
			var endDateTime = _this.getElement("endDateTimeInput").val();
			var fullDay = _this.getElement("fullDayInput").attr('checked');
			
			obj.title(_this.getElement("titleInput").val());
			obj.startDateTime(startDateTime);
			obj.endDateTime(startDateTime);
			if (!fullDay)
				obj.endDateTime(endDateTime);
			obj.fullDay(fullDay);	
			obj.description(_this.getElement("descriptionInput").val());
			try { obj.description(tinyMCE.get(_this.getElement("descriptionInput").attr("id")).getContent()); }
			catch(e) { }
			
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


	/* jQuery UI datepicker + datetimepicker addon */ 
	//$.datepicker.setDefaults($.datepicker.regional[Wigbi.languageHandler().translate("language")]);
	//this.getElement("startDateTimeInput").datetimepicker({ timeFormat: 'hh:mm:ss', showButtonPanel: false });
	//this.getElement("endDateTimeInput").datetimepicker({ timeFormat: 'hh:mm:ss', showButtonPanel: false });
	/* jQuery UI datepicker + datetimepicker addon */
	
	this.getElement("fullDayInput").change(function() {
		_this.getElement("endDateTimeDiv").toggleClass("hide");
	});
	
	var form = this.getElement("form");
	if (form) {
		form.submit(function() {
			_this.submit();
			return false;
		});
	}
};


CalendarItemControl.add = function(id, objectId, embedForm, targetContainerId, onAdd)
{
	Wigbi.ajax("CalendarItemControl", null, "add", [id, objectId, embedForm], function(response) {		
		$("#" + targetContainerId).html(response);
		eval(id + " = new CalendarItemControl('" + id + "');");
		if (onAdd)
			onAdd(eval(id));
	});
};