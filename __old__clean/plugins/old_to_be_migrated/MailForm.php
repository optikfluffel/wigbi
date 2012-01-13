<?php
/**
 * Wigbi.PHP.Controls.MailForm class file.
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
 * The MailForm control class.
 * 
 * This control can be used to send e-mail messages to one recipient
 * directly from a web site. 
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * MailForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string fromMail()</li>
 * 		<li>public void setFromMail(string newVal)</li>
 * 		<li>public string message()</li>
 * 		<li>public void setMessage(string newVal)</li>
 * 		<li>public string subject()</li>
 * 		<li>public void setSubject(string newVal)</li>
 * 		<li>public string toMail()</li>
 * 		<li>public void setToMail(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string toMail, string targetElementId, function onAdd())</li>
 * 		<li>public void reset()</li>
 * 		<li>[ASYNC] public static void sendMail(string toMail, string fromMail, string subject, string message, function onSendMail(string[] errorCodes))</li>
 * 		<li>[ASYNC] public void submit()</li>
 * 	</ul>
 * 
 * Events:
 *	<ul>
 * 		<li>public bool onPreSubmit()</li>
 * 		<li>public void onSubmit()</li>
 * 		<li>public void onSubmitError(string[] errorList)</li>
 * 		<li>public void onValidate(string[] errorList)</li>
 * 	</ul>
 * 
 * Override onPreSubmit to set what to do before the form is being
 * submitted. If it returns false, the submit operation will abort.
 * 
 * Override onSubmit to set what to do when the submit operation
 * has finished. By default, it alerts that the mail has been sent.
 * 
 * Override onSubmitError to set what to do when a submit operation
 * fails. By default, it alerts all errors in the error list.
 * 
 * Override onValidate to set what to do when the object has been
 * validated. By default, it binds the result to the form.
 * 
 * 
 * LANGUAGE HANDLING *************************
 *  
 * The following language parameters are used by the control:
 * 
 *	<ul>
 * 		<li>[controlId] MailForm fromMail</li>
 * 		<li>[controlId] MailForm fromMailInvalid</li>
 * 		<li>[controlId] MailForm fromMailRequired</li>
 * 		<li>[controlId] MailForm mailError</li>
 * 		<li>[controlId] MailForm message</li>
 * 		<li>[controlId] MailForm messageRequired</li>
 * 		<li>[controlId] MailForm reset</li>
 * 		<li>[controlId] MailForm subject</li>
 * 		<li>[controlId] MailForm subjectRequired</li>
 * 		<li>[controlId] MailForm toMailInvalid</li>
 * 		<li>[controlId] MailForm toMailRequired</li>
 * 		<li>[controlId] MailForm submit</li>
 * 		<li>[controlId] MailForm submitError</li>
 * 		<li>[controlId] MailForm submitErrorMessage</li>
 * 		<li>[controlId] MailForm submitMessage</li>
 * 		<li>[controlId] MailForm submitted</li>
 * 		<li>[controlId] MailForm submitting</li>
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
class MailForm extends BaseControl
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
MailForm = Class({ Extends: BaseControl,
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Bind form submit event
		var _this = this;
		this.form().onsubmit = function() { _this.submit(); return false; };
		
		//Remove any default text in the textarea
		this.setMessage('');
	},
	
	
	/* Properties *************/
	
	//Get/set the sender mail addresses
	fromMail: function() { return this.form().fromMail.value; },
	setFromMail: function(newVal) { this.form().fromMail.value = newVal; },
	
	//Get/set the mail message
	message: function() { return this.form().message.value; },
	setMessage: function(newVal) { this.form().message.value = newVal; },
	
	//Get/set the mail subject
	subject: function() { return this.form().subject.value; },
	setSubject: function(newVal) { this.form().subject.value = newVal; },
	
	//Get/set the recipient mail addresses
	toMail: function() { return this.form().toMail.value; },
	setToMail: function(newVal) { this.form().toMail.value = newVal; },
	
	
	/* Functions **************/
	
	//Reset the control form
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
		form.submit.value = LanguageHandler.translate(this.controlId() + ' MailForm submitting') + '...';
	
		//Send the mail and a copy
		MailForm.sendMail(this.toMail(), this.fromMail(), this.subject(), this.message(), function(errorList)
		{	
			//Raise the onValidate event
			_this.onValidate(errorList);
			
			//Handle any possible errors
			if (errorList.length > 0)
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' MailForm submitError');
				
				//Raise the onSubmitError event
				_this.onSubmitError(errorList);
			}
			else
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' MailForm submitted');
				
				//Raise the onSubmit event
				_this.onSubmit();
					
				//Reset the form
				_this.reset();
			}
						
			//Enable the submit button and set final event
			form.submit.disabled = false;
			setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' MailForm submit'); }, 1000);
		});
	},
	
	
	/* Events ***********/
	
	//Raised before the form is submitted
	onPreSubmit: function(form) { return true; },
	
	//Raised when the control is correctly submitted
	onSubmit: function()
	{
		alert(LanguageHandler.translate(this.controlId() + ' MailForm submitMessage'));
	},
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList)
	{
		var message = LanguageHandler.translate(this.controlId() + ' MailForm submitErrorMessage') + ':\\n';
		for (var i=0; i<errorList.length; i++)
			message += '   ' + LanguageHandler.translate(this.controlId() + ' MailForm ' + errorList[i]) + '\\n';
		alert(message);
	},
	
	//Raised when the control has been validated 
	onValidate: function(errorList)
	{
		this.bindValidationResult('MailForm', ['fromMail', 'message', 'subject'], errorList);
	}
});


