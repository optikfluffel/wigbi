<?php

class SearchFilterBehavior extends UnitTestCase
{
	private $searchFilter;
	
	
	
	function SearchFilterBehavior()
	{
		$this->UnitTestCase("SearchFilter");
	}
	
	function setUp()
	{
		$this->searchFilter = new SearchFilter();
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_shouldInitializeDefaultObject()
	{
		$this->assertEqual($this->searchFilter->searchRules(), array());
		$this->assertEqual($this->searchFilter->sortRules(), array());
		$this->assertEqual($this->searchFilter->groupRules(), array());
		$this->assertEqual($this->searchFilter->maxCount(), 25);
		$this->assertEqual($this->searchFilter->skipCount(), 0);
	}
	
	function test_constructor_shouldInitializeCustomObject()
	{
		$this->searchFilter = new SearchFilter(array("name='Foo'", "age=10"), array("name", "age"), array("name", "age"), 50, 25);
		
		$this->assertEqual($this->searchFilter->searchRules(), array("name='Foo'", "age=10"));
		$this->assertEqual($this->searchFilter->sortRules(), array("name", "age"));
		$this->assertEqual($this->searchFilter->groupRules(), array("name", "age"));
		$this->assertEqual($this->searchFilter->maxCount(), 50);
		$this->assertEqual($this->searchFilter->skipCount(), 25);
	}
			
	
	
	function test_groupRules_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->searchFilter->groupRules(), array());
	}
	
	function test_groupRules_shouldSetValue()
	{
		$this->assertEqual($this->searchFilter->groupRules(array("name", "age")), array("name", "age"));
		$this->assertEqual($this->searchFilter->groupRules(), array("name", "age"));
	}
	
	function test_maxCount_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->searchFilter->maxCount(), 25);
	}
	
	function test_maxCount_shouldSetValue()
	{
		$this->assertEqual($this->searchFilter->maxCount(10), 10);
		$this->assertEqual($this->searchFilter->maxCount(), 10);
	}
	
	function test_searchRules_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->searchFilter->searchRules(), array());
	}
	
	function test_searchRules_shouldSetValue()
	{
		$this->assertEqual($this->searchFilter->searchRules(array("name='Foo'", "age=10")), array("name='Foo'", "age=10"));
		$this->assertEqual($this->searchFilter->searchRules(), array("name='Foo'", "age=10"));
	}
	
	function test_skipCount_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->searchFilter->skipCount(), 0);
	}
	
	function test_skipCount_shouldSetValue()
	{
		$this->assertEqual($this->searchFilter->skipCount(25), 25);
		$this->assertEqual($this->searchFilter->skipCount(), 25);
	}
	
	function test_sortRules_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->searchFilter->sortRules(), array());
	}
	
	function test_sortRules_shouldSetValue()
	{
		$this->assertEqual($this->searchFilter->sortRules(array("name", "age")), array("name", "age"));
		$this->assertEqual($this->searchFilter->sortRules(), array("name", "age"));
	}
	
	
	
	function test_addGroupRule_shouldAddTrimmedRules()
	{
		$this->searchFilter->addGroupRule(" name ");
		$this->searchFilter->addGroupRule(" age ");
		
		$this->assertEqual($this->searchFilter->groupRules(), array("name", "age"));
	}
	
	function test_addSearchRule_shouldAddTrimmedRules()
	{
		$this->searchFilter->addSearchRule(" name='foo' ");
		$this->searchFilter->addSearchRule(" age=10 ");
		
		$this->assertEqual($this->searchFilter->searchRules(), array("name='foo'", "age=10"));
	}
	
	function test_addSortRule_shouldAddTrimmedRules()
	{
		$this->searchFilter->addSortRule(" name ");
		$this->searchFilter->addSortRule(" age ");
		
		$this->assertEqual($this->searchFilter->sortRules(), array("name", "age"));
	}
	
	function test_setPaging_shouldSetProperties()
	{
		$this->searchFilter->setPaging(100, 200);
		
		$this->assertEqual($this->searchFilter->skipCount(), 100);
		$this->assertEqual($this->searchFilter->maxCount(), 200);
	}
	
	function test_toString_shouldReturnCorrectQuery()
	{
		$this->searchFilter->addSearchRule(" name='foo' ");
		$this->searchFilter->addSearchRule(" OR age=10 ");
		$this->searchFilter->addSortRule(" name ");
		$this->searchFilter->addSortRule(" age ");
		$this->searchFilter->addGroupRule(" name ");
		$this->searchFilter->addGroupRule(" age ");
		$this->searchFilter->setPaging(100, 200);
		
		$correctString  = "WHERE name='foo' OR age=10";
		$correctString .= " ORDER BY name, age";
		$correctString .= " GROUP BY name, age";
		$correctString .= " LIMIT 100,200";
		
		$this->assertEqual($this->searchFilter->toString(), $correctString);
	}
}

?>