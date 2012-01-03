<?php

/**
 * The Wigbi IValidator interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IValidator interface.
 * 
 * This interface can be implemented by any class that can be used
 * to validate a certain condition.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.IO
 * @version			2.0.0
 */
interface IValidator
{	
	/**
	 * Validate a certain object.
	 * 
	 * @return	bool
	 */
	function isValid($obj);
}

?>