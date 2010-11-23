/**
 * Wigbi.Plugins.UI.LoginForm JavaScript class file.
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
 * The Wigbi.Plugins.UI.LoginForm JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function LoginForm(id)
{
	//Inherit WigbiUIPlugin
	$.extend(this, new WigbiUIPlugin(id));
	

	//Submit the form
	this.submit = function()
	{
		var userName = this.getElement("userName").val();
		var password = this.getElement("password").val();
		var redirectUrl = this.getElement("redirectUrl").val();
		
		var button = this.getElement("submit");
		button.attr("disabled", "disabled");
		
		var _this = this;
		User.login(userName, password, function(result, exceptions)
		{
			button.attr("disabled", "");
			_this.bindErrors(["userName", "password"], exceptions, !result ? _this.translate("invalidCredentials") : "");
			_this.onSubmit(result, exceptions);
			
			if (result)
			{
				if (redirectUrl)
					location.href = redirectUrl;
				else
					location.href = location.href;
			} 
		});
	};
	

	//This event method is raised after a submit operation finishes	
	this.onSubmit = function(result, exceptions) {};
	
	
	//Override the form submit event
	var _this = this;
	this.getElement("form").submit(function() { _this.submit(); return false; });
};


//[AJAX] Add a new plugin instance to the page
LoginForm.add = function(id, redirectUrl, targetContainerId, onAdd)
{
	Wigbi.ajax("LoginForm", null, "add", [id, redirectUrl, 0], function(response) 
	{
		$("#" + targetContainerId).html(response);
		eval(id + " = new LoginForm('" + id + "');");
		
		if (onAdd)
			onAdd();
	});
};