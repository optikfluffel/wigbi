$(document).ready(function()
{
	module("SearchFilter");
	
	
	
	test("constructor_shouldInitObject", 1, function()
	{
		var obj = new SearchFilter();
		
		equals(obj.className(), "SearchFilter");
	});
	
	
	
	test("groupRules_shouldGetSetValue", 3, function()
	{
		var obj = new SearchFilter();
		
		same(obj.groupRules(), []);
		same(obj.groupRules(["foo","bar"]), ["foo","bar"]);
		same(obj.groupRules(), ["foo","bar"]);
	});
	
	test("maxCount_shouldGetSetValue", 3, function()
	{
		var obj = new SearchFilter();
		
		same(obj.maxCount(), 25);
		same(obj.maxCount(50), 50);
		same(obj.maxCount(), 50);
	});
	
	test("searchRules_shouldGetSetValue", 3, function()
	{
		var obj = new SearchFilter();
		
		same(obj.searchRules(), []);
		same(obj.searchRules(["foo","bar"]), ["foo","bar"]);
		same(obj.searchRules(), ["foo","bar"]);
	});
	
	test("skipCount_shouldGetSetValue", 3, function()
	{
		var obj = new SearchFilter();
		
		same(obj.skipCount(), 0);
		same(obj.skipCount(50), 50);
		same(obj.skipCount(), 50);
	});
	
	test("sortRules_shouldGetSetValue", 3, function()
	{
		var obj = new SearchFilter();
		
		same(obj.sortRules(), []);
		same(obj.sortRules(["foo","bar"]), ["foo","bar"]);
		same(obj.sortRules(), ["foo","bar"]);
	});

	
	
	test("addGroupRule_shouldAddGroupRule", 2, function()
	{
		var obj = new SearchFilter();
		
		same(obj.groupRules(), []);
		
		obj.addGroupRule("foo");
		obj.addGroupRule("bar");
		
		same(obj.groupRules(), ["foo","bar"]);
	});
	
	test("addSearchRule_shouldAddSearchRule", 2, function()
	{
		var obj = new SearchFilter();
		
		same(obj.groupRules(), []);
		
		obj.addSearchRule("foo = 'bar'");
		obj.addSearchRule("bar = 'foo'");
		
		same(obj.searchRules(), ["foo = 'bar'","bar = 'foo'"]);
	});
	
	test("addSortRule_shouldAddSortRule", 2, function()
	{
		var obj = new SearchFilter();
		
		same(obj.groupRules(), []);
		
		obj.addSortRule("foo");
		obj.addSortRule("bar");
		
		same(obj.sortRules(), ["foo","bar"]);
	});
	
	test("setPaging_shouldSetSkipCountAndMaxCount", 4, function()
	{
		var obj = new SearchFilter();
		
		same(obj.skipCount(), 0);
		same(obj.maxCount(), 25);
		
		obj.setPaging(25, 50);
		
		same(obj.skipCount(), 25);
		same(obj.maxCount(), 50);
	});
	
	test("toString_shouldReturnCorrectQuery", 1, function()
	{
		var obj = new SearchFilter();
		
		obj.addSearchRule(" name='foo' ");
		obj.addSearchRule(" OR age=10 ");
		obj.addSortRule(" name ");
		obj.addSortRule(" age ");
		obj.addGroupRule(" name ");
		obj.addGroupRule(" age ");
		obj.setPaging(100, 200);
		
		var correctString = "WHERE name='foo' OR age=10";
		correctString += " ORDER BY name, age";
		correctString += " GROUP BY name, age";
		correctString += " LIMIT 100,200";
		
		equal(obj.toString(), correctString);
	});
});