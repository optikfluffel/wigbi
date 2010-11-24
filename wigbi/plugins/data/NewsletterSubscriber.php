<?php
/**
 * Wigbi.Plugins.Data.NewsletterSubscriber class file.
 *
 * Wigbi is free software. You can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wigbi is distributed in the hope that it will be useful, but WITH
 * NO WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public
 * License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wigbi. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The Wigbi.Plugins.Data.NewsletterSubscriber class.
 *
 * This class represents a newsletter subscriber, which is really no
 * more than an e-mail address.
 *
 * The newsletterId property can also be used as an object reference
 * to provide fully traceable newsletter subscribers.
 *
 *
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class NewsletterSubscriber extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_email = "__50";
	public $_newsletterId = "__GUID";
	/**#@-*/

	
	public function __construct()
	{
		parent::__construct();
	}


	public function email($value = "")
	{
		if (func_num_args() != 0)
			$this->_email = func_get_arg(0);
		return $this->_email;
	}

	public function newsletterId($value = "")
	{
		if (func_num_args() != 0)
			$this->_newsletterId = func_get_arg(0);
		return $this->_newsletterId;
	}


	public function validate()
	{
		//Init error list
		$errorList = array();

		//Require a valid e-mail address
		if (!trim($this->email()))
			array_push($errorList, "email_required");
		else if (!ValidationHandler::isEmail($this->email()))
			array_push($errorList, "email_invalid");
			
		//Return error list
		return $errorList;
	}
}
?>