<?php

/**
 * The Wigbi FileBasedConfiguration class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi FileBasedConfiguration class.
 * 
 * This class can be used to load and handle language data that is
 * kept in a file.
 * 
 * Language keys can consist of one or several parts. If a key has
 * one or several _ in its name, the _ will be used as a separator.
 * 
 * When the translator attempts to translate the key, it will take
 * all existing parts and attempt to translate them hierarchically.
 * 
 * For "foo_bar_foobar", the class will try all these translations
 * (in the given order):
 * 
 * <code>
 *	foo_bar_foobar=The most specific translation, returned first
 *	bar_foobar=Only returned if the above does not exist
 *	foobar=If none of the above keys exists, this will be returned
 * </code>
 * 
 * If no match is found, the class returns the key name wrapped in
 * a [], like [main_greeting].
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.i18n
 * @version			2.0.0
 */
class FileBasedTranslator extends ArrayBasedTranslator implements ITranslator
{
	/**
	 * @param	string				$filePath			The path to the language file that is to be parsed, if any.
	 * @param	IConfigFileReader	$configFileReader	The file reader that should be used to read the config file.
	 */
	public function __construct($filePath, $configFileReader)
	{
		$data = $configFileReader->readFile($filePath);
		parent::__construct($data);
	}
}

?>