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
 * This class can be used to handle configuration data that can be
 * loaded from a file.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Configuration
 * @version			2.0.0
 */
class FileBasedConfiguration extends ArrayBasedConfiguration implements IConfiguration
{
	/**
	 * @param	string				$filePath			The path to the config file that is to be parsed, if any.
	 * @param	IConfigFileReader	$configFileReader	The file reader that should be used to read the config file.
	 */
	public function __construct($filePath, $configFileReader)
	{
		$data = $configFileReader->readFile($filePath);
		parent::__construct($data);
	}
}

?>