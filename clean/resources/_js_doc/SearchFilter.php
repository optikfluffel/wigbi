<?php
/**
 * Wigbi.JS.SearchFilter class file.
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
 * The Wigbi.JS.SearchFilter class.
 * 
 * This class can be used to build search filters that describes how
 * to search for objects in the database.
 * 
 * See the documentation for the corresponding PHP class for further
 * information about how to work with search filters.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 */
class SearchFilter_ extends WigbiClass_
{
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 */
	public function __construct() { }
	
	
	
	/**
	 * Get/set the search filter max count.
	 * 
	 * The max count corresponds to the second LIMIT parameter in the
	 * search query. If skipCount is 10 and maxCount is 25, the LIMIT
	 * string will be "LIMIT 10, 25".
	 * 
	 * @access	public
	 * 
	 * @param	int	$value	Optional set value.
	 * @return	int			The search filter max count.
	 */
	public function maxCount($value) { return 0; }
	
	/**
	 * Get/set the search filter group rules.
	 * 
	 * Group rules are strings that define the GROUP BY part of search
	 * query. For instance, an array with the elements ["name", "age"]
	 * will result in "GROUP BY name, age". 
	 * 
	 * @access	public
	 * 
	 * @param	array	$value	Optional set value.
	 * @return	array			The search filter group rules.
	 */
	public function groupRules($value) { return array(); }
	
	/**
	 * Get/set the search filter search rules.
	 * 
	 * Search rules are strings that define the first part of the query.
	 * For instance, an array with the elements ["name='Foo'", "age=10"]
	 * will result in a search filter that begins with "WHERE name='Foo'
	 * AND age=10".
	 * 
	 * Remember to add OR before a search rule if you want it to use OR.
	 * If a search rule does not start with OR, the filter will use AND.
	 * 
	 * @access	public
	 * 
	 * @param	array	$value	Optional set value.
	 * @return	array			The search filter search rules.
	 */
	public function searchRules($value) { }
	
	/**
	 * Get/set the search filter skip count.
	 * 
	 * The skip count corresponds to the first LIMIT parameter in the
	 * search query. If skipCount is 10 and maxCount is 25, the LIMIT
	 * string will be "LIMIT 10, 25".
	 * 
	 * @access	public
	 * 
	 * @param	int	$value	Optional set value.
	 * @return	int			The search filter skip count.
	 */
	public function skipCount($value) { }
	
	/**
	 * Get/set the sort filter sort rules.
	 * 
	 * Sort rules are strings that define the ORDER BY part of search
	 * query. For instance, an array with the elements ["name", "age"]
	 * will result in "ORDER BY name, age".
	 * 
	 * @access	public
	 * 
	 * @param	array	$value	Optional set value.
	 * @return	array			The search filter sort rules.
	 */
	public function sortRules($value = array()) { return array(); }
	
	
	
	/**
	 * Add a group rule to the search filter.
	 * 
	 * @access	public
	 * 
	 * @param	string	$groupRule	The group rule to add to the search filter.
	 */
	public function addGroupRule($groupRule) { }
	
	/**
	 * Add a search rule to the search filter.
	 * 
	 * Remember to add OR before a search rule if you want it to use OR.
	 * If a search rule does not start with OR, the filter will use AND.
	 * 
	 * @access	public
	 * 
	 * @param	string	$searchRule	The search rule to add to the search filter.
	 */
	public function addSearchRule($searchRule) { }
	
	/**
	 * Add a sort rule to the search filter.
	 * 
	 * @access	public
	 * 
	 * @param	string	$sortRule	The sort rule to add to the search filter.
	 */
	public function addSortRule($sortRule) { }
	
	/**
	 * Set the paging of the search filter.
	 * 
	 * The paging components can also be set with maxCount and skipCount.
	 * 
	 * @access	public
	 * 
	 * @param	int	$skipCount	The number of rows to skip before starting to retrieve objects.
	 * @param	int	$maxCount	The maximum number of objects to retrieve.
	 */
	public function setPaging($skipCount, $maxCount) { }
	
	/**
	 * Create a string out of the search filter.
	 * 
	 * Note that the search filter only defines HOW to search for items
	 * in the database, not WHICH tables to search in or WHAT to select.
	 * 
	 * @access	public
	 * 
	 * @return	string	The resulting search filter string.
	 */
	public function toString() { return ""; }
}
?>