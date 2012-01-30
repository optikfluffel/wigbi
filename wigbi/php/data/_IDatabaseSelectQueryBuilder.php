<?php

/**
 * The Wigbi IDatabaseSelectQueryBuilder interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IDatabaseSelectQueryBuilder interface.
 * 
 * This interface can be implemented by any class that can be used
 * to build search queries for a database.
 * 
 * All methods except buildFor must return the query builder. This
 * enables that methods can be chained after eachother, which will
 * make composing the queries a lot simpler.
 * 
 * This interface is only meant to be used for basic queries. If a
 * JOIN or IN statement etc is needed, you are probably better off
 * writing your own query builder. 
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Data
 * @version			2.0.0
 */
interface IDatabaseSelectQueryBuilder
{
	/**
	 * Build the resulting query for a certain table.
	 * 
	 * @return	string
	 */
	function buildFor($tableName);
	
	/**
	 * Define which columns that are of interest.
	 * 
	 * @param	array	$list					A list of names to select, e.g. ["foo", "bar"].
	 * @return	IDatabaseSelectQueryBuilder		The resulting query builder.
	 */
	function select($list);
	
	/**
	 * Define which columns to sort on.
	 * 
	 * 
	 * @param	array	$columnName				The column to sort on.
	 * @param	array	$descending			  	Give this arg a positive value to apply descending sort.
	 * @return	IDatabaseSelectQueryBuilder		The resulting query builder.
	 */
	function sort($columnName, $descending);
	
	/**
	 * Define column filter conditions.
	 * 
	 * @param	array	$list					A list of filter conditions, e.g. ["foo=1", "bar=2"].
	 * @return	IDatabaseSelectQueryBuilder		The resulting query builder.
	 */
	function where($list);
}

?>