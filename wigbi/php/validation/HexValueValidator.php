<?php

/**
 * The Wigbi HexValueValidator class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi HexValueValidator class.
 * 
 * This class can be used to validate whether or not a string is a
 * valid hex value.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Validation
 * @version			2.0.0
 */
class HexValueValidator implements IValidator
{
	public static $expression = '/^#(?:(?:[a-fd]{3}){1,2})$/i';
	
	
	/**
	 * Check if a string is a valid hex value.
	 * 
	 * @return	bool
	 */
	public function isValid($str)
	{
		return preg_match(HexValueValidator::$expression, $str);
	}
}

?>