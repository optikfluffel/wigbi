<?php
/**
 * Wigbi.Plugins.Data.User class file.
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
 * The Wigbi.Plugins.Data.User class.
 * 
 * This class represents a general system user with basic properties.
 * It supports logging in and out with a SHA1 encrypted password and
 * setting (really basic) administrator privileges.
 * 
 * The password property automatically SHA1 encrypts a password when
 * it is set, so there is no need to handle encryption manually.
 * 
 * The class defines some data lists, but they are disabled to avoid
 * unnecessary database tables. Just uncomment them to use them, but
 * make sure that you have added the required plugin classes first.
 * 
 * 
 * DATA LISTS ********************
 * 
 * The class has the following data lists: 
 * 
 * 	<ul>
 * 		<li>files (File) - synced/disabled</li>
 * 		<li>friends (User) - non-synced/disabled</li>
 * 		<li>guestbookEntries (GuestbookEntry) - synced/disabled</li>
 * 		<li>images (ImageFile) - synced/disabled</li>
 * 	</ul>
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * The class has the following AJAX functions, besides the ones that
 * are provided by the WigbiDataPlugin JavaScript base class:
 * 
 *	<ul>
 * 		<li>public static void getCurrentUser(function onGetCurrentUser(User result))</li>
 * 		<li>public void isLoggedIn(function onIsLoggedIn(bool result))</li>
 * 		<li>public static void login(string userName, string password, function onLogin(bool result))</li>
 * 		<li>public static void logout(function onLogout(bool result))</li>
 * 	</ul>
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.Data
 * @version			1.0.0
 */
class User extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_userName = "__20";
	public $_password = "__40";
	public $_email = "__100";
	public $_firstName = "__30";
	public $_lastName = "__30";
	public $_isAdmin = false;
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
		
		//$this->registerList("files", "File", true, "fileName");
		//$this->registerList("friends", "User", false, "userName");
		//$this->registerList("guestbookEntries", "GuestbookEntry", true, "createdDateTime");
		//$this->registerList("images", "ImageFile", true, "fileName");
		
		$this->registerAjaxFunction("getCurrentUser", array(), true);
		$this->registerAjaxFunction("isLoggedIn", array(), false);
		$this->registerAjaxFunction("login", array("userName","password"), true);
		$this->registerAjaxFunction("logout", array(), true);
	}
	
	
	public function email($value = "")
	{
		if (func_num_args() != 0)
			$this->_email = func_get_arg(0);
		return $this->_email;
	}
	
	public function firstName($value = "")
	{
		if (func_num_args() != 0)
			$this->_firstName = func_get_arg(0);
		return $this->_firstName;
	}
	
	public function isAdmin($value = false)
	{
		if (func_num_args() != 0)
			$this->_isAdmin = func_get_arg(0);
		return $this->_isAdmin;
	}
	
	public function lastName($value = "")
	{
		if (func_num_args() != 0)
			$this->_lastName = func_get_arg(0);
		return $this->_lastName;
	}
	
	public function password($value = "")
	{
		if (func_num_args() != 0)
			$this->_password = (strlen(func_get_arg(0)) < 40) ? sha1(func_get_arg(0)) : func_get_arg(0); 
		return $this->_password;
	}

	public function userName($value = "")
	{
		if (func_num_args() != 0)
			$this->_userName = func_get_arg(0);
		return $this->_userName;
	}
	
		
	/**
	 * Get the currently logged in user, if any.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	reload	Whether or not to reload the user from the database; false by default. 
	 * @return	User	The currently logged in user, if any
	 */
	public static function getCurrentUser($reload = false)
	{
		//Create a blank user
		$user = new User();
		
		//Return a blank user if none is stored in session
		if (!Wigbi::sessionHandler()->get("User.currentUser"))
			return $user;

		//Parse the logged in user
		$user = Wigbi::sessionHandler()->get("User.currentUser");
		
		//Reload the user if the reload parameter is true
		if ($reload)
		{
			$user->load($user->id());
			Wigbi::sessionHandler()->set("User.currentUser", $user);
		}	
			
		//Return the user
		return $user;
	}
	
	/**
	 * Check whether or not the user is logged in.
	 * 
	 * @access	public
	 * 
	 * @return	bool	Whether or not the user is logged in
	 */
	public function isLoggedIn()
	{
		if (!$this->id())
			return false;
		return $this->id() == User::getCurrentUser(false)->id();
	}
	
	/**
	 * Attempt to login with a certain user.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		string	$userName	User name.
	 * @param		string	$password	User password.
	 * @return	bool							Whether or not the operation succeeded.
	 */
	public static function login($userName, $password)
	{
		//Init exceptions
		$exceptions = array();
		
		//Require userName and password
		if (!trim($userName))
			array_push($exceptions, "userName_required");
		if (!trim($password))
			array_push($exceptions, "password_required");
		
		//Throw any exceptions
		if (sizeof($exceptions) > 0)
			throw new Exception(implode(",", $exceptions));
		
		//Try to load the user
		$tmpUser = new User();
		$tmpUser->loadBy("userName", $userName);
				
		//Login and return true if the correct password is given
		if ($tmpUser->password() == sha1($password))
		{
			Wigbi::sessionHandler()->set("User.currentUser", $tmpUser);
			return true;
		}
		
		//By default return false
		return false;
	}
	
	/**
	 * Logout the currently logged in user.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @return	bool		Whether or not the operation succeeded.
	 */
	public static function logout()
	{
		Wigbi::sessionHandler()->set("User.currentUser", null);
		return true;
	}
	
	/**
	 * Validate the object.
	 * 
	 * @access	public
	 * 
	 * @return	array	Error list; empty if valid.
	 */
	public function validate()
	{
		//Init error list
		$errorList = array();
		
		//Require a user name
		if (!trim($this->userName()))
			array_push($errorList, "userNameRequired");
		
		//Require a valid e-mail address if one is defined
		if ($this->email() && !ValidationHandler::isEmail($this->email()))
			array_push($errorList, "emailInvalid");
			
		//Return error list
		return $errorList;
	}
}
?>