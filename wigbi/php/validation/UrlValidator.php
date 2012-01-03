<?php

/**
 * The Wigbi UrlValidator class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi UrlValidator class.
 * 
 * This class can be used to validate whether or not a string is a
 * valid URL.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Validation
 * @version			2.0.0
 */
class UrlValidator implements IValidator
{
	public static $expression = '/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i';
	
	
	/**
	 * Validate a certain object.
	 * 
	 * @return	bool
	 */
	public function isValid($obj)
	{
		return preg_match(UrlValidator::$expression, $obj);
	}
}

?>