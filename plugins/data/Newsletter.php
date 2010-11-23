<?php
/**
 * Wigbi.Plugins.Data.Newsletter class file.
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
 * The Wigbi.Plugins.Data.Newsletter class.
 * 
 * This class represents a newsletter to which a list of subscribers
 * can be added. E-mail messages can then be sent to all subscribers
 * by using the sendMail(...) method.
 * 
 * 
 * DATA LISTS ********************
 * 
 * The class has the following data lists: 
 * 
 * 	<ul>
 * 		<li>subscribers (NewsletterSubscriber) - synced</li>
 * 	</ul>
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * The class has the following AJAX functions, besides the ones that
 * are provided by the WigbiDataPlugin JavaScript base class:
 * 
 *	<ul>
 * 		<li>public void addSubscriber(string email, function onAddSubscriber())</li>
 * 		<li>public void removeSubscriber(string email, function onRemoveSubscriber())</li>
 * 		<li>public void sendEmail(string subject, string mailBody, function onRemoveSubscriber())</li>
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
class Newsletter extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_name = "Unnamed newsletter__50";
	public $_fromEmail = "__50";
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->registerList("subscribers", "NewsletterSubscriber", true, "email");
		
		$this->registerAjaxFunction("addSubscriber", array("email"), false);
		$this->registerAjaxFunction("removeSubscriber", array("email"), false);
		$this->registerAjaxFunction("sendEmail", array("subject", "mailBody"), false);
	}
	
	
	public function fromEmail($value = "")
	{
		if (func_num_args() != 0)
			$this->_fromEmail = func_get_arg(0);
		return $this->_fromEmail;
	}
	
	public function name($value = "")
	{
		if (func_num_args() != 0)
			$this->_name = func_get_arg(0);
		return $this->_name;
	}
	
	
	/**
	 * Add a subscriber to the newsletter.
	 * 
	 * @access	public
	 * 
	 * @param	string	$email	The e-mail address to add to the subscriber list.
	 * @return	bool			Whether or not the operation succeeded.
	 */
	public function addSubscriber($email)
	{
		//Abort if the newsletter has not been saved
		if (!$this->id())
			throw new Exception("id_required");
		
		//Create new subscriber
		$subscriber = new NewsletterSubscriber();
		$subscriber->email($email);
		$subscriber->newsletterId($this->id());
		
		//Abort if the subscriber is invalid
		$validationResult = $subscriber->validate();
		if (sizeof($validationResult) > 0)
			throw new Exception(implode($validationResult));
		
		//Abort if the e-mail address is already a subscriber
		$searchFilter = new SearchFilter();
		$searchFilter->addSearchRule("email LIKE '$email'");
		$result = $this->searchListItems("subscribers", $searchFilter);
		$subscribers = $result[0];
		if (sizeof($subscribers) > 0)
			return true;

		//Save the newsletter and add it to the list
		$subscriber->save();
		$this->addListItem("subscribers", $subscriber->id());
		return true;
	}

	/**
	 * Remove a subscriber from the newsletter.
	 * 
	 * @access	public
	 * 
	 * @param	string	$email	The e-mail address to remove from the subscriber list.
	 * @return	bool			Whether or not the operation succeeded.
	 */
	public function removeSubscriber($email)
	{
		//Abort if the newsletter has not been saved
		if (!$this->id())
			throw new Exception("id_required");
		
		//Abort if the e-mail address is already a subscriber
		$searchFilter = new SearchFilter();
		$searchFilter->addSearchRule("email LIKE '$email'");
		$result = $this->searchListItems("subscribers", $searchFilter);
		$subscribers = $result[0];
		if (sizeof($subscribers) == 0)
			return false;
		
		//Remove the subscriber
		$subscriber = $subscribers[0];
		$this->deleteListItem("subscribers", $subscriber->id());
		return true;
	}
	
	/**
	 * Send an e-mail to all newsletter subscribers.
	 * 
	 * @access	public
	 * 
	 * @param	string	$subject	The e-mail subject.
	 * @param	string	$mailBody	The e-mail message.
	 * @return	bool				Whether or not the operation succeeded.
	 */
	public function sendEmail($subject, $mailBody)
	{	
		//first, abort if subject and/or content is missing    
		$result = array();
		if (!trim($subject))
			array_push($result, "subject_required");
		if (!trim($mailBody))
			array_push($result, "mailBody_required");
		if (sizeof($result) > 0)
			throw new Exception(implode($result, ","));
		
		//Abort if the newsletter has not been saved
		if (!$this->id())
			throw new Exception("id_required");
			
		//Abort if the newsletter is not valid
		$validationResult = $this->validate();
		if (sizeof($validationResult) > 0)
			throw new Exception(implode($validationResult));

		//Iterate over all subscribers and fetch all valid ones
		//TODO: Select all e-mail addresses directly from the database
		$subscribers = $this->getListItems("subscribers", 0, 100000000);
		$subscribers = $subscribers[0];
		$validSubscribers = array();
		foreach ($subscribers as $subscriber)
			if (ValidationHandler::isEmail($subscriber->email()))
				array_push($validSubscribers, $subscriber->email());
		
		//Build a to email string, abort if none
		$toMail = join(",", $validSubscribers);
		if (!$toMail)
			throw new Exception("noSubscribers");
		
		//Try to send the mail
		$headers = 'From: ' . $this->fromMail() . "\r\n";
		if (!mail($toMail, $subject, $message, $headers))
			throw new Exception("mailError ");
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
		
		//Require a valid e-mail address
		if (!trim($this->fromEmail()))
			array_push($errorList, "fromEmail_required");
		else if (!ValidationHandler::isEmail($this->fromEmail()))
			array_push($errorList, "fromEmail_invalid");
			
		//Return error list
		return $errorList;
	}
}
?>