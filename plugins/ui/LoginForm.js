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
	

	//Reset the form
	this.reset = function()
	{
		this.getElement("name").val(this.obj().name());
		this.getElement("content").val(this.obj().content());
	};

	//Submit the form
	this.submit = function()
	{
		var userName = this.getElement("userName").val();
		var password = this.getElement("password").val();
		var redirectUrl = this.getElement("redirectUrl").val();
		
		this.getElement("submitButton").attr("disabled", "disabled");
		
		var _this = this;
		User.login(userName, password, function(result, exception)
		{
			_this.getElement("submitButton").attr("disabled", "");
			
			var exceptions = [];
			if (exception)
				exceptions = exception.split(",");
			_this.bindErrors(["userName", "password"], exceptions);
			
			_this.onSubmit(result, exception);
			
			if (result && redirectUrl)
				location.href = redirectUrl;
		});
	};


	//This event method is raised after a submit operation succeeds	
	this.onSubmit = function(loginResult, exception)
	{
		var msg = "";
		
		if (!loginResult || exception)
			msg = this.translate("loginFailed") + ". ";
		if (!loginResult)
			msg += this.translate("invalidCredentials") + ". ";
		if (exception)
		{
			var exceptions = exception.split(",");
			for (var i=0; i<exceptions.length; i++)
				msg += this.translate(exceptions[i]) + ". ";
		}
		
		if (msg)
			alert(msg);
	};
};


//[AJAX] Add a new plugin instance to the page
LoginForm.add = function(id, redirectUrl, autoRedirect, targetContainerId, onAdd)
{
	Wigbi.ajax("LoginForm", null, "add", [id, redirectUrl, autoRedirect], function(response) 
	{
		$("#" + targetContainerId).html(response);
		eval(id + " = new LoginForm('" + id + "');");
		
		if (onAdd)
			onAdd();
	});
};