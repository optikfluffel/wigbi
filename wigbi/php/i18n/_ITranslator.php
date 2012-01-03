<?php

/**
 * The Wigbi ITranslator interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ITranslator interface.
 * 
 * This interface can be implemented by any class that can be used
 * to translage language keys.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Configuration
 * @version			2.0.0
 */
interface ITranslator
{
	/**
	 * Translate a certain language key.
	 * 
	 * @param	string	$key		The language key to translate.
	 * @param	string	$section	The language section, if any.
	 * @return	string
	 */
	function translate($key, $section = null);
}

?>