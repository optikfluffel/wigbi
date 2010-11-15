<?php
/**
 * Wigbi.Plugins.Data.Rating class file.
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
 * The Wigbi.Plugins.Data.Rating class.
 * 
 * This class represents a rating that can be applied to any kind of
 * object. Ratings can either be anonymous or non-anonymous. 
 * 
 * An anonymous rating will only keep track of how many times it has
 * been rated and will recalculate its average score each time it is
 * rated. It is not possible to extract any additional info from it.  
 * 
 * Sometimes, however, additional info is required, e.g. when a user
 * should be able to see what rating he/she has provided. To be able
 * to extract such information, make the rating non-anonymous. After
 * that, the createdBy parameter MUST be set when executing the rate
 * and unrate methods. It can be an IP address, an ID or whatever.
 * 
 * A rating can also be given a name, which can identify whatever is
 * being rated. This makes it really easy to bind a rating object to
 * another object without having to use a data list.
 * 
 * 
 * DATA LISTS ********************
 * 
 * The class has the following data lists: 
 * 
 * 	<ul>
 * 		<li>ratings (Rating) - synced</li>
 * 	</ul>
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * The class has the following AJAX functions, besides the ones that
 * are provided by the WigbiDataPlugin JavaScript base class:
 * 
 *	<ul>
 * 		<li>public void getRatingValue(string createdBy, function onGetRatingValue(float result))</li>
 * 		<li>public void rate(double rating, string createdBy, function onRate())</li>
 * 		<li>public void unrate(string createdBy, function onUnrate())</li>
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
class Rating extends WigbiDataPlugin
{
	/**#@+
	 * @ignore
	 */
	public $_name = "Unnamed rating__50";
	public $_createdBy = "__50";
	public $_anonymous = true;
	public $_parentId = "__GUID";
	public $_min = 1.0;
	public $_max = 5.0;
	public $_numRatings = 0;
	public $_average = 0.0;
	/**#@-*/
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->registerList("ratings", "Rating", true, null);
		
		$this->registerAjaxFunction("rate", array("rating", "createdBy"), false);
		$this->registerAjaxFunction("unrate", array("createdBy"), false);
	}
	
	
	public function average()
	{
		return $this->_average;
	}
	
	public function anonymous($value = true)
	{
		if (func_num_args() != 0)
			$this->_anonymous = func_get_arg(0);
		return $this->_anonymous;
	}
	
	public function createdBy($value = "")
	{
		if (func_num_args() != 0)
			$this->_createdBy = func_get_arg(0);
		return $this->_createdBy;
	}
	
	public function max($value = 5.0)
	{
		if (func_num_args() != 0)
			$this->_max = func_get_arg(0);
		return $this->_max;
	}
	
	public function min($value = 1.0)
	{
		if (func_num_args() != 0)
			$this->_min = func_get_arg(0);
		return $this->_min;
	}
	
	public function name($value = "")
	{
		if (func_num_args() != 0)
			$this->_name = func_get_arg(0);
		return $this->_name;
	}
	
	public function numRatings()
	{
		return $this->_numRatings;
	}
	
	public function parentId()
	{
		return $this->_parentId;
	}
	
	
	/**
	 * Get the value from a previous rating operation.
	 * 
	 * For anonymous ratings, the rating value must exist in session.
	 * For non-anonymous ratings, it must exist in the database.
	 * 
	 * If the object is non-anonymous, createdBy must be set. If the
	 * object is anonymous, the parameter will be ignored.
	 * 
	 * @access	public
	 * 
	 * @param	string	$createdBy	The id/name of the creator, if any.
	 * @return	float				The rating value, if any.
	 */
	public function getRatingValue($createdBy = "")
	{
		//Abort if the object is not saved
		if (!$this->id())
			throw new Exception("idRequired");
			
		//Require createdBy if the rating is non-anonymous
		if (!$this->anonymous() && !trim($createdBy))
			throw new Exception("createdByRequired");
		
		//Anonymous ratings are saved in session
		if ($this->anonymous())
			return Wigbi::sessionHandler()->get("Rating_" . $this->id());
		
		//Non-anonymous ratings are saved in the database	
		if (!$this->anonymous())
		{
			$searchFilter = new SearchFilter();
			$searchFilter->addSearchRule("createdBy = '" . $createdBy . "'");
			$objects = $this->searchListItems("ratings", $searchFilter->toString());
			$objects = $objects[0];
			
			if (sizeof($objects) > 0)
				return $objects[0]->average();
			return null;
		}
	}
	
	/**
	 * Rate the object.
	 *
	 * Rating an object will increment its numRatings value and make
	 * it recalculate its average score.
	 * 
	 * If the object is non-anonymous, createdBy must be set. If the
	 * object is anonymous, the parameter will be ignored.
	 * 
	 * The rating is stored in session so that it is available after
	 * being created. If a rating value exists for an object, either
	 * in session (for anonymous ratings) or in the database, a user
	 * has already rated the object. If so, the value will be updated.  
	 * 
	 * @access	public
	 * 
	 * @param	float	$value		Rating value.
	 * @param	string	$createdBy	The id/name of the creator, if any.
	 */
	public function rate($value, $createdBy = "")
	{
		//Abort if the object is not saved
		if (!$this->id())
			throw new Exception("idRequired");
			
		//Require createdBy if the rating is non-anonymous
		if (!$this->anonymous() && !trim($createdBy))
			throw new Exception("createdByRequired");
			
		//Abort if the value is too small or large
		if ($value < $this->min())
			throw new Exception("valueTooSmall");
		if ($value > $this->max())
			throw new Exception("valueTooLarge");
		
		//Unrate the object to ensure that no existing rating exists
		$this->unrate($createdBy);
		
		//Non-anonymous ratings are saved in the database
		if ($this->anonymous())
			Wigbi::sessionHandler()->set("Rating_" . $this->id(), $value);
		
		//Non-anonymous ratings are saved in the database
		if (!$this->anonymous())
		{
			$subRating = new Rating();
			$subRating->_parentId = $this->id();
			$subRating->_createdBy = $createdBy;
			$subRating->_average = $value;
			$subRating->save();
			
			$this->addListItem("ratings", $subRating->id());
		}
		
		//Increment rating count, calculate new average then save
		$currentTotalScore = $this->average() * $this->numRatings();
		$this->_numRatings = $this->_numRatings + 1;
		$this->_average = ($currentTotalScore + $value) / $this->numRatings(); 
		$this->save();
	}
	
	/**
	 * Unrate the object.
	 *
	 * Unrating an object will decrement its numRatings and cause it
	 * to recalculate its average score.
	 * 
	 * If the object is non-anonymous, createdBy must be set. If the
	 * object is anonymous, the parameter will be ignored.
	 * 
	 * This method can only be used if the object has been rated and
	 * the rating value exists either in session (anonymous ratings)
	 * or in the database.  
	 * 
	 * @access	public
	 * 
	 * @param	string	$createdBy	The id/name of the creator, if any.
	 */
	public function unrate($createdBy = "")
	{
		//Abort if the object is not saved
		if (!$this->id())
			throw new Exception("idRequired");
			
		//Require createdBy if the rating is non-anonymous
		if (!$this->anonymous() && !trim($createdBy))
			throw new Exception("createdByRequired");
			
		//Abort if the object is not rated
		$rating = $this->getRatingValue($createdBy);
		if (!$rating)
			return;
			
		//Decrement the rating count, calculate new average and then save
		$currentTotalScore = $this->_average * $this->_numRatings;
		$this->_numRatings = $this->_numRatings - 1;
		$this->_average =  $this->_numRatings == 0 ? 0 : ($currentTotalScore - $rating) / $this->_numRatings;
		$this->save();
		
		//Non-anonymous ratings are saved in the database
		if ($this->anonymous())	
			Wigbi::sessionHandler()->set("Rating_" . $this->id(), null);
			
		//Non-anonymous ratings are saved in the database
		if (!$this->anonymous())
		{
			$searchFilter = new SearchFilter();
			$searchFilter->addSearchRule("createdBy = '" . $createdBy . "'");
			$objects = $this->searchListItems("ratings", $searchFilter->toString());
			$objects = $objects[0];
			$this->deleteListItem("ratings", $objects[0]->id()); 
		}
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
		
		//The min rating must not exceed the max one
		if ($this->min() > $this->max())
			array_push($errorList, "minTooLarge");
			
		//Return error list
		return $errorList;
	}
}
?>