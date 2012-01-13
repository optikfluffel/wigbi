/**
 * Wigbi.Plugins.UI.YouTubePlayer JavaScript class file.
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
 * The Wigbi.Plugins.UI.YouTubePlayer JavaScript class.
 * 
 * This part of the plugin is documented together with the PHP class.
 */
function YouTubePlayer(id)
{
	$.extend(this, new WigbiUIPlugin(id));
};


YouTubePlayer.add = function(id, movieUrl, width, height, targetContainerId, onAdd)
{
	Wigbi.ajax("YouTubePlayer", null, "add", [id, movieUrl, width, height], function(response) 
	{
		$("#" + targetContainerId).html(response);
		eval(id + " = new YouTubePlayer('" + id + "', '" + redirectUrl + "');");
		
		if (onAdd)
			onAdd(eval(id));
	});
};