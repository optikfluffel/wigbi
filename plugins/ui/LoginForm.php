<?php

/**
 * Wigbi.Plugins.UI.LoginForm PHP class file.
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
 * The Wigbi.Plugins.UI.LoginForm PHP class.
 * 
 * This plugin can be used to login a user to a Wigbi web site that
 * is using the User data plugin. The plugin form is submitted with
 * AJAX, without reloading the page.
 * 
 * If redirectUrl is set, the form will redirect a user to that URL
 * after a successful login. If the autoRedirect property is set to
 * true, the form will redirect already logged in users to that URL
 * instead of displaying a form at all. 
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This UI plugin has the following JavaScript functionality besides
 * what is provided by the WigbiUIPlugin base class:
 * 
 * 	<ul>
 * 		<li>[AJAX] public void add(string id, string redirectUrl, bool autoRedirect, string targetContainerId, function onAdd())</li>
 * 		<li>[AJAX] public void submit()</li>
 * 		<li></li>
 * 		<li>[VIRTUAL] public void onSubmit(bool loginResult, string exception)</li>
 * 	</ul>
 * 
 * By default, the onSubmit event method alerts if the operation did
 * not succeed, as well as what went wrong.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.UI
 * @version			1.0.2
 */
class LoginForm extends WigbiUIPlugin
{
	/**
	 * Create an instance of the class. 
	 * 
	 * @access	public
	 * 
	 * @param	string	$id	The unique plugin instance ID.
	 */
	public function __construct($id)
	{
		parent::__construct($id);
	}
	
	
	
	/**
	 * Add a LoginForm to the page.
	 * 
	 * @access	public
	 * 
	 * @param		string	$id						The unique plugin instance ID.
	 * @param		string	$redirectUrl	The URL to redirect logged in users to.
	 * @param		string	$autoRedirect	Whether or not to automatically redirect already logged in users.
	 */
	public static function add($id, $redirectUrl, $autoRedirect = false)
	{
		if (User::getCurrentUser()->id() && $autoRedirect)
			JavaScript::redirect($redirectUrl);
		
		$plugin = new LoginForm($id);
		
		$plugin->beginPlugin();
		$plugin->beginPluginDiv();
		?>
		
		<form id="<?php print $plugin->getChildId("form") ?>">
			<input type="hidden" id="<?php print $plugin->getChildId("redirectUrl") ?>" value="<?php print $redirectUrl ?>" />
			<div id="<?php print $plugin->getChildId("validation") ?>" class="invalid hide"></div>
		
			<div class="input-title userName"><?php print $plugin->translate("userName") ?>:</div>
			<div class="input userName"><input type="text" id="<?php print $plugin->getChildId("userName") ?>" /></div>
			
			<div class="input-title password"><?php print $plugin->translate("password") ?>:</div>
			<div class="input password"><input type="password" id="<?php print $plugin->getChildId("password") ?>" /></div>
		
			<div class="formButtons">
				<input type="submit" id="<?php print $plugin->getChildId("submit") ?>"  value="<?php print $plugin->translate("submit") ?>" />
			</div>
		</form>
		
		<script type="text/javascript">
				var <?print $id ?> = new LoginForm("<?print $id ?>");
		</script>
		
		<?php
		$plugin->endPluginDiv();
		return $plugin->endPlugin();
	}
}

?>