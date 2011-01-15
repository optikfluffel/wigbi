<?php

/**
 * Wigbi.Plugins.UI.LogoutLink PHP class file.
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
 * The Wigbi.Plugins.UI.LogoutLink PHP class.
 * 
 * This plugin can be used to logout a logged in user from the site,
 * using the User data plugin. The operation is submitted with AJAX,
 * without reloading the page.
 * 
 * If redirectUrl is set, the plugin will redirect a user to the URL
 * when he/she is successfully logged out.
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This UI plugin has the following JavaScript functionality besides
 * what is provided by the WigbiUIPlugin base class:
 * 
 * 	<ul>
 * 		<li>[AJAX] public void add(string id, string redirectUrl, string targetContainerId, function onAdd())</li>
 * 		<li>[AJAX] public void submit()</li>
 * 		<li></li>
 * 		<li>[VIRTUAL] public void onSubmit()</li>
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
 * @version			1.0.0
 */
class LogoutLink extends WigbiUIPlugin
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
	 * Add a LogoutLink to the page.
	 * 
	 * @access	public
	 * 
	 * @param		string	$id						The unique plugin instance ID.
	 * @param		string	$redirectUrl	The URL to redirect logged out users to.
	 */
	public static function add($id, $redirectUrl)
	{
		$plugin = new LogoutLink($id);
		
		$plugin->beginPlugin();
		View::addHiddenInput($plugin->getChildId("redirectUrl"), $redirectUrl, "");
		?>
		
			<script type="text/javascript">
				var <?print $id ?> = new LogoutLink("<?print $id ?>", "<?php print $redirectUrl; ?>");
			</script>
			
			<a href="" onclick="<?print $id ?>.submit(); return false;">
				<?php print $plugin->translate("logout") ?>
			</a>
			
		<?php return $plugin->endPlugin();
	}
}

?>