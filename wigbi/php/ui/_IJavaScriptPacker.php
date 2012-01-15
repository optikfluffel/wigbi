<?php

/**
 * The Wigbi IJavaScriptPacker interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IJavaScriptPacker interface.
 * 
 * This interface can be implemented by any class that can be used
 * to pack (compress) JavaScript code into compressed code.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.UI
 * @version			2.0.0
 */
interface IJavaScriptPacker
{
	/**
	 * Compress JavaScript code into compressed (yet still runnable) code. 
	 */
	function pack();
}

?>