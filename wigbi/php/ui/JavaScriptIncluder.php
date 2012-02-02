<?php

/**
 * The Wigbi JavaScriptIncluder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi JavaScriptIncluder class.
 * 
 * This class can be used to include CSS files to the page. It can
 * include both single and several files.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
class JavaScriptIncluder extends ClientFileIncluderBase implements IClientFileIncluder
{
	/**
	 * Include a certain file.
	 * 
	 * When using this method, use the full client url of the file.
	 * 
	 * @param	string	$filePath
	 */
	public function includeFile($path)
	{
		print "<script type=\"text/javascript\" src=\"$path\"></script>";
	}
}

?>