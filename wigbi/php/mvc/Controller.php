<?php

/**
 * Wigbi Controller class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi Controller class.
 * 
 * This abstract base class represents an MVC controller, that can
 * be used to handle request made to the server.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.MVC
 * @version			2.0.0
 */
abstract class Controller implements IController
{
	/**
	 * Call a certain action and return the result.
	 * 
	 * The action name must represent a method that is defined for
	 * the executing controller.
	 * 
	 * @return	mixed
	 */
	function action($actionName)
	{
		eval('$result = $this->'. $actionName . '();');
		return $result;
	}
}

?>