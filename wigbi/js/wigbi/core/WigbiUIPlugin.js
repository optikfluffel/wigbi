/**
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
 * The Wigbi.JS.Core.WigbiUIPlugin class.
 * 
 * This class is fully described in the class documentation that can
 * be found at http://www.wigbi.com/documentation or downloaded as a
 * part of the Wigbi source code download.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS.Core
 * @version			1.0.0
 */
function WigbiUIPlugin(id)
{
	//Private variables
	this._id = id;

	
	//Inherit from WigbiClass
	$.extend(this, new WigbiClass());
    

	//Get the unique instance ID
	this.id = function() { return this._id; };
	

	//Bind error messages to plugin DOM elements
	this.bindErrors = function(elementIds, errorCodes)
	{ 
		var errorClass = "validation-error";
		
		if (typeof(errorCodes) == "string")
				errorCodes = errorCodes.split(",");
		
		for (var i=0; i<elementIds.length; i++)
		{
			var fullId = "#" + this.id() + "-" + elementIds[i];
			$(fullId).removeClass(errorClass);
			
			for (var j=0; j<errorCodes.length; j++)
			{
				if (errorCodes[j].substring(0, elementIds[i].length) == elementIds[i])
				{
					$(fullId).attr("title", Wigbi.languageHandler().translate(errorCodes[j]));
					$(fullId).addClass(errorClass);
				}
			}
		}
	};
	
	//Retrieve a certain element (must have the id <id>-elementName)
	this.getElement = function(elementName)
	{
		return $("#" + this.id() + "-" + elementName);
	};
	
	//Retrieve data that is stored as JSON within a certain element
	this.getElementData = function(elementName, baseObject)
	{
		$.extend(baseObject, JSON.parse(this.getElement(elementName).val()));
		return baseObject;
	};
	
	//[VIRTUAL] Reset the plugin, if applicable
	this.reset = function() { };
	
	//[VIRTUAL] Submit the plugin, if applicable
	this.submit = function() { };
	
	//Translate a string, using the Wigbi languageHandler instance.
	this.translate = function(str)
	{
		return Wigbi.languageHandler().translate(this.id() + " " + this.className() + " " + str);
	};
}