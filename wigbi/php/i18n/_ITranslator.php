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
	 * If this method is called with one parameter, it will define
	 * the key and NOT the section. With two parameters, the first
	 * one will define the section and the section the key.
	 * 
	 * @param	string	$section	The configuration section, if any.
	 * @param	string	$key		The configuration key to retrieve.
	 * @return	string
	 */
	function translate($section, $key = null);
}

?>