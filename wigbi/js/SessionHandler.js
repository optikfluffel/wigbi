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
 * The Wigbi.JS.SessionHandler class.
 * 
 * This class is fully described in the class documentation that can
 * be found at http://www.wigbi.com/documentation or downloaded as a
 * part of the Wigbi source code download.
 *  
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 */
function SessionHandler(applicationName)
{
	//Private variables
	this._applicationName = applicationName;


	//Inherit WigbiClass
	$.extend(this, new WigbiClass());
    

	//Get/set the name of the application to which the data belongs
	this.applicationName = function(newVal)
	{
		if (typeof(newVal) != "undefined")
			this._applicationName = newVal;
		return this._applicationName;
	};
	

	//Clear any cached data
	this.clear = function(key, onClear)
	{
		Wigbi.ajax("SessionHandler", this.getRequestObject(), "clear", [key], onClear);	
	};
	
	//Retrieve data from the cache
	this.get = function(key, onGet)
	{
		Wigbi.ajax("SessionHandler", this.getRequestObject(), "get", [key], onGet);	
	};
	
	//Get an object that can be used in asynchronous operations
	this.getRequestObject = function()
	{
		var obj = new SessionHandler();
		$.extend(obj, this);
		
		return obj;	
	};
	
	//Save data to the cache
	this.set = function(key, data, onSet)
	{
		Wigbi.ajax("SessionHandler", this.getRequestObject(), "set", [key, data], onSet);	
	};
};