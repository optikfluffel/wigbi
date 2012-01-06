<?php
/**
 * Wigbi.PHP.Controls.UserRegistrationForm class file.
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
 * The UserRegistrationForm control class.
 * 
 * This control can be used to register new users. It requires that
 * a unique user name and e-mail address are used and will e-mail a
 * random password to the user once the registration is complete.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the User seed.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * UserRegistrationForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string email()</li>
 * 		<li>public void setEmail(string newVal)</li>
 * 		<li>public string userName()</li>
 * 		<li>public void setUserName(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string messageFile, string subject, string fromMail, string targetElementId, function onAdd)</li>
 * 		<li>[ASYNC] public void submit()</li>
 * 		<li>public void reset()</li>
 * 		<li>[ASYNC] public static void registerUser(string userName, string email, bool onRegisterUser)</li>
 * 	</ul>
 * 
 * Events:
 *	<ul>
 * 		<li>public bool onPreSubmit(element form)</li>
 * 		<li>public void onSubmit()</li>
 * 		<li>public void onSubmitError(array errorList)</li>
 * 	</ul>
 * 
 * Override onPreSubmit to set what to do before the form is being
 * submitted. If it returns false, the submit operation will abort.
 * Override onSubmit and onSubmitError to set what to do when the
 * submit operation succeeds or fails.
 * 
 * 
 * LANGUAGE CONTROL **************
 * 
 * The following language parameters are used by the control:
 * 
 *	<ul>
 * 		<li>[controlId] UserRegistrationForm email</li>
 * 		<li>[controlId] UserRegistrationForm emailExists</li>
 * 		<li>[controlId] UserRegistrationForm emailInvalid</li>
 * 		<li>[controlId] UserRegistrationForm emailRequired</li>
 * 		<li>[controlId] UserRegistrationForm mailError</li>
 * 		<li>[controlId] UserRegistrationForm messageFileInvalid</li>
 * 		<li>[controlId] UserRegistrationForm reset</li>
 * 		<li>[controlId] UserRegistrationForm submit</li>
 * 		<li>[controlId] UserRegistrationForm submitError</li>
 * 		<li>[controlId] UserRegistrationForm submitErrorMessage</li>
 * 		<li>[controlId] UserRegistrationForm submitMessage</li>
 * 		<li>[controlId] UserRegistrationForm submitted</li>
 * 		<li>[controlId] UserRegistrationForm submitting</li>
 * 		<li>[controlId] UserRegistrationForm userName</li>
 * 		<li>[controlId] UserRegistrationForm userNameExists</li>
 * 		<li>[controlId] UserRegistrationForm userNameRequired</li>
 * 	</ul>
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.9
 * @version		0.99.2
 */
class UserRegistrationForm extends BaseControl
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
		//Register the general JavaScript
		$this->registerJavaScript(@"
UserRegistrationForm = Class({ Extends: BaseControl,
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Bind form submit event
		var _this = this;
		this.form().onsubmit = function() { _this.submit(); return false; };
	},
	
	
	/* Properties *************/
	
	//Get/set the e-mail address
	email: function() { return this.form().email.value; },
	setEmail: function(newVal) { this.form().email.value = newVal; },
	
	// Get/set the e-mail address of the user
	fromMail: function() { return this.form().fromMail.value; },
	setFromMail: function(newVal) { this.form().fromMail.value = newVal; },
	
	// Get/set the application relative path to the file that contains the e-mail message template.
	messageFile: function() { return this.form().messageFile.value; },
	setMessageFile: function(newVal) { this.form().messageFile.value = newVal; },
	
	// Get/set the application relative mail template file
	subject: function() { return this.form().subject.value; },
	setSubject: function(newVal) { this.form().subject.value = newVal; },
	
	//Get/set the user name
	userName: function() { return this.form().userName.value; },
	setUserName: function(newVal) { this.form().userName.value = newVal; },
	
	
	/* Functions **************/
	
	//Reset the control
	reset: function()
	{
		this.form().reset.click();
	},
	
	//Submit the control form
	submit: function()
	{			
		//Create private variables
		var _this = this;
		var form = this.form();
		
		//Raise the onPreSubmit event
		if (!this.onPreSubmit())
			return false;
		
		//Disable the submit button
		form.submit.disabled = true;
		form.submit.value = LanguageHandler.translate(this.controlId() + ' UserRegistrationForm submitting') + '...';
		
		//Try to register the user
		UserRegistrationForm.registerUser(this.messageFile(), this.subject(), this.fromMail(), this.userName(), this.email(), function(errorList)
		{	
			//Raise the onValidate event
			_this.onValidate(errorList);
			
			//Handle any possible errors
			if (errorList.length > 0)
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' UserRegistrationForm submitError');
				
				//Raise the onSubmitError event
				_this.onSubmitError(errorList);
			}
			else
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' UserRegistrationForm submitted');
				
				//Raise the onSubmit event
				_this.onSubmit();
					
				//Reset the form
				_this.reset();
			}
						
			//Enable the submit button and set final event
			form.submit.disabled = false;
			setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' UserRegistrationForm submit'); }, 1000);
		});
	},
		
	
	/* Events ***********/
	
	//Raised before the form is submitted
	onPreSubmit: function(form) { return true; },
	
	//Raised when the control is correctly submitted
	onSubmit: function()
	{
		alert(LanguageHandler.translate(this.controlId() + ' UserRegistrationForm submitMessage'));
	},
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList)
	{
		var message = LanguageHandler.translate(this.controlId() + ' UserRegistrationForm submitErrorMessage') + ':\\n';
		for (var i=0; i<errorList.length; i++)
			message += '   ' + LanguageHandler.translate(this.controlId() + ' UserRegistrationForm ' + errorList[i]) + '\\n';
		alert(message);
	},
	
	//Raised when the control has been validated 
	onValidate: function(errorList)
	{
		this.bindValidationResult('UserRegistrationForm', ['userName', 'email'], errorList);
	}
});


