$(document).ready(function()
{
	module("WigbiDataPlugin");
	
	var obj;
	var obj2;
	var obj2id;
	var obj3;
	
	
	
	test("constructor_shouldInitObject", 2, function()
	{
		var obj = new WigbiDataPlugin();
		
		equals(obj.className(), "WigbiDataPlugin");
	});
	
	

	test("id_shouldReturnCorrectValue", 1, function()
	{	
		var obj = new WigbiDataPlugin();
		
		equals(obj.id(), "");
	});
	
	
	
	// Save methods *******************************************
	
	asyncTest("save_shouldCreateIdForNewObject", 10, function()
	{	
		obj = new Rating();
		
		equals(obj.name("Rating"), "Rating");
		equals(obj.anonymous(true), true);
		equals(obj.min(1.5), 1.5);
		equals(obj._numRatings, 0);
		
		obj._numRatings = 5;
		
		obj.save(function(result) {
			equals(obj.id().length, 40);
			equals(obj.name(), "Rating");
			equals(obj.anonymous(), true);
			equals(obj.min(), 1.5);
			equals(obj.numRatings(), 5);
			same(obj, result);
			
			start();
		});
	});
	
	asyncTest("save_shouldCreateNewIdForDifferentObject", 4, function()
	{
		obj2 = new Rating();
		
		equals(obj2.name("Second object"), "Second object");
		
		obj2.save(function(result) {
			equals(obj2.id().length, 40);
			ok(obj2.id() != obj.id());
			same(obj2, result);
			
			start();
		});
	});
	
	asyncTest("save_shouldNotChangeIdForExistingObject", 2, function()
	{
		var id = obj2.id();
		
		obj2.save(function(result) {
			equals(obj2.id(), id);
			same(obj2, result);
			
			start();
		});
	});


	//Methods, excluding save & delete **************************
	
	asyncTest("load_shouldNotLoadForNonExistingId", 1, function()
	{	
		var tmpObj = new Rating();
		
		tmpObj.load("n/a", function() {
			equals(tmpObj.id(), "");
			
			start();
		});
	});
	
	asyncTest("load_shouldLoadForExistingId", 2, function()
	{	
		var tmpObj = new Rating();
		
		tmpObj.load(obj.id(), function(result) {
			same(tmpObj.id(), obj.id());
			same(tmpObj, result);
			
			start();
		});
	});
	
	asyncTest("loadBy_shouldNotFailForNonExistingProperty", 0, function()
	{
		start();
		//TODO: FIX
	});
	
	asyncTest("loadBy_shouldNotLoadForNonExistingPropertyValue", 1, function()
	{	
		var tmpObj = new Rating();
		
		tmpObj.loadBy("name", "n/a", function() {
			equals(tmpObj.id(), "");
			
			start();
		});
	});
	
	asyncTest("loadBy_shouldLoadForExistingPropertyValue", 2, function()
	{	
		var tmpObj = new Rating();
		
		tmpObj.loadBy("name", obj.name(), function(result) {
			same(tmpObj.id(), obj.id());
			same(tmpObj, result);
			
			start();
		});
	});
	
	asyncTest("loadMultiple_shouldLoadAllExistingObjects", 3, function()
	{	
		var tmpObj = new Rating();
		
		tmpObj.loadMultiple([obj.id(), obj2.id(), "nonexisting"], function(result) {
			equals(result.length, 2);
			same(result[0], obj);
			same(result[1], obj2);
			
			start();
		});
	});
	
	asyncTest("search_shouldReturnMatchingObjectsForSearchFilterObject", 4, function()
	{
		var tmpObj = new Rating();
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '" + obj.id().substring(0, 20) + "%'");
		
		tmpObj.search(searchFilter, function(result) {
			equals(result.length, 2);
			equals(result[0].length, 1);
			equals(result[1], 1);
			same(result[0][0], obj);
			
			start();
		});
	});
	
	asyncTest("search_shouldReturnMatchingObjectsForSearchFilterString", 4, function()
	{
		var tmpObj = new Rating();
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '" + obj.id().substring(0, 20) + "%'");
		searchFilter = searchFilter.toString();
		
		tmpObj.search(searchFilter, function(result) {
			equals(result.length, 2);
			equals(result[0].length, 1);
			equals(result[1], 1);
			same(result[0][0], obj);
			
			start();
		});
	});
	
	asyncTest("search_shouldApplyAscendingSort", 5, function()
	{
		var tmpObj = new Rating();
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '%'");
		searchFilter.addSortRule("name");
		
		tmpObj.search(searchFilter, function(result) {
			equals(result.length, 2);
			equals(result[0].length, 2);
			equals(result[1], 2);
			same(result[0][0], obj);
			same(result[0][1], obj2);
			
			start();
		});
	});
	
	asyncTest("search_shouldApplyDescendingSort", 5, function()
	{
		var tmpObj = new Rating();
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '%'");
		searchFilter.addSortRule("name DESC");
		
		tmpObj.search(searchFilter, function(result) {
			equals(result.length, 2);
			equals(result[0].length, 2);
			equals(result[1], 2);
			same(result[0][0], obj2);
			same(result[0][1], obj);
			
			start();
		});
	});
	
	asyncTest("search_shouldApplyPagingWithNoSkipCount", 4, function()
	{
		var tmpObj = new Rating();
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '%'");
		searchFilter.setPaging(0, 1);
		
		tmpObj.search(searchFilter, function(result) {
			equals(result.length, 2);
			equals(result[0].length, 1);
			equals(result[1], 2);
			same(result[0][0], obj);
			
			start();
		});
	});
	
	asyncTest("search_shouldApplyPagingWithSkipCount", 4, function()
	{
		var tmpObj = new Rating();
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '%'");
		searchFilter.setPaging(1, 10);
		
		tmpObj.search(searchFilter, function(result) {
			equals(result.length, 2);
			equals(result[0].length, 1);
			equals(result[1], 2);
			same(result[0][0], obj2);
			
			start();
		});
	});
	
	asyncTest("validate_shouldReturnPopulatedArrayForInvalidObject", 2, function()
	{
		var tmpObj = new Rating();
		tmpObj.min(10);
		tmpObj.max(5);
		
		tmpObj.validate(function(result) {
			equals(result.length, 1);
			equals(result[0], "min_tooLarge");
			
			start();
		});
	});
	
	asyncTest("validate_shouldReturnEmptyArrayForValidObject", 1, function()
	{
		obj2.validate(function(result) {
			equals(result.length, 0);
			
			start();
		});
	});
	
	
	//List methods *********************************************************
	
	asyncTest("addListItem_shouldReturnFalseForUnsavedParent", 1, function()
	{
		var tmpObj = new Rating();
		
		tmpObj.addListItem("ratings", obj.id(), function(result) {
			ok(!result);
			
			start();
		});
	});
	
	asyncTest("addListItem_shouldReturnFalseForUnsavedChild", 1, function()
	{
		obj.addListItem("ratings", "", function(result) {
			ok(!result);
			
			start();
		});
	});
	
	asyncTest("addListItem_shouldReturnFalseForInvalidList", 1, function()
	{
		obj.addListItem("nonExistingListName", obj2.id(), function(result) {
			ok(!result);
			
			start();
		});
	});
	
	asyncTest("addListItem_shouldReturnTrueForSavedChild", 1, function()
	{
		obj.addListItem("ratings", obj2.id(), function(result) {
			ok(result);
			
			start();
		});
	});
	 
	asyncTest("addListItem_shouldAddSecondObject", 1, function()
	{
		obj3 = new Rating();
		obj3.name("Third object");
		
		obj3.save(function(){
			obj.addListItem("ratings", obj3.id(), function(result) {
				ok(result);
				
				start();
			});
		});
	});
	
	asyncTest("searchListItems_shouldReturnMatchingObjectsForSearchFilterObject", 5, function()
	{
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '" + obj2.id().substring(0, 20) + "%'");
		
		obj.searchListItems("ratings", searchFilter, function(result) {
			equals(result.length, 3);
			equals(result[0].length, 1);
			equals(result[1], 1);
			equals(result[2], "Rating");
			same(result[0][0], obj2);
			
			start();
		});
	});
	
	asyncTest("searchListItems_shouldReturnMatchingObjectsForSearchFilterString", 5, function()
	{
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '" + obj2.id().substring(0, 20) + "%'");
		searchFilter = searchFilter.toString();
		
		obj.searchListItems("ratings", searchFilter, function(result) {
			equals(result.length, 3);
			equals(result[0].length, 1);
			equals(result[1], 1);
			equals(result[2], "Rating");
			same(result[0][0], obj2);
			
			start();
		});
	});
	
	asyncTest("searchListItems_shouldApplyAscendingSort", 5, function()
	{
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '%'");
		searchFilter.addSortRule("name");
		
		obj.searchListItems("ratings", searchFilter, function(result) {
			equals(result.length, 3);
			equals(result[0].length, 2);
			equals(result[1], 2);
			equals(result[2], "Rating");
			same(result[0][0], obj2);
			
			start();
		});
	});
	
	asyncTest("searchListItems_shouldApplyDescendingSort", 5, function()
	{
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '%'");
		searchFilter.addSortRule("name DESC");
		
		obj.searchListItems("ratings", searchFilter, function(result) {
			equals(result.length, 3);
			equals(result[0].length, 2);
			equals(result[1], 2);
			equals(result[2], "Rating");
			same(result[0][0], obj3);
			
			start();
		});
	});
	
	asyncTest("searchListItems_shouldApplyPagingWithNoSkipCount", 5, function()
	{
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '%'");
		searchFilter.addSortRule("name");
		searchFilter.setPaging(0, 1);
		
		obj.searchListItems("ratings", searchFilter, function(result) {
			equals(result.length, 3);
			equals(result[0].length, 1);
			equals(result[1], 2);
			equals(result[2], "Rating");
			same(result[0][0], obj2);
			
			start();
		});
	});
	
	asyncTest("searchListItems_shouldApplyPagingWithNoSkipCount", 5, function()
	{
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '%'");
		searchFilter.addSortRule("name");
		searchFilter.setPaging(1, 10);
		
		obj.searchListItems("ratings", searchFilter, function(result) {
			equals(result.length, 3);
			equals(result[0].length, 1);
			equals(result[1], 2);
			equals(result[2], "Rating");
			same(result[0][0], obj3);
			
			start();
		});
	});
	
	asyncTest("getListItems_shouldApplyPagingWithNoSkipCount", 5, function()
	{
		obj.getListItems("ratings", 0, 1, function(result) {
			equals(result.length, 3);
			equals(result[0].length, 1);
			equals(result[1], 2);
			equals(result[2], "Rating");
			same(result[0][0], obj2);
			
			start();
		});
	});
	
	asyncTest("getListItems_shouldApplyPagingWithNoSkipCount", 5, function()
	{
		obj.getListItems("ratings", 1, 10, function(result) {
			equals(result.length, 3);
			equals(result[0].length, 1);
			equals(result[1], 2);
			equals(result[2], "Rating");
			same(result[0][0], obj3);
			
			start();
		});
	});
	
	asyncTest("moveListItem_shouldMoveListItemForward", 2, function()
	{
		obj.moveListItem("ratings", obj2.id(), 10000, function(result) {
			ok(result);
			
			obj.getListItems("ratings", 1, 10, function(result) {
				same(result[0][0], obj2);
				
				start();
			});
		});
	});
	
	asyncTest("moveListItem_shouldMoveListItemBack", 2, function()
	{
		obj.moveListItem("ratings", obj2.id(), -10000, function(result) {
			ok(result);
			
			obj.getListItems("ratings", 0, 1, function(result) {
				same(result[0][0], obj2);
				
				start();
			});
		});
	});
	
	asyncTest("moveListItemLast_shouldMoveListItemLast", 2, function()
	{
		obj.moveListItemLast("ratings", obj2.id(), function(result) {
			ok(result);
			
			obj.getListItems("ratings", 1, 10, function(result) {
				same(result[0][0], obj2);
				
				start();
			});
		});
	});
	
	asyncTest("moveListItemFirst_shouldMoveListItemFirst", 2, function()
	{
		obj.moveListItemFirst("ratings", obj2.id(), function(result) {
			ok(result);
			
			obj.getListItems("ratings", 0, 1, function(result) {
				same(result[0][0], obj2);
				
				start();
			});
		});
	});
	
	
	//Delete methods ********************************************************

	asyncTest("deleteObject_shouldReturnFalseForUnsavedObject", 1, function()
	{
		var tmpObj = new Rating();
		
		tmpObj.deleteObject(function(result) {
			ok(!result);
			
			start();
		});
	});
	
	asyncTest("deleteObject_shouldResetAndDeleteSavedObject", 3, function()
	{	
		obj2id = obj2.id();
		
		obj2.deleteObject(function(result) {
			ok(result);
			equals(obj2.id(), "");
			
			var tmpObj = new Rating();
			tmpObj.load(obj2id, function(result) {
				equals(tmpObj.id(), "");
				
				start();
			});
		});
	});
	
	asyncTest("deleteObject_shouldCauseListItemToRemoveItself", 4, function()
	{
		var searchFilter = new SearchFilter();
		searchFilter.addSearchRule("id LIKE '" + obj2id.substring(0, 20) + "%'");
		searchFilter = searchFilter.toString();
		
		obj.searchListItems("ratings", searchFilter, function(result) {
			equals(result.length, 3);
			equals(result[0].length, 0);
			equals(result[1], 0);
			equals(result[2], "Rating");
			
			start();
		});
	});

	asyncTest("deleteListItem_shouldDeleteListItemAndIfSyncedDeleteObject", 6, function()
	{
		obj.deleteListItem("ratings", obj3.id(), function(result) {
			ok(result);
			
			var searchFilter = new SearchFilter();
			searchFilter.addSearchRule("id LIKE '" + obj3.id().substring(0, 20) + "%'");
			searchFilter = searchFilter.toString();
			
			obj.searchListItems("ratings", searchFilter, function(result) {
				equals(result.length, 3);
				equals(result[0].length, 0);
				equals(result[1], 0);
				equals(result[2], "Rating");
				
				var tmpObj = new Rating();
				tmpObj.load(obj3.id(), function(result) {
					equals(tmpObj.id(), "");
					
					start();
				});
			});
		});
	});
});