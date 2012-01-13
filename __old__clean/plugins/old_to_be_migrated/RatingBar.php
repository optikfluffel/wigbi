<?php
/**
 * Wigbi.PHP.Controls.RatingBar class file.
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
 * The RatingBar control class.
 * 
 * This control can be used to add ratings to a certain Rating object.
 * It displays a line of images, which can be clicked to add a rating.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the Rating seed.
 * 
 * The control will automatically create the rating object if it does
 * not exist when a rating button is pressed. Thus, it is possible to
 * add the control to a page without creating an object first.
 * 
 * When the control is added to the page, it displays a set of images
 * with the average rating highlighted. If the visitor - anonymous or
 * non-anonymous - has used the control to post a rating, the control
 * will display the user's rating.
 * 
 * The control design is fully customizable, using CSS. Wigbi applies
 * default styling automatically, using css files and images that are
 * included in the Wigbi release, but this default styling can easily
 * be overridden. 
 * 
 * Set ratingAllowed to true to make it possible to add ratings with
 * the control. Otherwise, the control will only display the rating.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * RatingBar : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public int addedRating()</li>
 * 		<li>public bool ratingAllowed()</li>
 * 		<li>public void setRatingAllowed(bool newVal)</li>
 * 		<li>public string createdBy()</li>
 * 		<li>public void setCreatedBy(string newVal, function onSetCreatedBy())</li>
 * 		<li>public Rating object()</li>
 * 		<li>public void setObject(Rating obj)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string objectIdOrName, string createdById, bool ratingAllowed, int minRating, int maxRating, string targetElementId, function onAdd())</li>
 * 		<li>private string getClickCode(int currentRating, int rating)</li>
 * 		<li>private string getCssClass(int currentRating, int rating)</li>
 * 		<li>private string getHoverCode(int currentRating, int rating)</li>
 * 		<li>private void highlightRating(int currentRating, int rating, bool highlight)</li>
 * 		<li>public void refresh()</li>
 * 		<li>[ASYNC] public void submit()</li>
 * 	</ul>
 * 
 * Events:
 *	<ul>
 * 		<li>public bool onPreSubmit()</li>
 * 		<li>public void onSubmit(rating)</li>
 * 		<li>public void onSubmitError(string[] errorList)</li>
 * 	</ul>
 * 
 * Override onPreSubmit to set what to do before the form is being
 * submitted. If it returns false, the submit operation will abort.
 * 
 * Override onSubmit to set what to do when the submit operation
 * has finished. By default, it does nothing.
 * 
 * Override onSubmitError to set what to do when a submit operation
 * fails. By default, it alerts all errors in the error list.
 * 
 * 
 * CSS ***************************************
 * 
 * The control uses a elements instead of image elements. In order to
 * style the control with CSS, use the following classes (set general
 * a padding to 0 and the left/top padding to the image width/height):
 * 
 * 	<ul>
 * 		<li>unrated - the "unrated" image, e.g. image 4 and 5 if the average is 3/5.</li>
 * 		<li>rated - the full "rated" image, e.g. image 1, 2 and 3 if the average is 3/5.</li>
 * 		<li>rated half - the half "rated" image, e.g. image 3 if the average is 2.5/5.</li>
 * 		<li>rated createdBy - the "rated" image that is used if a "createdBy" sub rating exists.</li>
 * 		<li>hover - the mouse hover image to use, when rating is allowed.</li>
 * 		<li>rating1, rating2, rating3 etc. - this is applied to all rating images.</li> 
 * 	</ul>
 * 
 * 
 * LANGUAGE HANDLING *************************
 * 
 * The following language parameters are used by the control:
 *     
 *	<ul>
 * 		<li>[controlId] RatingBar idRequired</li>
 * 		<li>[controlId] RatingBar rate</li>
 * 		<li>[controlId] RatingBar ratingExists</li>
 * 		<li>[controlId] RatingBar ratingNotExists</li>
 * 	</ul>
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.99.2
 * @version		0.99.2
 * 
 * @todo		Revise this control and the Rating seed. Make them more intuitive!
 */
