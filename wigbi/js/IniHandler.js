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
 * The Wigbi.JS.IniHandler class.
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
 * @subpackage	JS
 * @version			1.0.0
 */
function IniHandler(data)
{
	//Private variables
	this._data = data;


	//Inherit WigbiClass
	$.extend(this, new WigbiClass());
    

	//Get/set the currently loaded ini data
	this.data = function(newVal)
	{
		if (typeof(newVal) != "undefined")
			this._data = newVal;
		if (!this._data)
			return [];
		return this._data;
	};
	

	//Get a parameter from the currently loaded ini data
	this.get = function(parameter, section)
	{
		//Retrieve data from section, if any
		if (this._data.hasOwnProperty(section))
			if (this._data[section].hasOwnProperty(parameter))
				return this._data[section][parameter];
		
		//Retrieve data from plain parameter, if any
		if (this._data.hasOwnProperty(parameter))
			return this._data[parameter];
		
		//No data found
		return null;
	};
};