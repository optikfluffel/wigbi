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
 * The GoogleAdSense control class.
 * 
 * This control can be used to add a Google AdSense script tag to the
 * page without having to write all the JavaScript code manually.
 * 
 * The control can be added to the page with the PHP add function. It
 * is not added to the Wigbi control collection.
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @link		http://www.google.com/adsense
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.99.2
 * @version		0.99.2
 */
class GoogleAdSense extends BaseControl
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
	 * Add a GoogleAdSense control to the page.
	 * 
	 * The function requires a client ID, as well as a slot ID,
	 * a width and a height.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$clientId	The Google AdSense account ID; e.g. pub-3142496792403918.
	 * @param	string	$slotId		The Google AdSense slot ID; e.g. 7432596757.
	 * @param	int		$width		The ad width.
	 * @param	int		$height		The ad height.
	 */
	public static function add($clientId, $slotId, $width, $height)
	{	
		?><script type="text/javascript"><!--
			google_ad_client = "<?php print $clientId ?>";
			google_ad_slot = "<?php print $slotId ?>";
			google_ad_width = <?php print $width ?>;
			google_ad_height = <?php print $height ?>;
			//-->
		</script>
		
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script><?php
	}
}
?>