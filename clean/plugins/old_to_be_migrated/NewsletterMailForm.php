<?php
/**
 * Wigbi.PHP.Controls.NewsletterMailForm class file.
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
 * The NewsletterMailForm control class.
 * 
 * This control can be used to send an e-mail to all e-mail addresses
 * that are registered as subscribers to a certain newsletter.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the Newsletter and NewsletterSubscriber seeds.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * MailForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string email()</li>
 * 		<li>public void setEmail(string newVal)</li>
 * 		<li>public Newsletter object()</li>
 * 		<li>public void setObject(Newsletter obj)</li>
 * 		<li>public bool unsubscribe()</li>
 * 		<li>public void setUnsubscribe(bool newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string objectIdOrName, string targetElementId, function onAdd())</li>
 * 		<li>public void reset()</li>
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
 * 		<li>[controlId] NewsletterMailForm fromMailInvalid</li>
 * 		<li>[controlId] NewsletterMailForm fromMailRequired</li>
 * 		<li>[controlId] NewsletterMailForm mailError</li>
 * 		<li>[controlId] NewsletterMailForm message</li>
 * 		<li>[controlId] NewsletterMailForm messageRequired</li>
 * 		<li>[controlId] NewsletterMailForm noSubscribers</li>
 * 		<li>[controlId] NewsletterMailForm subject</li>
 * 		<li>[controlId] NewsletterMailForm subjectRequired</li>
 * 		<li>[controlId] NewsletterMailForm submit</li>
 * 		<li>[controlId] NewsletterMailForm submitError</li>
 * 		<li>[controlId] NewsletterMailForm submitErrorMessage</li>
 * 		<li>[controlId] NewsletterMailForm submitMessage</li>
 * 		<li>[controlId] NewsletterMailForm submitted</li>
 * 		<li>[controlId] NewsletterMailForm submitting</li>
 * 	</ul>
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.95
 * @version		0.99.3
 */
class NewsletterMailForm extends BaseControl
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
NewsletterMailForm = Class({ Extends: BaseControl,
	
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
	
	//Get/set the e-mail message
	message: function() { return this.form().message.value; },
	setMessage: function(newVal) { this.form().message.value = newVal; },
	
	//Get/set the bound object.
	object: function()
	{
		var tmpObj = new Newsletter();
		\$extend(tmpObj, JSON.decode(this.form().object.value));
		return tmpObj;
	},
	setObject: function(obj) 
	{
		this.form().object.value = JSON.encode(obj);
	},
	
	//Get/set the e-mail subject
	subject: function() { return this.form().subject.value; },
	setSubject: function(newVal) { this.form().subject.value = newVal; },
	
	
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
		form.submit.value = LanguageHandler.translate(_this.controlId() + ' NewsletterMailForm submitting');
				
		//Perform the mail operation
		this.object().sendMail(this.subject(), this.message(), function(errorList)
		{
			//Raise the onValidate event
			_this.onValidate(errorList);
			
			//Handle any possible errors
			if (errorList.length > 0)
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' NewsletterMailForm submitError');
				
				//Raise the onSubmitError event
				_this.onSubmitError(errorList);
			}
			else
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' NewsletterMailForm submitted');
				
				//Raise the onSubmit event
				_this.onSubmit();
					
				//Reset the form
				_this.reset();
			}
						
			//Enable the submit button and set final event
			form.submit.disabled = false;
			setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' NewsletterMailForm submit'); }, 1000);
		});
	},
	
	
	/* Events *****************/
	
	//Raised before the form is submitted
	onPreSubmit: function(form) { return true; },
	
	//Raised when the control is correctly submitted
	onSubmit: function()
	{
		alert(LanguageHandler.translate(this.controlId() + ' NewsletterMailForm submitMessage'));
	},
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList)
	{
		var message = LanguageHandler.translate(this.controlId() + ' NewsletterMailForm submitErrorMessage') + ':\\n';
		for (var i=0; i<errorList.length; i++)
			message += '   ' + LanguageHandler.translate(this.controlId() + ' NewsletterMailForm ' + errorList[i]) + '\\n';
		alert(message);
	},
	
	//Raised when the control has been validated 
	onValidate: function(errorList)
	{
		this.bindValidationResult('MailForm', ['message', 'subject'], errorList);
	}
});

	
/* Static functions *******/
	
//Add a new control instance to the page
NewsletterMailForm.add = function(controlId, objectIdOrName, targetElementId, onAdd)
{
	Wigbi.executeFunction('NewsletterMailForm', null, 'add', [controlId, objectIdOrName], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new NewsletterMailForm(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a NewsletterMailForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId	The unique control ID.
	 * @param	mixed	$object		The object itself or its ID or name, if any; default null.
	 */
	public static function add($controlId, $object)
	{
		//Create a working object
		$tmpObj = $object;
		if (!$tmpObj)
		{
			$tmpObj = new Newsletter();
			$tmpObj->reset();
		}	
		
		//Handle id/name if object is a string
		if (gettype($object) == "string")
		{
			//Init object and load by id
			$tmpObj = new Newsletter();
			$tmpObj->load($object);
				
			//Second, load by name
			if ($tmpObj->id() != $object)
			{
				$tmpObj->loadBy("name", $object);
				$tmpObj->setName($object);
			}
		}
		
		//Add form
		BaseControl::openForm("NewsletterMailForm", $controlId, $tmpObj);
		?>
			<div class="control-body">
				<div class="subject">
					<?php print LanguageHandler::translate("$controlId NewsletterMailForm subject") ?>:<br/>
					<input type="text" id="<?php print $controlId ?>-subject" name="subject" value="" />
				</div>
				<div class="message">
					<?php print LanguageHandler::translate("$controlId NewsletterMailForm message") ?>:<br/>
					<textarea id="<?php print $controlId ?>-message" name="message" cols="20" rows="10">&nbsp;</textarea>
				</div>
			</div>

			<div class="control-footer">
				<input type="reset" id="<?php print $controlId ?>-reset" name="reset" style="display:none" />
				<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate("$controlId NewsletterMailForm submit"); ?>" />
			</div>
			
			<script type="text/javascript">
				new NewsletterMailForm("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
}
?>