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
 * This class can be used to validate whether or not a certain URL
 * actually exists. It will actually make a web request and should
 * therefore be used sparsely.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Validation
 * @version			2.0.0
 */
class UrlExistsValidator implements IValidator
{
	/**
	 * Check whether or not a certain URL exists.
	 * 
	 * @return	bool
	 */
	public function isValid($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}

?>