<?php

class RatingBehavior extends UnitTestCase
{
	private $rating;
	
	
	
	function RatingBehavior()
	{
		$this->UnitTestCase("Rating data plugin");
	}
	
	function setUp()
	{
		$this->rating = new Rating();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->rating->setupDatabase();
	}
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->rating = new Rating();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->rating->className(), "Rating");
		$this->assertEqual($this->rating->collectionName(), "Ratings");
		
		$this->assertEqual($this->rating->name(), "Unnamed rating__50");
		$this->assertEqual($this->rating->createdBy(), "__50");
		$this->assertEqual($this->rating->anonymous(), true);
		$this->assertEqual($this->rating->parentId(), "__GUID");
		$this->assertEqual($this->rating->min(), 1.0);
		$this->assertEqual($this->rating->max(), 5.0);
		$this->assertEqual($this->rating->numRatings(), 0);
		$this->assertEqual($this->rating->average(), 0.0);
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->rating->className(), "Rating");
		$this->assertEqual($this->rating->collectionName(), "Ratings");
		
		$this->assertEqual($this->rating->name(), "Unnamed rating");
		$this->assertEqual($this->rating->createdBy(), "");
		$this->assertEqual($this->rating->anonymous(), true);
		$this->assertEqual($this->rating->parentId(), "");
		$this->assertEqual($this->rating->min(), 1.0);
		$this->assertEqual($this->rating->max(), 5.0);
		$this->assertEqual($this->rating->numRatings(), 0);
		$this->assertEqual($this->rating->average(), 0.0);
	}
	
	function test_constructor_shouldRegisterListsAndFunctions()
	{
		$lists = $this->rating->lists();
		$this->assertEqual(sizeof($lists), 1);
		
		$list = $lists["ratings"];
		
		$this->assertEqual($list->name(), "ratings");
		$this->assertEqual($list->itemClass(), "Rating");
		$this->assertEqual($list->isSynced(), true);
		$this->assertEqual($list->sortRule(), null);
		
		$functions = $this->rating->ajaxFunctions();
		
		$this->assertEqual(sizeof($functions), 2);
		
		$function = $functions[0];
		
		$this->assertEqual($function->name(), "rate");
		$this->assertEqual($function->parameters(), array("rating", "createdBy"));
		$this->assertEqual($function->isStatic(), false);
		
		$function = $functions[1];
		
		$this->assertEqual($function->name(), "unrate");
		$this->assertEqual($function->parameters(), array("createdBy"));
		$this->assertEqual($function->isStatic(), false);
	}

    
		
	function test_properties_shouldBePersisted()
	{
		$this->rating->name("name");
		$this->rating->createdBy("created");
		$this->rating->anonymous(false);
		$this->rating->min(1.1);
		$this->rating->max(4.9);
		$this->rating->save();
		
		$tmpObj = new Rating();
		$tmpObj->load($this->rating->id());
		
		$this->assertEqual($tmpObj->name(), "name");
		$this->assertEqual($tmpObj->createdBy(), "created");
		$this->assertEqual($tmpObj->anonymous(), false);
		$this->assertEqual($tmpObj->min(), 1.1);
		$this->assertEqual($tmpObj->max(), 4.9);
	}
	
    
	
	function test_getRatingValue_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("idRequired"));
		$this->rating->getRatingValue();
	}
	
	function test_getRatingValue_nonanonymous_shouldFailForNoCreatedBy()
	{
		$this->rating->loadBy("min", 1.1);
		$this->rating->anonymous(false);
		
		$this->expectException(new Exception("createdByRequired"));
		$this->rating->getRatingValue(null);
	}
	
	function test_getRatingValue_anonymous_shouldReturnValue()
	{
		$this->rating->anonymous(true);
		$this->rating->save();
		$this->rating->rate(4, "foo");
		
		$this->assertEqual($this->rating->getRatingValue(null), 4);
		$this->assertEqual($this->rating->getRatingValue("foo bar"), 4);
	}
	
	function test_getRatingValue_nonanonymous_shouldReturnValue()
	{
		$this->rating->anonymous(false);
		$this->rating->save();
		$this->rating->rate(4, "foo bar");
		
		$this->assertEqual($this->rating->getRatingValue("foo"), null);
		$this->assertEqual($this->rating->getRatingValue("foo bar"), 4);
	}
	
	function test_rate_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("idRequired"));
		$this->rating->rate(4, null);
	}
	
	function test_rate_nonanonymous_shouldFailForNoCreatedBy()
	{
		$this->rating->anonymous(false);
		$this->rating->save();
		
		$this->expectException(new Exception("createdByRequired"));
		$this->rating->rate(3, null);
	}
	
	function test_rate_shouldFailForSmallRatingValue()
	{
		$this->rating->loadBy("min", 1.1);
		$this->rating->anonymous(true);
		
		$this->expectException(new Exception("valueTooSmall"));
		$this->rating->rate(1, null);
	}
	
	function test_rate_shouldFailForLargeRatingValue()
	{
		$this->rating->loadBy("min", 1.1);
		$this->rating->anonymous(true);
		
		$this->expectException(new Exception("valueTooLarge"));
		$this->rating->rate(5, null);
	}
	
	function test_rate_anonymous_shouldRateOnceAndTwice()
	{
		$this->rating->anonymous(true);
		$this->rating->save();
		$result = $this->rating->rate(3, null);
		
		$this->assertEqual($this->rating->average(), 3);
		$this->assertEqual($this->rating->numRatings(), 1);
		
		$this->rating->rate(2, null);
		
		$this->assertEqual($this->rating->average(), 2);
		$this->assertEqual($this->rating->numRatings(), 1);
		
		Wigbi::sessionHandler()->set("Rating_" . $this->rating->id(), null);	
		$this->rating->rate(3, null);
		
		$this->assertEqual($this->rating->average(), 2.5);
		$this->assertEqual($this->rating->numRatings(), 2);
	}
	
	function test_rate_nonanonymous_shouldRateOnceAndSeveralTimes()
	{
		$this->rating->anonymous(false);
		$this->rating->save();
		
		$this->rating->rate(3, "foo bar");
		$ratings = $this->rating->getListItems("ratings", 0, 10);
		$ratings = $ratings[0];
		$subRating = $ratings[0];
		
		$this->assertEqual($this->rating->average(), 3);
		$this->assertEqual($this->rating->numRatings(), 1);
		$this->assertEqual(sizeof($ratings), 1);
		$this->assertEqual($subRating->parentId(), $this->rating->id());
		$this->assertEqual($subRating->average(), 3);
		$this->assertEqual($subRating->createdBy(), "foo bar");
		
		$this->rating->rate(2, "foo bar");
		$ratings = $this->rating->getListItems("ratings");
		$ratings = $ratings[0];
		$subRating = $ratings[0];
		
		$this->assertEqual($this->rating->average(), 2);
		$this->assertEqual($this->rating->numRatings(), 1);
		$this->assertEqual(sizeof($ratings), 1);
		$this->assertEqual($subRating->parentId(), $this->rating->id());
		$this->assertEqual($subRating->average(), 2);
		$this->assertEqual($subRating->createdBy(), "foo bar");
		
		$this->rating->rate(3, "foo");
		$ratings = $this->rating->getListItems("ratings");
		$ratings = $ratings[0];
		$subRating = $ratings[1];
		
		$this->assertEqual($this->rating->average(), 2.5);
		$this->assertEqual($this->rating->numRatings(), 2);
		$this->assertEqual(sizeof($ratings), 2);
		$this->assertEqual($subRating->parentId(), $this->rating->id());
		$this->assertEqual($subRating->average(), 3);
		$this->assertEqual($subRating->createdBy(), "foo");
		
		$this->rating->deleteListItem("ratings", $subRating->id());
		
		$this->rating->rate(1, "foo");
		$ratings = $this->rating->getListItems("ratings");
		$ratings = $ratings[0];
		$subRating = $ratings[1];
		
		$this->assertEqual($this->rating->average(), 2);
		$this->assertEqual($this->rating->numRatings(), 3);
		$this->assertEqual(sizeof($ratings), 2);
		$this->assertEqual($subRating->parentId(), $this->rating->id());
		$this->assertEqual($subRating->average(), 1);
		$this->assertEqual($subRating->createdBy(), "foo");
	}
	
	function test_unrate_shouldFailForUnsavedObject()
	{
		$this->expectException(new Exception("idRequired"));
		$result = $this->rating->unrate(null);
	}
	
	function test_unrate_nonanonymous_shouldFailForNoCreatedBy()
	{
		$this->rating->loadBy("min", 1.1);
		$this->rating->anonymous(false);
		
		$this->expectException(new Exception("createdByRequired"));
		$result = $this->rating->unrate(null);
	}
	
	function test_unrate_shouldIgnoreForUnratedObject()
	{
		$this->rating->save();
		$result = $this->rating->unrate(null);
		
		$this->assertEqual($this->rating->average(), 0.0);
		$this->assertEqual($this->rating->numRatings(), 0);
	}
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->rating->min(5);
		$this->rating->max(1);
		
		$this->assertEqual($this->rating->validate(), array("minTooLarge"));
		
		$this->rating->min(1);
		$this->rating->max(5);
		
		$this->assertEqual($this->rating->validate(), array());
	}
}

?>