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
 * a [].
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.i18n
 * @version			2.0.0
 */
class FileBasedTranslator extends FileBasedConfiguration implements ITranslator
{
	/**
	 * @param	string				$filePath	The path to the language file that is to be parsed, if any.
	 * @param	IConfigFileReader	$fileReader	The file reader that should be used to read the config file.
	 */
	public function __construct($filePath, $fileReader)
	{
		parent::__construct($filePath, $fileReader);
	}
	
	
	
	/**
	 * Translate a certain language key.
	 * 
	 * @param	string	$key		The language key to translate.
	 * @param	string	$section	The language section, if any.
	 * @return	string
	 */
	public function translate($key, $section = null)
	{
		//Remove term from left to right until a translation is found
		$keys = explode("_", $key);
		while (sizeof($keys) > 0)
		{
			//Load the current key from the parent class
			$tmpKey = implode("_", $keys);
			$translation = parent::get($tmpKey, $section);
			
			//Return the translation, if any
			if ($translation)
				return $translation;
				
			//Remove the leftmost word and continue
			array_shift($keys);
		}
		
		return "[$key]";
	}
}

?>