class RatingBar extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the control.
	 * 
	 * This constructor is only to be used by Wigbi at startup.
	 * 
	 * @access	public
	 */
	public function __construct()
	{	
		//Register the general JavaScript
		$this->registerJavaScript(@"
RatingBar = Class({ Extends: BaseControl,
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Initialize form
		this.refresh();
		
		//Bind form submit event
		var _this = this;
		this.form().onsubmit = function() { _this.submit(); return false; };
	},
	
	
	/* Properties *************/
	
	//Get/set the added rating, if any 
	addedRating: function() { return JSON.decode(this.form().addedRating.value); },
	
	//Get/set whether or not rating is allowed
	ratingAllowed: function() { return JSON.decode(this.form().ratingAllowed.value); },
	setRatingAllowed: function(newVal)
	{
		this.form().ratingAllowed.value = JSON.encode(newVal);
		this.refresh();
	},
	
	//Get/set the createdBy to apply to the rating; this will add a new control to the page
	createdBy: function() { return this.form().createdBy.value; },
	setCreatedBy: function(newVal, onSetCreatedBy) { RatingBar.add(this.controlId(), this.object().id(), newVal, this.ratingAllowed(), this.controlId() + '-divContainer', onSetCreatedBy); },
	
	//Get/set the bound object.
	object: function()
	{
		var tmpObj = new Rating();
		\$extend(tmpObj, JSON.decode(this.form().object.value));
		return tmpObj;
	},
	setObject: function(obj)
	{
		this.form().object.value = JSON.encode(obj);
		this.refresh();
	},
	
	
	/* Functions **************/
	
	//Private function for building a tag click code
	getClickCode: function(currentRating, rating)
	{
		if (!this.ratingAllowed())
			return ' onclick=\"return false\"';
		return ' href=\"\" onclick=\"Wigbi.getControl(\'' + this.controlId() + '\').submit(' + currentRating + '); return false;\"';
	},
	
	//Private function for building the css class for an a tag
	getCssClass: function(currentRating, rating)
	{
		//Init CSS class string, add ratingX class
		var class = 'rating' + currentRating;
		
		//Add correct rating classes
		if (currentRating <= rating)
			class += ' rated';
		else if (currentRating - 0.5 <= rating)
			class += ' rated half';
		else
			class += ' unrated';
		
		//Add createdBy if an added rating already exists
		if (currentRating <= rating && this.addedRating())
			class += ' createdBy';
		
		//Return class string
		return class;
	},
	
	//Private function for building the hover code for an a tag
	getHoverCode: function(currentRating, rating)
	{
		//Abort if rating is not allowed
		if (!this.ratingAllowed())
			return '';
			
		//Build result
		var result = ' title=\"' + LanguageHandler.translate(this.controlId() + ' RatingBar rate').replace('[rating]', currentRating) + '\"';
		result += ' onmouseover=\"Wigbi.getControl(\'' + this.controlId() + '\').highlightRating(' + currentRating + ',' + rating + ', true);\"';
		result += ' onmouseout=\"Wigbi.getControl(\'' + this.controlId() + '\').highlightRating(' + currentRating + ',' + rating + ', false);\"';
		return result;
	},
	
	//Private function that highlights or dims a rating button
	highlightRating: function(currentRating, rating, highlight)
	{
		//Abort if rating is not allowed
		if (!this.ratingAllowed())
			return;
			
		//Apply the hover class to all affected ratings and the unrated to all others
		for (var i = 0; i<=this.object().maxRating() - this.object().minRating(); i++)
		{
			//Get the element rating and the element to affect
			var elementRating = this.object().minRating() + i;
			var element = $('#' + this.controlId() + '-rating' + elementRating); 
			
			//Remove all classes
			element.attr('class', '');
			
			//If highlight, add hover or unrated class, else add correct class
			if (highlight)
				element.addClass((elementRating <= currentRating) ? 'hover' : 'unrated');
			else
				element.addClass(this.getCssClass(elementRating, rating));
		}
	},
	
	//Refresh the control
	refresh: function()
	{
		//Reset HTML content of target div
		$('#' + this.controlId() + '-divImages').html(''); 
		
		//Define rounding precision
		var rounding = 0.5;
		
		//Get the rating to display
		var rating = this.addedRating();
		if (!rating)
		{
			var average = this.object().average();
			var roundedUp = Math.ceil(average/rounding) * rounding;
			var roundedDown = Math.floor(average/rounding) * rounding;
			var rounded = Math.round(average/rounding) * rounding;
			var rating = rounded;
		}
			
		//Add each image properly
		for (var i = 0; i<=this.object().maxRating() - this.object().minRating(); i++)
		{
			//Get the current rating
			var currentRating = this.object().minRating() + i;
			
			//Build anchor tag
			var tag = '<a id=\"' + this.controlId() + '-rating' + currentRating + '\"';
			tag += ' class=\"' + this.getCssClass(currentRating, rating) + '\"';
			tag += this.getHoverCode(currentRating, rating);
			tag += this.getClickCode(currentRating, rating);
			tag += '><img /></a>'; 
			
			//Append the tag to the target container
			$('#' + this.controlId() + '-divImages').html($('#' + this.controlId() + '-divImages').html() + tag);
		}
	},
	
	//Submit the control form
	submit: function(rating)
	{
		//Create private variables
		var _this = this;
		var form = this.form();
		var obj = this.object();
		
		//Update rating
		_this.form().addedRating.value = rating;
		
		//Disable ratings until submitted
		this.setRatingAllowed(false);
		
		//Raise the onPreSubmit event
		if (!this.onPreSubmit())
			return false;
		
		//Create object, if needed
		if (!obj.id())
		{
			//Save the object, then resubmit
			obj.save(function()
			{
				_this.setObject(obj);
				_this.submit(rating);
			});
			
			//bort this submit
			return;
		}

		//Add a rating to the object
		obj.addRating(rating, this.createdBy(), function(errorList)
		{
			//Abort if the operation failed
			if (errorList.length > 0)
			{
				_this.onSubmitError(errorList);
				_this.setRatingAllowed(true);
				return;
			}
			
			//Reload the object and raise the submit event
			obj.load(obj.id(), function()
			{
				_this.setObject(obj);
				_this.onSubmit();
				_this.setRatingAllowed(true);
			});
		});
	},
	
	
	/* Events *****************/
	
	//Raised before the control is submitted
	onPreSubmit: function() { return true; },
	
	//Raised when the control has been submitted
	onSubmit: function() { },
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList)
	{
		if (errorList)
		{		
			var message = '';
			for (var i=0; i<errorList.length; i++)
				message += LanguageHandler.translate(this.controlId() + ' RatingBar ' + errorList[i]) + '.\\n';
			alert(message);
		}	
	},
	
	//Raised when the control has been validated 
	onValidate: function(errorList) { }
});

	
/* Static functions *******/
	
