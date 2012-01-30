<?php

/**
 * Wigbi.PHP.SearchFilter class file.
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
 * The Wigbi.PHP.SearchFilter class.
 * 
 * This class can be used to build search filters that describes how
 * to search for objects in the database.
 * 
 * A search filter is built up by search rules, sort rules, group-by
 * rules skip count and max count, which makes it ideal to use for a
 * paging operation. 
 * 
 * The class is convenient to use to programmatically build queries,
 * but if you know how to write SQL queries, you will probably only
 * use it for more basic search operations.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 */
class SearchFilter
{	
	/**#@+
	 * @ignore
	 */
	private $_maxCount;
	private $_groupRules;
	private $_searchRules;
	private $_skipCount;
	private $_sortRules;
	/**#@-*/
	
	

	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	array	$searchRules	The search filter search rules.
	 * @param	array	$sortRules		The search filter sort rules.
	 * @param	array	$groupRules		The search filter group rules.
	 * @param	int		$maxCount			The search filter max count.
	 * @param	int		$skipCount		The search filter skip count.
	 */
	public function __construct($searchRules = array(), $sortRules = array(), $groupRules = array(), $maxCount = 25, $skipCount = 0)
	{
		$this->searchRules($searchRules);
		$this->sortRules($sortRules);
		$this->groupRules($groupRules);
		$this->maxCount($maxCount);
		$this->skipCount($skipCount);
	}
	
	
	
	/**
	 * Get/set the search filter max count.
	 * 
	 * The max count corresponds to the second LIMIT parameter in the
	 * search query. If skipCount is 10 and maxCount is 25, the LIMIT
	 * string will be "LIMIT 10, 25".
	 * 
	 * @access	public
	 * 
	 * @param		int	$value	Optional set value.
	 * @return	int					The search filter max count.
	 */
	public function maxCount($value = 25)
	{
		if(func_num_args() != 0)
			$this->_maxCount = func_get_arg(0);
		return $this->_maxCount;
	}
	
	/**
	 * Get/set the search filter group rules.
	 * 
	 * Group rules are strings that define the GROUP BY part of search
	 * query. For instance, an array with the elements ["name", "age"]
	 * will result in "GROUP BY name, age". 
	 * 
	 * @access	public
	 * 
	 * @param		array	$value	Optional set value.
	 * @return	array					The search filter group rules.
	 */
	public function groupRules($value = array())
	{
		if(func_num_args() != 0)
			$this->_groupRules = func_get_arg(0);
		return $this->_groupRules;
	}
	
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
	 * @param		array	$value	Optional set value.
	 * @return	array					The search filter search rules.
	 */
	public function searchRules($value = array())
	{
		if(func_num_args() != 0)
			$this->_searchRules = func_get_arg(0);
		return $this->_searchRules;
	}
	
	/**
	 * Get/set the search filter skip count.
	 * 
	 * The skip count corresponds to the first LIMIT parameter in the
	 * search query. If skipCount is 10 and maxCount is 25, the LIMIT
	 * string will be "LIMIT 10, 25".
	 * 
	 * @access	public
	 * 
	 * @param		int	$value	Optional set value.
	 * @return	int					The search filter skip count.
	 */
	public function skipCount($value = 0)
	{
		if(func_num_args() != 0)
			$this->_skipCount = func_get_arg(0);
		return $this->_skipCount;
	}
	
	/**
	 * Get/set the sort filter sort rules.
	 * 
	 * Sort rules are strings that define the ORDER BY part of search
	 * query. For instance, an array with the elements ["name", "age"]
	 * will result in "ORDER BY name, age".
	 * 
	 * @access	public
	 * 
	 * @param		array	$value	Optional set value.
	 * @return	array					The search filter sort rules.
	 */
	public function sortRules($value = array())
	{
		if(func_num_args() != 0)
			$this->_sortRules = func_get_arg(0);
		return $this->_sortRules;
	}
	
	
	
	/**
	 * Add a group rule to the search filter.
	 * 
	 * @access	public
	 * 
	 * @param	string	$groupRule	The group rule to add to the search filter.
	 */
	public function addGroupRule($groupRule)
	{
		array_push($this->_groupRules, trim($groupRule));
	}
	
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
	public function addSearchRule($searchRule)
	{
		array_push($this->_searchRules, trim($searchRule));
	}
	
	/**
	 * Add a sort rule to the search filter.
	 * 
	 * @access	public
	 * 
	 * @param	string	$sortRule	The sort rule to add to the search filter.
	 */
	public function addSortRule($sortRule)
	{
		array_push($this->_sortRules, trim($sortRule));
	}
	
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
	public function toString()
	{
		//Join the various arrays
		$searchRules = implode(" AND ", $this->searchRules());
		$searchRules = str_replace("AND OR", "OR", $searchRules);
		$sortRules = implode(", ", $this->sortRules());
		$groupRules = implode(", ", $this->groupRules());
		
		//Build and return query
		$query  = $searchRules ? "WHERE " . $searchRules : "";
		$query .= $sortRules ? " ORDER BY " . $sortRules : "";
		$query .= $groupRules ? " GROUP BY " . $groupRules : "";
		$query .= " LIMIT " . $this->skipCount() . "," . $this->maxCount();
		return $query;
	}
}

?>