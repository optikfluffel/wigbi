<?php

/**
 * Wigbi IController interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IController interface.
 * 
 * This interface can be implemented by any class that can be used
 * as a basic MVC controller. 
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.MVC
 * @version			2.0.0
 */
interface IController
{
	/**
	 * Call a certain controller action.
	 * 
	 * The action name must represent a method that is defined for
	 * the executing controller.
	 * 
	 * @return	mixed	Action result.
	 */
	function action($actionName);
}

?>