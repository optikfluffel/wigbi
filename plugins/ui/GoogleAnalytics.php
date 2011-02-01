<?php

/**
 * Wigbi.Plugins.UI.YouTubePlayer PHP class file.
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
 * The Wigbi.Plugins.UI.YouTubePlayer PHP class.
 * 
 * This plugin can be used to add Google Analytics tracking code to
 * the page. The plugin will automatically remove the code from all
 * localhost pages.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @link				http://analytics.google.com
 * @package			Wigbi
 * @subpackage	Plugins.UI
 * @version			1.0.3
 */
class GoogleAnalytics extends WigbiUIPlugin
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
	 * Add a GoogleAnalytics tracking code to the page.
	 * 
	 * @access	public
	 * 
	 * @param	string	$accountId				The Google Analytics account ID.
	 * @param	bool		$addToLocalhost		Whether or not to add tracking code to localhost pages; default false.
	 */
	public static function add($accountId, $addToLocalhost = false)
	{
		$plugin = new GoogleAnalytics("googleAnalytics");
		$plugin->beginPlugin();
		
		if (!(strpos(UrlHandler::currentUrl(), "localhost")) || $addToLocalhost) { ?>
		
			<script type="text/javascript">
				var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
				document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
			</script>
			<script type="text/javascript">
				var pageTracker = _gat._getTracker('<?php print "UA-" . str_replace("UA-", "", $accountId); ?>');
				pageTracker._trackPageview();
			</script>
		
		<?php } return $plugin->endPlugin();
	}
}

?>