<?php
/**
 * Wigbi.PHP.Controls.ValidationImage class file.
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

/* Build the image that will be displayed.
 * 
 * This part of the control is defined outside of the control class
 * and at the top of the file to make it possible to manipulate the
 * page headers. The image itself is thus not a part of the control;
 * it is just generated by it.
 * 
 * This is a very unusual approach that should not appear in other
 * standard Wigbi controls.
 */
if (array_key_exists("ValidationImageControlId", $_GET))
{	
	//Enable session
	session_start();
	
	//Set the control id
	$controlId = $_GET["ValidationImageControlId"];
	
	//Generate and store a 5 digit random number
	$rand = rand(10000, 99999);
	$rand = substr(sha1($rand), 0, 7);
	$_SESSION['ValidationImage_' . $controlId] = sha1($rand);
	
	//Create the image to work with
	$width = 75;
    $height = 30;
    $image = imagecreate($width, $height);
    $bgColor = imagecolorallocate ($image, 255, 255, 255);
    $textColor = imagecolorallocate ($image, rand(0,50), rand(0,50), rand(0,50));

    //Add random noise
    for ($i = 0; $i < 20; $i++)
	{
        $x = array (rand(0,$width), rand(0,$width));
        $y = array (rand(0,$height), rand(0,$height));
		$color = imagecolorallocate($image, rand(0,200), rand(0,200), rand(100,200));
        imageline ($image, $x[0], $x[1], $y[0], $y[1], $color);
    }
	
	//Write the random number and meta data to avoid caching
	imagestring ($image, 5, 5, 8, $rand, $textColor);
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	//Add content type meta data
	header('Content-type: image/jpeg');
	
	//Render and destroy the image
	imagejpeg($image);
	imagedestroy($image);
}
else
{
	/**
	 * The ValidationImage control class.
	 * 
	 * This control can be used to generate an image with a random text.
	 * The image can then be used to require that a user must enter the
	 * displayed text in order to perform certain operations.
	 * 
	 * The control can be added to the page with the PHP and JavaScript
	 * add functions and can then be retrieved with Wigbi.getControl(id).
	 * 
	 * 
	 * JAVASCRIPT ********************************
	 * 
	 * ValidationImage : BaseControl
	 * 
	 * Functions:
	 *	<ul>
	 * 		<li>public static void add(string controlId, string targetElementId, function onAdd())</li>
	 * 		<li>[ASYNC] public void validate(string validationCode)</li>
	 * 	</ul>
	 * 
	 * Events:
	 *	<ul>
	 * 		<li>public void onValidate(bool result)</li>
	 * 	</ul>
	 * 
	 * Override the onValidate function to set what to do when the
	 * validation operation has finished.
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
	 * 
	 * @todo		Improve the image graphic, enable fonts/color management etc.
	 * @todo		Sometimes, the image refresh does not work. Find out why.
	 */
	class ValidationImage extends BaseControl
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
	ValidationImage = Class({ Extends: BaseControl,
	
		/* Constructor ************/
		
		//Create an instance of the class.
		initialize: function(controlId)
		{
			//Call base contructor
			this.parent(controlId);
		},
		
		
		/* Functions **************/
		
		//Validate a certain validation code
		validate: function(validationCode)
		{
			Wigbi.executeFunction('ValidationImage', null, 'validate', [this.controlId(), validationCode], this.onValidate);
		},
		
		
		/* Events *****************/
		
		//Raised after a validation has occured
		onValidate: function(result) { }
	});
	
	
	/* Static functions ********/
	
	//Add a new control instance to the page with AJAX
	ValidationImage.add = function(controlId, targetElementId, onAdd)
	{
		Wigbi.executeFunction('ValidationImage', null, 'add', [controlId], function(result)
		{
			//Add and create the control
			$('#' + targetElementId).html(result);
			new ValidationImage(controlId);
			
			//Raise the onAadd event
			if (onAdd)
				onAdd();
		});
	};
	");
		}
		
		
		//Functions ********************
		
		/**
		 * Add a validation image to the page.
		 * 
		 * The control generates a new string for a certain control each
		 * time the same ID is used by the add function.
		 * 
		 * @access	public
		 * @static
		 * 
		 * @param	string	$controlId		The unique control ID.
		 */
		public static function add($controlId)
		{
			?>
				<span class="ValidationImage <?php print $controlId ?>">
					<img id="<?php print $controlId ?>" src='<?php print Wigbi::webRoot() . "wigbi/controls/ValidationImage.php?ValidationImageControlId=" . $controlId . "&key=" . sha1(date("YmdHis")) ?>' alt="" />
				</span>
			
				<script type="text/javascript">
					new ValidationImage("<?php print $controlId ?>");
				</script>
			<?php
		}
		
		/**
		 * Validate the value for a certain random image
		 * 
		 * @access	public
		 * @static
		 * 
		 * @param	string	$controlId		The unique control ID.
		 * @param	string	$validationCode	The value to compare to the session stored image value.
		 * @return	bool					Whether or not the entered code is valid.
		 */
		public static function validate($controlId, $validationCode)
		{
			if (array_key_exists('ValidationImage_' . $controlId, $_SESSION))
				return sha1($validationCode) == $_SESSION['ValidationImage_' . $controlId];
			return false;
		}
	}
}
?>