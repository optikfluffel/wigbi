<?php

/**
 * The Wigbi FakeFileIncluder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi FakeFileIncluder class.
 * 
 * This class can be used to fake file including, in test contexts
 * where mocking is not available (for instance when bootstrapping
 * Wigbi for test context).
 * 
 * It does nothing, and will be replaced by a mock instance in all
 * tests where an IFileIncluder is used.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		Tests.PHP.IO
 * @version			2.0.0
 */
class FakeFileIncluder
{
	public function includeFile($path) {}
	
	public function includeFileOnce($path) {}
	
	public function requireFile($path) {}
	
	public function requireFileOnce($path) {}
}

?>