/**
 * Wigbi.Plugins.UI.LogoutLink JavaScript class file.
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
 * The Wigbi.Plugins.UI.LogoutLink JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function LogoutLink(id, redirectUrl)
{
	$.extend(this, new WigbiUIPlugin(id));
	var _this = this;
	
	
	this.submit = function()
	{
		var redirectUrl = this.getElement("redirectUrl").val();

		User.logout(function(result)
		{
			_this.onSubmit(result);
			
			if (result)
			{
				if (redirectUrl)
					location.href = redirectUrl;
				else
					location.href = location.href;
			}
		});
	};

	
	this.onSubmit = function(result) { };
};


LogoutLink.add = function(id, redirectUrl, targetContainerId, onAdd)
{
	Wigbi.ajax("LogoutLink", null, "add", [id, redirectUrl], function(response) 
	{
		$("#" + targetContainerId).html(response);
		eval(id + " = new LogoutLink('" + id + "', '" + redirectUrl + "');");
		
		if (onAdd)
			onAdd(eval(id));
	});
};