/* Static functions ********/

//Add a new control instance to the page
UserRegistrationForm.add = function(controlId, messageFile, subject, fromMail, targetElementId, onAdd)
{
	Wigbi.executeFunction('UserRegistrationForm', null, 'add', [controlId, messageFile, subject, fromMail], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new UserRegistrationForm(controlId);
		
		//Raise the onAadd event
		if (onAdd)
			onAdd();
	});
};

//Try to register a new user
UserRegistrationForm.registerUser = function(messageFile, subject, fromMail, userName, email, onRegisterUser)
{
	Wigbi.executeFunction('UserRegistrationForm', null, 'registerUser', [messageFile, subject, fromMail, userName, email], onRegisterUser); 
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a UserRegistrationForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId		The unique control ID.
	 * @param	string	$messageFile	The application relative path to the message template file.
	 * @param	string	$subject		The subject of the e-mail.
	 * @param	string	$fromMail		The e-mail address that will be specified as the sender.
	 */
	public static function add($controlId, $messageFile, $subject, $fromMail)
	{
		BaseControl::openForm("UserRegistrationForm", $controlId);
		?>
			<input type="hidden" id="<?php print $controlId ?>-messageFile" name="messageFile" value="<?php print $messageFile ?>" />
			<input type="hidden" id="<?php print $controlId ?>-subject" name="subject" value="<?php print $subject ?>" />
			<input type="hidden" id="<?php print $controlId ?>-fromMail" name="fromMail" value="<?php print $fromMail ?>" />
			
			<div class="control-body">
				<div class="userName">
					<?php print LanguageHandler::translate("$controlId UserRegistrationForm userName") ?>:<br/>
					<input type="text" id="<?php print $controlId ?>-userName" name="userName" value="" />
				</div>
				<div class="email">
					<?php print LanguageHandler::translate("$controlId UserRegistrationForm email");?>:<br/>
					<input type="text" id="<?php print $controlId ?>-email" name="email" value="" />
				</div>
			</div>
			<div class="control-footer">
				<input type="reset" id="<?php print $controlId ?>-reset" name="reset" value="<?php print LanguageHandler::translate("$controlId UserRegistrationForm reset"); ?>" />
				<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate("$controlId UserRegistrationForm submit"); ?>" />
			</div>
			
			<script type="text/javascript">
				new UserRegistrationForm("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
	
	/**
	 * Try to register a new user, which requires a unique user name.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$messageFile	The application relative path to the message template file.
	 * @param	string	$subject		The subject of the e-mail.
	 * @param	string	$fromMail		The e-mail address that will be specified as the sender.
	 * @param	string	$userName		The desired user name.
	 * @param	string	$email			The user's e-mail address.
	 * @return	array					A list of error codes; empty if no error occured.
	 */
	public static function registerUser($messageFile, $subject, $fromMail, $userName, $email)
	{
		//Init result
		$result = array();
		
		//Abort if the mail body template file does not exist
		if (!is_file(Wigbi::serverRoot() . $messageFile))
			return array("messageFileInvalid");

		//Check so that all values are set
		if (!trim($userName))
			array_push($result, "userNameRequired");
		if (!trim($email))
			array_push($result, "emailRequired");
		else if (!ValidationHandler::isEmail($email))
			array_push($result, "emailInvalid");
			
		//Abort if any errors have been fetched
		if (sizeof($result) > 0)
			return $result;
			
		//Check if a user with the user name exists
		$user = new User();
		$user->loadBy("userName", $userName);
		if ($user->id())
			return array("userNameExists");

		//Check if a user with the e-mail address exists
		$user = new User();
		$user->loadBy("email", $email);
		if ($user->id())
			return array("emailExists");
		
		//Open and read mail body template file
		$mailBody = "";
		$file = fopen(Wigbi::serverRoot() . $messageFile, "r");
		$mailBody = fread($file, filesize(Wigbi::serverRoot() . $messageFile));
		fclose($file);	
			
		//Create the user and generate a random password
		$user = new User();
		$user->setUserName(trim($userName));
		$user->setEmail(trim($email));
		$password = strrev(substr(sha1(sha1($userName)), 12, 10));
		$user->setPassword($password);
		$user->save();
		
		//Replace mail body variables
		$mailBody = str_replace("[userName]", $user->userName(), $mailBody);
		$mailBody = str_replace("[password]", $password, $mailBody);
		
		//Try to send the mail
		if (!mail($email, $subject, $mailBody, "From: " . $fromMail))
			return array("mailError");
			
		//Return success
		return array();
	}
}
?>