/* Static functions ********/

//Add a new control instance to the page with AJAX
MailForm.add = function(controlId, toMail, targetElementId, onAdd)
{
	Wigbi.executeFunction('MailForm', null, 'add', [controlId, toMail], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new MailForm(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};

//Send a mail without submitting any MailForm
MailForm.sendMail = function(toMail, fromMail, subject, message, onSendMail)
{
	Wigbi.executeFunction('MailForm', null, 'sendMail', [toMail, fromMail, subject, message], onSendMail);
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a MailForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId	The unique control ID.
	 * @param	string	$toMail		To mail address(es).
	 */
	public static function add($controlId, $toMail)
	{
		BaseControl::openForm("MailForm", $controlId);
		?>
			<input type="hidden" name="toMail" value="<?php print $toMail ?>" />
			
			<div class="control-body">
				<div class="fromMail">
					<?php print LanguageHandler::translate("$controlId MailForm fromMail");?>:<br/>
					<input type="text" id="<?php print $controlId ?>-fromMail" name="fromMail" value="" />
				</div>
				<div class="subject">
					<?php print LanguageHandler::translate("$controlId MailForm subject") ?>:<br/>
					<input type="text" id="<?php print $controlId ?>-subject" name="subject" value="" />
				</div>
				<div class="message">
					<?php print LanguageHandler::translate("$controlId MailForm message") ?>:<br/>
					<textarea id="<?php print $controlId ?>-message" name="message" cols="20" rows="10">&nbsp;</textarea>
				</div>
			</div>
			<div class="control-footer">
				<input type="reset" id="<?php print $controlId ?>-reset" name="reset" value="<?php print LanguageHandler::translate("$controlId MailForm reset"); ?>" />
				<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate("$controlId MailForm submit"); ?>" />
			</div>
			
			<script type="text/javascript">
				new MailForm("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
	
	/**
	 * Send an e-mail from the web site.
	 * 
	 * @access	protected
	 * @static
	 * 
	 * @param	string	$toMail		Recipient e-mail address or addresses.
	 * @param	string	$fromMail	The sender e-mail address.
	 * @param	string	$subject	The mail subject.
	 * @param	string	$message	The mail message.
	 * @return	array				A list of error codes, empty if the mail was sent.
	 */
	public static function sendMail($toMail, $fromMail, $subject, $message)
	{
		//Init variables
		$result = array();
			
		//Check so that all values are set
		if (!trim($toMail))
			array_push($result, 'toMailRequired');
		else if (!ValidationHandler::isEmail($toMail))
			array_push($result, 'toMailInvalid');
		if (!trim($fromMail))
			array_push($result, 'fromMailRequired');
		else if (!ValidationHandler::isEmail($fromMail))
			array_push($result, 'fromMailInvalid');
		if (!trim($subject))
			array_push($result, 'subjectRequired');
		if (!trim($message))
			array_push($result, 'messageRequired');
			
		//Abort if any errors have been fetched
		if (sizeof($result) > 0)
			return $result;
			
		//Set headers
		$headers = 'From: ' . $fromMail . "\r\n";
			
		//Try to send the mail
		if (!mail($toMail, $subject, $message, $headers))
			return array('mailError');
	
		//Return an empty array
		return array();
	}
}
?>