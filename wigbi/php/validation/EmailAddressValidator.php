<?php

/**
 * The Wigbi EmailValidator class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi EmailValidator class.
 * 
 * This class can be used to validate whether or not a string is a
 * valid e-mail address.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Validation
 * @version			2.0.0
 */
class EmailAddressValidator implements IValidator
{
	public static $expression = '/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is';
	
	
	/**
	 * Validate a certain object.
	 * 
	 * @return	bool
	 */
	public function isValid($obj)
	{
		return preg_match(EmailAddressValidator::$expression, $obj);
	}
}

?>