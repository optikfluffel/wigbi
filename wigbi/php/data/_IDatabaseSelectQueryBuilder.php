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
	 * @param	array	$list					A list of names to select.
	 * @return	IDatabaseSelectQueryBuilder		The resulting query builder.
	 */
	function select($list);
}

?>