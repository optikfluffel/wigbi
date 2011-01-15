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
 * The Wigbi.JS.CacheHandler class.
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
function CacheHandler(cacheFolder)
{
	//Private variables
	this._cacheFolder = cacheFolder;


	//Inherit WigbiClass
	$.extend(this, new WigbiClass());
    

	//Get/set the path to the cache folder
	this.cacheFolder = function(newVal)
	{
		if (typeof(newVal) != "undefined")
			this._cacheFolder = newVal;
		return this._cacheFolder;
	};
	

	//Clear any cached data
	this.clear = function(key, onClear)
	{
		Wigbi.ajax("CacheHandler", this.getRequestObject(), "clear", [key], onClear);	
	};
	
	//Retrieve cached data
	this.get = function(key, onGet)
	{
		Wigbi.ajax("CacheHandler", this.getRequestObject(), "get", [key], onGet);	
	};
	
	//Get an object that can be used in asynchronous operations
	this.getRequestObject = function()
	{
		var obj = new CacheHandler();
		$.extend(obj, this);
		obj.cacheFolder("../../" + obj.cacheFolder());
		
		return obj;	
	};
	
	//Cache any serializable data
	this.set = function(key, data, validityTime, onSet)
	{
		Wigbi.ajax("CacheHandler", this.getRequestObject(), "set", [key, data, validityTime], onSet);	
	};
};