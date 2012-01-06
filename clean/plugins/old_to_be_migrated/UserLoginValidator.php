<?php
/**
 * Wigbi.PHP.Controls.UserLoginValidator class file.
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
 * The UserLoginValidator control class.
 * 
 * This control can be used to automatically redirect unauthorized
 * visitors from a validation protected page to another URL.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions, but is not added to the Wigbi control collection.
 * It requires the User seed.
 * 
 * The control requires a logged in user, using the built-in login
 * functionality of the User seed. Additional constraints can also
 * be set with the validationExpressions property. For instance, a
 * page can be restricted to administrators with an authorization
 * level above 5, by setting the validationExpressions property to
 * ["isAdministrator()", "authorityLevel() > 5"], provided that the
 * User seed has an authorityLevel property.
 * 
 * Besides validating the user when the page first loads, it is also
 * possible to apply a validation interval that revalidates the user
 * at a given interval. This makes it possible for a page to logout
 * a user automatically as soon a the login session expires. Disable
 * this feature by setting the interval to 0 or less.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * Functions:
 *	<ul>
 * 		<li>public static void add(string redirectPage, int validationInterval, array validationExpressions)</li>
 * 		<li>[ASYNC] public static void validate(string redirectPage, array validationExpressions)</li>
 * 	</ul>
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.99.3
 * @version		0.99.3
 */
class UserLoginValidator extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the control.
	 * 
	 * This constructor is only intended to be used by Wigbi at startup.
	 * 
	 * @access	public
	 */
	public function __construct()
	{
		//Register the general JavaScript control code
		$this->registerJavaScript(@"
UserLoginValidator = Class({});


/* Static functions ********/

//Add a UserLoginValidator control to the page
UserLoginValidator.add = function(redirectPage, validationInterval, validationExpressions)
{
	//Perform a start validation
	UserLoginValidator.validate(redirectPage, validationExpressions);
	
	//If an interval time is given, apply the interval
	if (validationInterval > 0)
		setInterval(function() { UserLoginValidator.validate(redirectPage, validationExpressions) }, validationInterval * 60 * 1000);
};

//Perform an AJAX-based login validation
UserLoginValidator.validate = function(redirectPage, validationExpressions)
{
	//Old handling since when null could not be sent
	var params = [];
	if (validationExpressions)
		params = [validationExpressions];
	
	//Perform an async validation
	Wigbi.executeFunction('UserLoginValidator', null, 'validate', params, function(result)
	{
		if (!result)
			location.href = redirectPage;
	});				
};");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a UserLoginValidator control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$redirectPage			The page to redirect to upon a successful login; default null.
 	 * @param	int		$validationInterval		The time, in minutes, between each AJAX validation; default 5.
	 * @param	array	$validationExpressions	Optional validation expressions; default null.
	 */
	public static function add($redirectPage = null, $validationInterval = 5, $validationExpressions = null)
	{
		//Perform an initial validation
		if (!UserLoginValidator::validate($validationExpressions))
			JavaScript::redirect($redirectPage);
			
		//Add the JavaScript validator
		if ($validationInterval > 0) {?>
			<script type="text/javascript">
				UserLoginValidator.add('<?php print $redirectPage; ?>' , <?php print $validationInterval; ?>, <?php print json_encode($validationExpressions); ?>);
			</script>
		<?php }
	}
	
	/**
	 * Validate the current login status.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	array	$validationExpressions	The optional validation expressions to apply to the validation; default null.
	 * @return	bool
	 */
	public static function validate($validationExpressions = null)
	{
		//Get the current user, abort if none
		$user = User::getCurrentUser();
		if (!$user->id())
			return false;
	
		//Handle any validation expressions
		if ($validationExpressions)
		{
			LogHandler::log(json_encode($validationExpressions));
			foreach ($validationExpressions as $expression)
			{
				eval('$result=$user->' . $expression . ";");
				if (!$result)
					return false;
			}
		}
		
		//If here, the validation is successful
		return true;
	}
}
?>