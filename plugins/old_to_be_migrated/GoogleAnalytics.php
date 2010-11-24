<?php
/**
 * Wigbi.PHP.Controls.GoogleAnalytics class file.
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
 * The GoogleAnalytics control class.
 * 
 * This control can be used to add a Google Analytics tag to the page
 * without having to write all the JavaScript code manually.
 * 
 * The control can be added to the page with the PHP add function. It
 * is not added to the Wigbi control collection.
 * 
 * The control will, by default, not add any JavaScript code to sites
 * that run on localhost. This behavior can, however, be overridden.
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @link		http://analytics.google.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.9
 * @version		0.99.2
 */
class GoogleAnalytics extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the control.
	 * 
	 * This constructor is only to be used by Wigbi at startup.
	 * 
	 * @access	public
	 */
	public function __construct() { }
	
	
	//Functions ********************
	
	/**
	 * Add a GoogleAnalytics control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$accountId		The Google Analytics account ID.
	 * @param	bool	$addOnLocalhost	Whether or not to add any code to localhost sites; default false. 
	 */
	public static function add($accountId, $addOnLocalhost = false)
	{
		if (!(strpos(Wigbi::fullUrl(), "localhost")) || $addOnLocalhost)
		{ ?>
			<script type="text/javascript">
				var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
				document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
			</script>
			<script type="text/javascript">
				var pageTracker = _gat._getTracker('<?php print "UA-" . str_replace("UA-", "", $accountId); ?>');
				pageTracker._trackPageview();
			</script>
		<?php }
	}
}
?>