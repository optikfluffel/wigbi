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
 * The Wigbi.JS.SearchFilter class.
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
function SearchFilter()
{
	//Private variables
	this._maxCount = 25;
	this._groupRules = [];
	this._searchRules = [];
	this._skipCount = 0;
	this._sortRules = [];


	//Inherit WigbiClass
	$.extend(this, new WigbiClass());
    

	//Get/set the search filter max count
	this.maxCount = function(newVal)
	{
		if (typeof(newVal) != "undefined")
			this._maxCount = newVal;
		return this._maxCount;
	};
	
	//Get/set the search filter group rules
	this.groupRules = function(newVal)
	{
		if (typeof(newVal) != "undefined")
			this._groupRules = newVal;
		if (!this._groupRules)
			return [];
		return this._groupRules;
	};
	
	//Get/set the search filter search rules
	this.searchRules = function(newVal)
	{
		if (typeof(newVal) != "undefined")
			this._searchRules = newVal;
		if (!this._searchRules)
			return [];
		return this._searchRules;
	};
	
	//Get/set the search filter skip count
	this.skipCount = function(newVal)
	{
		if (typeof(newVal) != "undefined")
			this._skipCount = newVal;
		return this._skipCount;
	};
	
	//Get/set the sort filter sort rules
	this.sortRules = function(newVal)
	{
		if (typeof(newVal) != "undefined")
			this._sortRules = newVal;
		if (!this._sortRules)
			return [];
		return this._sortRules;
	};
	

	//Add a group rule to the search filter
	this.addGroupRule = function(groupRule)
	{
		this._groupRules.push($.trim(groupRule));
	};
	
	//Add a search rule to the search filter
	this.addSearchRule = function(searchRule)
	{
		this._searchRules.push($.trim(searchRule));
	};
	
	//Add a sort rule to the sort filter
	this.addSortRule = function(sortRule)
	{
		this._sortRules.push($.trim(sortRule));
	};
	
	//Set the paging of the search filter
	this.setPaging = function(skipCount, maxCount)
	{
		this._skipCount = skipCount;
		this._maxCount = maxCount;
	};
	
	//Create a string out of the search filter
	this.toString = function() 
	{
		//Join the various arrays
		var searchRules = this.searchRules().join(" AND ");
		searchRules = searchRules.replace(/AND OR/g, "OR");
		var sortRules = this.sortRules().join(", ");
		var groupRules = this.groupRules().join(", ");
		
		//Build and return query
		var query  = searchRules ? "WHERE " + searchRules : "";
		query += sortRules ? " ORDER BY " + sortRules : "";
		query += groupRules ? " GROUP BY " + groupRules : "";
		query += " LIMIT " + this.skipCount() + "," + this.maxCount();
		return query;
	};
};