//Add a new control instance to the page with AJAX
RatingBar.add = function(controlId, objectIdOrName, createdBy, ratingAllowed, minRating, maxRating, targetElementId, onAdd)
{	
	Wigbi.executeFunction('RatingBar', null, 'add', [controlId, objectIdOrName, createdBy, ratingAllowed, minRating, maxRating], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new RatingBar(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a RatingBar control to the page.
	 * 
	 * The object parameter can either be the object itself or its
	 * ID or name. If the object does not exist, this control will
	 * automatically create it when it is submitted.
	 * 
	 * The minRating and maxRating parameters will only be applied
	 * to new objects. If the target object exists, the values are
	 * overwritten by the object's min/max properties. 
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId		The unique control ID.
	 * @param	mixed	$object			The object itself or its ID or name, if any; default null.
	 * @param	string	$createdBy		The createdBy to apply to the rating, if any; default blank.
	 * @param	bool	$ratingAllowed	Whether or not to allow ratings; default false.
	 * @param	int		$minRating		The minimum rating that can be applied; default 1.
	 * @param	int		$maxRating		The maximum rating that can be applied; default 5.
	 */
	public static function add($controlId, $object=null, $createdBy="", $ratingAllowed=false, $minRating=1, $maxRating=5)
	{
		//Create temp object
		$tmpObj = new Rating();
		$tmpObj->reset();
		$tmpObj->setMinRating($minRating);
		$tmpObj->setMaxRating($maxRating);
		
		//Use the provided object, if any
		if ($object)
			$tmpObj = $object;
		
		//Handle id/name if object is a string
		if (gettype($object) == "string")
		{
			//First, load by ID
			$tmpObj = new Rating();
			$tmpObj->load($object);
				
			//Second, load by name if needed
			if ($tmpObj->id() != $object)
			{
				$tmpObj->loadBy("name", $object);
				$tmpObj->setName($object);
			} 
		}
		
		//Get the already added rating, if any
		$addedRating = $tmpObj->getRating($createdBy); 
		
		//Add the control to the page
		BaseControl::openForm("RatingBar", $controlId, $tmpObj);
		?>
			<div id="<?php print $controlId ?>-divContainer">
				
				<input type="hidden" name="addedRating" value="<?php print $addedRating ? $addedRating : 0; ?>" />
				<input type="hidden" name="createdBy" value="<?php print $createdBy; ?>" />
				<input type="hidden" name="ratingAllowed" value="<?php print $ratingAllowed ? 1 : 0; ?>" />
			
				<div id="<?php print $controlId ?>-divImages" class="images"></div>
				
				<script type="text/javascript">
					new RatingBar("<?php print $controlId ?>");
				</script>
				
			</div>
		<?php
		BaseControl::closeForm();
	}
}
?>