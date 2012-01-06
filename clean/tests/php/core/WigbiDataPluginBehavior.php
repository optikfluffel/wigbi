<?php

class WigbiDataPluginBehavior extends UnitTestCase
{
	function WigbiDataPluginBehavior()
	{
  	$this->UnitTestCase('WigbiDataPlugin');
		
		WigbiDataPlugin::autoReset(false);
		$obj = new MyDatabaseClass();
		$obj->setupDatabase();
		WigbiDataPlugin::autoReset(true);
	}
	
	function setUp()
	{
		$this->deleteData();
	}
	
	function tearDown()
	{
		$this->deleteData();
	}
	
	function deleteData()
	{
		Wigbi::dbHandler()->query("DELETE FROM MyDatabaseClasses");
		Wigbi::dbHandler()->query("DELETE FROM MyDatabaseClass_objects");
		Wigbi::dbHandler()->query("DELETE FROM MyDatabaseClass_objects_synced");
	}
	
	
	
	function test_constructor_shouldNotAutoResetObjectIfFeatureIsDisabled()
	{
		WigbiDataPlugin::autoReset(false);
		$obj = new MyPlugin();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($obj->id(), "__GUID");
		$this->assertEqual(substr(WigbiDataPlugin::getVariableDatabaseType($obj->id()), 0, 11), "VARCHAR(40)");
		$this->assertEqual(WigbiDataPlugin::getVariableType($obj->id()), "GUID");
		$this->assertEqual(WigbiDataPlugin::getVariableValue($obj->id()), "");
	}
	
	function test_constructor_shouldAutoResetObjectByDefault()
	{
		$obj = new MyPlugin();
		
		$this->assertEqual($obj->id(), "");
	}

	
	
	function test_ajaxFunctions_shouldBeEmptyArrayByDefault()
	{
		$obj = new MyPlugin();
		 
		$this->assertEqual(gettype($obj->ajaxFunctions()), "array");
	}
	
	function test_className_shouldReturnCorrectValue()
	{
		$obj = new MyParty(); 
		
		$this->assertEqual($obj->className(), "MyParty");
	}
	
	function test_collectionName_shouldReturnCorrectDefaultValueForEndingY()
	{
		$obj = new MyParty(); 
		
		$this->assertEqual($obj->collectionName(), "MyParties");
	}
	
	function test_collectionName_shouldReturnCorrectDefaultValueForEndingS()
	{
		$obj = new MyBus(); 
		
		$this->assertEqual($obj->collectionName(), "MyBuses");
	}
	
	function test_collectionName_shouldReturnCorrectDefaultValueForEndingX()
	{
		$obj = new MyBox(); 
		
		$this->assertEqual($obj->collectionName(), "MyBoxes");
	}
	
	function test_collectionName_shouldReturnCorrectDefaultValueForEndingCH()
	{
		$obj = new MyLunch(); 
		
		$this->assertEqual($obj->collectionName(), "MyLunches");
	}
	
	function test_collectionName_shouldReturnCorrectDefaultValueForEndingSH()
	{
		$obj = new MyCash(); 
		
		$this->assertEqual($obj->collectionName(), "MyCashes");
	}
	
	function test_collectionName_shouldReturnCorrectDefaultValueForEndingSS()
	{
		$obj = new MyPass(); 
		
		$this->assertEqual($obj->collectionName(), "MyPasses");
	}

	function test_collectionName_shouldSetValue()
	{
		$obj = new MyPass();
		
		$this->assertEqual($obj->collectionName("foo bar"), "foo bar");
		$this->assertEqual($obj->collectionName(), "foo bar");
	}
	
	function test_databaseVariables_shouldReturnAllPublicVariables()
	{
		$obj = new MyDatabaseClass();
		$variables = $obj->databaseVariables();

		$this->assertEqual(sizeof($variables), 14);

		$this->assertTrue(in_array("_id", $variables));
		$this->assertTrue(in_array("_createdDateTime", $variables));
		$this->assertTrue(in_array("_lastUpdatedDateTime", $variables));
		
		$this->assertTrue(in_array("_name", $variables));
		$this->assertTrue(in_array("_age", $variables));
		$this->assertTrue(in_array("_grade", $variables));
		$this->assertTrue(in_array("_date", $variables));
		$this->assertTrue(in_array("_dateTime", $variables));
		$this->assertTrue(in_array("_timeStamp", $variables));
		$this->assertTrue(in_array("_time", $variables));
		$this->assertTrue(in_array("_noValue", $variables));
		$this->assertTrue(in_array("_noType", $variables));
		$this->assertTrue(in_array("_text", $variables));
		$this->assertTrue(in_array("_bool", $variables));
		
		$this->assertFalse(in_array("_private", $variables));
		$this->assertFalse(in_array("_protected", $variables));
	}
	
	function test_databaseVariables_base_shouldReturnAllPublicBaseClassVariables()
	{
		$obj = new MyDatabaseClass();
		$variables = $obj->databaseVariables_base();

		$this->assertEqual(sizeof($variables), 3);
		
		$this->assertTrue(in_array("_id", $variables));
		$this->assertTrue(in_array("_createdDateTime", $variables));
		$this->assertTrue(in_array("_lastUpdatedDateTime", $variables));
	}
	
	function test_databaseVariables_self_shouldReturnAllPublicClassVariables()
	{
		$obj = new MyDatabaseClass();
		$variables = $obj->databaseVariables_self();

		$this->assertEqual(sizeof($variables), 11);

		$this->assertTrue(in_array("_name", $variables));
		$this->assertTrue(in_array("_age", $variables));
		$this->assertTrue(in_array("_grade", $variables));
		$this->assertTrue(in_array("_date", $variables));
		$this->assertTrue(in_array("_dateTime", $variables));
		$this->assertTrue(in_array("_timeStamp", $variables));
		$this->assertTrue(in_array("_time", $variables));
		$this->assertTrue(in_array("_noValue", $variables));
		$this->assertTrue(in_array("_noType", $variables));
		$this->assertTrue(in_array("_text", $variables));
		$this->assertTrue(in_array("_bool", $variables));
		
		$this->assertFalse(in_array("_private", $variables));
		$this->assertFalse(in_array("_protected", $variables));
	}
	
	function test_lists_shouldReturnCorrectValue()
	{
		$obj = new MyDatabaseClass();
		
		$this->assertEqual(sizeof($obj->lists()), 3);
	}
	
	function test_id_shouldReturnCorrectDefaultValue()
	{
		$obj = new MyDatabaseClass();
		
		$this->assertEqual($obj->id(), "");
	}
		
	function test_publicVariables_shouldOnlyReturnPublicVariables()
	{
		$obj = new MyDatabaseClass();
		$variables = $obj->publicVariables();

		$this->assertEqual(sizeof($variables), 14);

		$this->assertTrue(in_array("_id", $variables));
		$this->assertTrue(in_array("_createdDateTime", $variables));
		$this->assertTrue(in_array("_lastUpdatedDateTime", $variables));

		$this->assertTrue(in_array("_name", $variables));
		$this->assertTrue(in_array("_age", $variables));
		$this->assertTrue(in_array("_grade", $variables));
		$this->assertTrue(in_array("_date", $variables));
		$this->assertTrue(in_array("_dateTime", $variables));
		$this->assertTrue(in_array("_timeStamp", $variables));
		$this->assertTrue(in_array("_time", $variables));
		$this->assertTrue(in_array("_noValue", $variables));
		$this->assertTrue(in_array("_noType", $variables));
		$this->assertTrue(in_array("_text", $variables));
		$this->assertTrue(in_array("_bool", $variables));
		
		$this->assertFalse(in_array("_private", $variables));
		$this->assertFalse(in_array("_protected", $variables));
	}
	
	
	
	function test_addListItem_shouldReturnFalseForUnsavedParent()
	{
		$obj = new MyDatabaseClass();
		$child = new MyDatabaseClass();
		$child->save();
		
		$this->assertFalse($obj->addListItem("objects", $child->id()));
	}
	
	function test_addListItem_shouldReturnFalseForUnsavedChild()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		
		$this->assertFalse($obj->addListItem("objects", $child->id()));
	}
	
	function test_addListItem_shouldReturnFalseForInvalidList()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		$child->save();
		
		$this->assertFalse($obj->addListItem("invalid", $child->id()));
	}
	
	function test_addListItem_shouldReturnFalseForInvalidObject()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$this->assertFalse($obj->addListItem("objects", "invalid"));
	}
	
	function test_addListItem_shouldReturnTrueAndInsertValidObject()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		$child->save();
		
		$result = $obj->addListItem("objects", $child->id());
		Wigbi::dbHandler()->query("SELECT * FROM MyDatabaseClass_objects WHERE ownerId = '" . $obj->id() . "' AND itemId = '" . $child->id() . "'");
		$row = 	Wigbi::dbHandler()->getNextRow();
		
		$this->assertTrue($result);
		$this->assertEqual($row["ownerId"], $obj->id());
		$this->assertEqual($row["itemId"], $child->id());
		$this->assertEqual($row["position"], 1);
	}
	
	function test_delete_shouldReturnFalseForUnsavedObject()
	{
		$obj = new MyDatabaseClass();
		
		$this->assertFalse($obj->delete());
	}
	
	function test_delete_shouldDeleteObject()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$id = $obj->id();
		
		$this->assertEqual(strlen($id), 40);
		$this->assertTrue($obj->delete());
		$this->assertEqual($obj->id(), "");
		
		$loadPlugin = new MyDatabaseClass();
		$loadPlugin->load($id);
		
		$this->assertEqual($loadPlugin->id(), "");
	}
	
	function test_delete_shouldOnlyDeleteListItemsForNonSyncedList()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		$child->save();
		$id1 = $child->id();
		$child = new MyDatabaseClass();
		$child->save();
		$id2 = $child->id();
		
		$this->assertTrue($obj->addListItem("objects", $id1));
		$this->assertTrue($obj->addListItem("objects", $id2));
		$this->assertTrue($obj->delete());
		$this->assertFalse($obj->getListItems("objects", 0, 10));
		
		$child = new MyDatabaseClass();
		$child->load($id1);
		
		$this->assertEqual($child->id(), $id1);
		
		$child = new MyDatabaseClass();
		$child->load($id2);
		
		$this->assertEqual($child->id(), $id2);	
	}
	
	function test_delete_shouldDeleteListItemsAndObjectsForSyncedList()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		$child->save();
		$id1 = $child->id();
		$child = new MyDatabaseClass();
		$child->save();
		$id2 = $child->id();
		
		$this->assertTrue($obj->addListItem("objects_synced", $id1));
		$this->assertTrue($obj->addListItem("objects_synced", $id2));
		$this->assertTrue($obj->delete());
		$this->assertFalse($obj->getListItems("objects_synced", 0, 10));
		
		$child = new MyDatabaseClass();
		$child->load($id1);
		
		$this->assertEqual($child->id(), "");
		
		$child = new MyDatabaseClass();
		$child->load($id2);
		
		$this->assertEqual($child->id(), "");	
	}
	
	function test_delete_shouldDeleteFiles()
	{
		$target = Wigbi::serverRoot() . "tests/resources/_tinyMce.css";
		$source = Wigbi::serverRoot() . "tests/resources/tmp.txt";
		if (file_exists($source))
			unlink($source);
		
		$this->assertFalse(file_exists($source));
		
		copy($target, $source);
	
		$this->assertTrue(file_exists($source));
		
		$obj = new MyDatabaseClass();
		$obj->_noValue = "tests/resources/tmp.txt"; 
		$obj->save();
		$obj->delete();
		
		$this->assertFalse(file_exists($source));
	}
	
	function test_deleteListItem_shouldReturnFalseForUnsavedParent()
	{
		$obj = new MyDatabaseClass();
		$child = new MyDatabaseClass();
		$child->save();
		
		$this->assertFalse($obj->deleteListItem("objects", $child->id()));
	}
	
	function test_deleteListItem_shouldReturnFalseForInvalidList()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		$child->save();
		
		$this->assertFalse($obj->deleteListItem("invalid", $child->id()));
	}
	
	function test_deleteListItem_shouldReturnFalseForInvalidObject()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		$child->save();
		
		$this->assertFalse($obj->deleteListItem("objects", "invalid"));
	}
	
	function test_deleteListItem_shouldOnlyDeleteListItemForNonSyncedList()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		$child->save();
		
		$id = $child->id();
		
		$this->assertTrue($obj->addListItem("objects", $id));
		
		$exists = $obj->searchListItems("objects", "WHERE id = '" . $id . "'");
		
		$this->assertEqual(sizeof($exists[0]), 1);
		$this->assertTrue($obj->deleteListItem("objects", $id));
		
		$exists = $obj->searchListItems("objects", "WHERE id = '" . $id . "'");
		
		$this->assertEqual(sizeof($exists[0]), 0);
		
		$child = new MyDatabaseClass();
		$child->load($id);
		
		$this->assertEqual($child->id(), $id);			
	}
	
	function test_deleteListItem_shouldDeleteListItemAndObjectForSyncedList()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		$child->save();
		
		$id = $child->id();
		
		$this->assertTrue($obj->addListItem("objects_synced", $id));
		
		$exists = $obj->searchListItems("objects_synced", "WHERE id = '" . $id . "'");
		
		$this->assertEqual(sizeof($exists[0]), 1);
		$this->assertTrue($obj->deleteListItem("objects_synced", $id));
		
		$exists = $obj->searchListItems("objects_synced", "WHERE id = '" . $id . "'");
		
		$this->assertEqual(sizeof($exists[0]), 0);
		
		$child = new MyDatabaseClass();
		$child->load($id);
		
		$this->assertEqual($child->id(), "");
	}
		
	function test_getList_shouldReturnObjectForExistingList()
	{
		$obj = new MyDatabaseClass();

		$this->assertNotNull($obj->getList("objects"));
	}
	
	function test_getList_shouldReturnNullForNonExistingList()
	{
		$obj = new MyDatabaseClass();

		$this->assertNull($obj->getList("images"));
	}
	
	function test_getListItems_shouldReturnFalseForUnsavedParent()
	{
		$obj = new MyDatabaseClass();
		
		$this->assertFalse($obj->getListItems("objects", 0, 1));
	}
	
	function test_getListItems_shouldReturnFalseForInvalidList()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$this->assertFalse($obj->getListItems("invalid", 0, 1));
	}
	
	function test_getListItems_shouldAutoDeleteNonExistingItems()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child->delete();
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$result = $obj->getListItems("objects", 0, 1);
		$objects = $result[0];
		$object = $objects[0];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 1);
		$this->assertEqual($object->_name, "Robert");
		$this->assertEqual($result[1], 3);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_getListItems_shouldReturnListAndTotalCount()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$result = $obj->getListItems("objects", 0, 1);
		$objects = $result[0];
		$object = $objects[0];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 1);
		$this->assertEqual($object->_name, "Robert");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_getListItems_shouldReturnSortedListAndTotalCount()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects_sorted", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects_sorted", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects_sorted", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects_sorted", $child->id()));
		
		$result = $obj->getListItems("objects_sorted", 0, 1);
		$objects = $result[0];
		$object = $objects[0];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 1);
		$this->assertEqual($object->_name, "Agatha Cristie");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_getVariableDatabaseType_shouldReturnCorrectType()
	{
		$charSet = " CHARACTER SET utf8 COLLATE utf8_unicode_ci ";
		
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType(true), "BINARY");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType(20), "integer");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType(20.0), "double");
		
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo"), "VARCHAR(255) $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("__20"), "VARCHAR(20) $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__20"), "VARCHAR(20) $charSet");
		
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__DATE"), "DATE");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__DATETIME"), "DATETIME");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__TIME"), "TIME");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__TIMESTAMP"), "TIMESTAMP");
		
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__VARCHAR(30)"), "VARCHAR(30) $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__TEXT"), "TEXT $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__MEDIUMTEXT"), "MEDIUMTEXT $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__LONGTEXT"), "LONGTEXT $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__TINYTEXT"), "TINYTEXT $charSet");
		
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__FILE"), "VARCHAR(255) $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType("Foo__GUID"), "VARCHAR(40)");
	}
	
	function test_getVariableDatabaseType_shouldReturnCorrectTypeForObject()
	{
		WigbiDataPlugin::autoReset(false);
		$obj = new MyDatabaseClass();
		WigbiDataPlugin::autoReset(true);
		
		$charSet = " CHARACTER SET utf8 COLLATE utf8_unicode_ci ";
		
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_name), "VARCHAR(20) $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_age), "integer");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_grade), "double");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_date), "DATE");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_dateTime), "DATETIME");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_timeStamp), "TIMESTAMP");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_time), "TIME");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_noValue), "VARCHAR(255) $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_noType), "VARCHAR(255) $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_text), "TEXT $charSet");
		$this->assertEqual(WigbiDataPlugin::getVariableDatabaseType($obj->_bool), "BINARY");
	}
	
	function test_getVariableType_shouldReturnCorrectType()
	{
		$this->assertEqual(WigbiDataPlugin::getVariableType(true), "boolean");
		$this->assertEqual(WigbiDataPlugin::getVariableType(20), "integer");
		$this->assertEqual(WigbiDataPlugin::getVariableType(20.0), "double");
		
		$this->assertEqual(WigbiDataPlugin::getVariableType("Foo"), "255");
		$this->assertEqual(WigbiDataPlugin::getVariableType("__20"), "20");
		$this->assertEqual(WigbiDataPlugin::getVariableType("Foo__20"), "20");
		
		$this->assertEqual(WigbiDataPlugin::getVariableType("Foo__DATE"), "DATE");
		$this->assertEqual(WigbiDataPlugin::getVariableType("Foo__DATETIME"), "DATETIME");
		$this->assertEqual(WigbiDataPlugin::getVariableType("Foo__TIME"), "TIME");
		$this->assertEqual(WigbiDataPlugin::getVariableType("Foo__TIMESTAMP"), "TIMESTAMP");
		
		$this->assertEqual(WigbiDataPlugin::getVariableType("Foo__FILE"), "FILE");
		$this->assertEqual(WigbiDataPlugin::getVariableType("Foo__User"), "User");
		$this->assertEqual(WigbiDataPlugin::getVariableType("Foo__GUID"), "GUID");
	}
	
	function test_getVariableValue_shouldReturnCorrectValue()
	{
		$obj = new MyDatabaseClass();
		
		$this->assertEqual(WigbiDataPlugin::getVariableValue($obj->_name), "foo");
		$this->assertEqual(WigbiDataPlugin::getVariableValue($obj->_age), 20);
		$this->assertEqual(WigbiDataPlugin::getVariableValue($obj->_grade), 10.0);
		$this->assertEqual(WigbiDataPlugin::getVariableValue($obj->_date), "");
		$this->assertEqual(WigbiDataPlugin::getVariableValue($obj->_dateTime), "");
		$this->assertEqual(WigbiDataPlugin::getVariableValue($obj->_time), "");
		$this->assertEqual(WigbiDataPlugin::getVariableValue($obj->_timeStamp), "");
		$this->assertEqual(WigbiDataPlugin::getVariableValue($obj->_noValue), "");
		$this->assertEqual(WigbiDataPlugin::getVariableValue($obj->_noType), "foo");
	}
	
	function test_load_shouldCallLoadByWithId()
	{
		$obj = new MyDatabaseClass();
		$obj->_name = "'bar'";
		$obj->save();
		
		$this->assertEqual(strlen($obj->id()), 40);
		
		$loadObj = new MyDatabaseClass();
		$loadObj->load($obj->id());
		
		$this->assertEqual($obj->id(), $loadObj->id());
		$this->assertEqual($obj->_name, $loadObj->_name);
	}
	
	function test_loadBy_shouldNotFailForNonExistingProperty()
	{
		//TODO: Handle nonexisting row
	}
	
	function test_loadBy_shouldResetObjectForNonExistingPropertyValue()
	{
		$obj = new MyDatabaseClass();
		$obj->loadBy("id", "none");
		
		$this->assertEqual($obj->_name, "foo");
		$this->assertEqual($obj->_age, 20);
		$this->assertEqual($obj->_grade, 10.0);
		$this->assertEqual($obj->_date, "");
		$this->assertEqual($obj->_dateTime, "");
		$this->assertEqual($obj->_time, "");
		$this->assertEqual($obj->_timeStamp, "");
		$this->assertEqual($obj->_noValue, "");
		$this->assertEqual($obj->_noType, "foo");
	}
	
	function test_loadBy_shouldFullyInitializeObject()
	{
		$time = mktime(0, 0, 0, 7, 1, 2000);
		
		$obj = new MyDatabaseClass();
		$obj->_name = "'foobar'";
		$obj->_age = 30;
		$obj->_grade = 5.0;
		$obj->_date = $time;
		$obj->_dateTime = $time;
		$obj->_time = $time;
		$obj->_timeStamp = $time;
		$obj->_noValue = "bar";
		$obj->_noType = "bar";
		$obj->save();
		
		$loadObj = new MyDatabaseClass();
		$loadObj->loadBy("name", "'foobar'");
		
		$this->assertEqual(strlen($obj->id()), 40);
		$this->assertEqual($obj->id(), $loadObj->id());
		$this->assertEqual($obj->_name, $loadObj->_name);
		$this->assertEqual($obj->_age, $loadObj->_age);
		$this->assertEqual($obj->_grade, $loadObj->_grade);
		$this->assertEqual($obj->_date, $loadObj->_date);
		$this->assertEqual($obj->_dateTime, $loadObj->_dateTime);
		$this->assertEqual($obj->_time, $loadObj->_time);
		$this->assertEqual($obj->_timeStamp, $loadObj->_timeStamp);
		$this->assertEqual($obj->_noValue, $loadObj->_noValue);
		$this->assertEqual($obj->_noType, $loadObj->_noType);
		
		foreach ($loadObj->lists() as $list)
			$this->assertEqual($list->ownerId(), $loadObj->id());
	}
	
	function test_loadMultiple_shouldReturnLoadedObjectsInOrder()
	{
		$obj = new MyDatabaseClass();
		$ids = array("n/a");
		
		for ($i=0; $i<10; $i++)
		{
			$obj = new MyDatabaseClass();
			$obj->save();
			array_push($ids, $obj->id());
			
			$this->assertEqual(strlen($obj->id()), 40);
		}
		
		$result = $obj->loadMultiple(array_reverse($ids));
		
		$this->assertEqual(sizeof($result), 10);
		
		for ($i=0; $i<10; $i++)
		{
			$object = $result[$i];
			
			$this->assertEqual($ids[10-$i], $object->id());
		}
	}
	
	function test_loadOrInit_shouldInitWithObject()
	{
		$obj = new MyDatabaseClass();
		$obj2 = new MyDatabaseClass();
		$obj2->_name = "foo bar";
		$obj = $obj->loadOrInit($obj2);
		
		$this->assertEqual($obj, $obj2);
	}
	
	function test_loadOrInit_shouldInitWithObjectId()
	{
		$obj = new MyDatabaseClass();
		$obj2 = new MyDatabaseClass();
		$obj2->_name = "foo bar";
		$obj2->save();
		$obj = $obj->loadOrInit($obj2->id());
		
		$this->assertEqual($obj, $obj2);
	}
	
	function test_loadOrInit_shouldInitWithLoadByProperty()
	{
		$obj = new MyDatabaseClass();
		$obj2 = new MyDatabaseClass();
		$obj2->_name = "foo bar";
		$obj2->save();
		$obj = $obj->loadOrInit("", "foo bar", "name");
		
		$this->assertEqual($obj, $obj2);
	}
	
	function test_moveListItem_shouldFailForUnsavedParent()
	{
		$obj = new MyDatabaseClass();
		$child = new MyDatabaseClass();
		$child->save();
		
		$this->expectException('Exception');
		$obj->moveListItem("objects", $child->id(), 1);
	}
	
	function test_moveListItem_shouldFailForInvalidList()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		$child->save();
		
		$this->expectException('Exception');
		$obj->moveListItem("invalid", $child->id(), 1);
	}
	
	function test_moveListItem_shouldFailForInvalidObject()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		$child = new MyDatabaseClass();
		$child->save();
		
		$this->expectException('Exception');
		$obj->moveListItem("objects", "invalid", 1);
	}
	
	function test_moveListItem_shouldMoveItemForward()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($obj0->_name, "Robert");
		$this->assertEqual($obj1->_name, "Robbie Robertson");
		$this->assertEqual($obj2->_name, "Agatha Cristie");
		$this->assertEqual($obj3->_name, "Roberta");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
		$this->assertTrue($obj->moveListItem("objects", $obj0->id(), 2));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($obj0->_name, "Robbie Robertson");
		$this->assertEqual($obj1->_name, "Agatha Cristie");
		$this->assertEqual($obj2->_name, "Robert");
		$this->assertEqual($obj3->_name, "Roberta");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_moveListItem_shouldHandleHighStepNumber()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($obj0->_name, "Robert");
		$this->assertEqual($obj1->_name, "Robbie Robertson");
		$this->assertEqual($obj2->_name, "Agatha Cristie");
		$this->assertEqual($obj3->_name, "Roberta");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
		$this->assertTrue($obj->moveListItem("objects", $obj0->id(), 20));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($obj0->_name, "Robbie Robertson");
		$this->assertEqual($obj1->_name, "Agatha Cristie");
		$this->assertEqual($obj2->_name, "Roberta");
		$this->assertEqual($obj3->_name, "Robert");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_moveListItem_shouldMoveItemBackwards()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($obj0->_name, "Robert");
		$this->assertEqual($obj1->_name, "Robbie Robertson");
		$this->assertEqual($obj2->_name, "Agatha Cristie");
		$this->assertEqual($obj3->_name, "Roberta");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
		$this->assertTrue($obj->moveListItem("objects", $obj3->id(), -2));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($obj0->_name, "Robert");
		$this->assertEqual($obj1->_name, "Roberta");
		$this->assertEqual($obj2->_name, "Robbie Robertson");
		$this->assertEqual($obj3->_name, "Agatha Cristie");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_moveListItem_shouldHandleLowStepNumber()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
		$this->assertTrue($obj->moveListItem("objects", $obj3->id(), -20));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($obj0->_name, "Roberta");
		$this->assertEqual($obj1->_name, "Robert");
		$this->assertEqual($obj2->_name, "Robbie Robertson");
		$this->assertEqual($obj3->_name, "Agatha Cristie");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_moveListItemFirst_shouldMoveItemFirst()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
		$this->assertTrue($obj->moveListItemFirst("objects", $obj3->id()));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($obj0->_name, "Roberta");
		$this->assertEqual($obj1->_name, "Robert");
		$this->assertEqual($obj2->_name, "Robbie Robertson");
		$this->assertEqual($obj3->_name, "Agatha Cristie");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_moveListItemLast_shouldMoveItemLast()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($obj0->_name, "Robert");
		$this->assertEqual($obj1->_name, "Robbie Robertson");
		$this->assertEqual($obj2->_name, "Agatha Cristie");
		$this->assertEqual($obj3->_name, "Roberta");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
		$this->assertTrue($obj->moveListItemLast("objects", $obj0->id()));
		
		$result = $obj->getListItems("objects", 0, 10);
		$objects = $result[0];
		$obj0 = $objects[0];
		$obj1 = $objects[1];
		$obj2 = $objects[2];
		$obj3 = $objects[3];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 4);
		$this->assertEqual($obj0->_name, "Robbie Robertson");
		$this->assertEqual($obj1->_name, "Agatha Cristie");
		$this->assertEqual($obj2->_name, "Roberta");
		$this->assertEqual($obj3->_name, "Robert");
		$this->assertEqual($result[1], 4);
		$this->assertEqual($result[2], "MyDatabaseClass");
}
	
	function test_parseArray_shouldHandleAllSupportedTypes()
	{
		$time = mktime(0, 0, 0, 7, 1, 2000);
		
		$data = array();
		$data["id"] = "myId";
		$data["name"] = "foo bar";
		$data["age"] = 30;
		$data["grade"] = 5.0;
		$data["date"] = $time;
		$data["dateTime"] = $time;
		$data["time"] = $time;
		$data["timeStamp"] = $time;
		$data["noValue"] = "yes, now";
		$data["noType"] = "still no";
		
		$obj = new MyDatabaseClass();
		$obj->parseArray($data);
		
		$this->assertEqual($obj->_id, "myId");
		$this->assertEqual($obj->_name, "foo bar");
		$this->assertEqual($obj->_age, 30);
		$this->assertEqual($obj->_grade, 5.0);
		$this->assertEqual($obj->_date, $time);
		$this->assertEqual($obj->_dateTime, $time);
		$this->assertEqual($obj->_time, $time);
		$this->assertEqual($obj->_timeStamp, $time);
		$this->assertEqual($obj->_noValue, "yes, now");
		$this->assertEqual($obj->_noType, "still no");
	}

	function test_parseJson_shouldHandleAllSupportedTypes()
	{
		$time = mktime(0, 0, 0, 7, 1, 2000);
		
		$data = array();
		$data["id"] = "myId";
		$data["name"] = "foo bar";
		$data["age"] = 30;
		$data["grade"] = 5.0;
		$data["date"] = $time;
		$data["dateTime"] = $time;
		$data["time"] = $time;
		$data["timeStamp"] = $time;
		$data["noValue"] = "yes, now";
		$data["noType"] = "still no";
		
		$obj = new MyDatabaseClass();
		$obj->parseJson(json_encode($data));
		
		$this->assertEqual($obj->_id, "myId");
		$this->assertEqual($obj->_name, "foo bar");
		$this->assertEqual($obj->_age, 30);
		$this->assertEqual($obj->_grade, 5.0);
		$this->assertEqual($obj->_date, $time);
		$this->assertEqual($obj->_dateTime, $time);
		$this->assertEqual($obj->_time, $time);
		$this->assertEqual($obj->_timeStamp, $time);
		$this->assertEqual($obj->_noValue, "yes, now");
		$this->assertEqual($obj->_noType, "still no");
	}
	
	function test_parseObject_shouldHandleAllSupportedTypes()
	{
		$time = mktime(0, 0, 0, 7, 1, 2000);
		
		$data = array();
		$data["id"] = "myId";
		$data["name"] = "foo bar";
		$data["age"] = 30;
		$data["grade"] = 5.0;
		$data["date"] = $time;
		$data["dateTime"] = $time;
		$data["time"] = $time;
		$data["timeStamp"] = $time;
		$data["noValue"] = "yes, now";
		$data["noType"] = "still no";
		
		$obj = new MyDatabaseClass();
		$obj->parseObject(json_decode(json_encode($data)));
		
		$this->assertEqual($obj->_id, "myId");
		$this->assertEqual($obj->_name, "foo bar");
		$this->assertEqual($obj->_age, 30);
		$this->assertEqual($obj->_grade, 5.0);
		$this->assertEqual($obj->_date, $time);
		$this->assertEqual($obj->_dateTime, $time);
		$this->assertEqual($obj->_time, $time);
		$this->assertEqual($obj->_timeStamp, $time);
		$this->assertEqual($obj->_noValue, "yes, now");
		$this->assertEqual($obj->_noType, "still no");
	}
	
	function test_registerAjaxFunction_shouldAddFunction()
	{
		$obj = new MyPlugin();
		$obj->registerAjaxFunction("myNonStaticFunction", array("foo", "bar"), false);
		$obj->registerAjaxFunction("myStaticFunction", array(1, 2, 3), true);
		$ajaxFunctions = $obj->ajaxFunctions();
		
		$this->assertEqual(sizeof($ajaxFunctions), 2);
		$this->assertFalse($ajaxFunctions[0]->isStatic());
		$this->assertEqual($ajaxFunctions[0]->name(), "myNonStaticFunction");
		$this->assertEqual($ajaxFunctions[0]->parameters(), array("foo", "bar"));
		$this->assertTrue($ajaxFunctions[1]->isStatic());
		$this->assertEqual($ajaxFunctions[1]->name(), "myStaticFunction");
		$this->assertEqual($ajaxFunctions[1]->parameters(), array(1, 2, 3));
	}
	
	function test_registerList_shouldAddList()
	{
		$obj = new MyPlugin();
		$obj->registerList("friends", "User");
		$obj->registerList("images", "Image", true, "name()");
		$lists = $obj->lists();
		
		$this->assertEqual(sizeof($lists), 2);
		
		$list = $lists["friends"];
		
		$this->assertNotNull($list);
		$this->assertFalse($list->isSynced());
		$this->assertEqual($list->itemClass(), "User");
		$this->assertEqual($list->name(), "friends");
		$this->assertEqual($list->ownerClass(), "MyPlugin");
		$this->assertNull($list->ownerId());
		$this->assertNull($list->sortRule());
		
		$list = $lists["images"];
		
		$this->assertNotNull($list);
		$this->assertTrue($list->isSynced());
		$this->assertEqual($list->itemClass(), "Image");
		$this->assertEqual($list->name(), "images");
		$this->assertEqual($list->ownerClass(), "MyPlugin");
		$this->assertNull($list->ownerId());
		$this->assertEqual($list->sortRule(), "name()");
	}
	
	function test_reset_shouldNotResetPrivateAndProtectedVariables()
	{
		$obj = new MyDatabaseClass();
		$obj->reset();
		
		$this->assertEqual($obj->getPrivate(), "foo__20");
		$this->assertEqual($obj->getProtected(), "foo__20");
	}
	
	function test_reset_shouldNotResetChangedPublicStrings()
	{
		$time = mktime(0, 0, 0, 7, 1, 2000);
		
		$obj = new MyDatabaseClass();
		$obj->_name = "bar";
		$obj->_age = 30;
		$obj->_grade = 5.0;
		$obj->_date = $time;
		$obj->_dateTime = $time;
		$obj->_time = $time;
		$obj->_timeStamp = $time;
		$obj->_noValue = "bar";
		$obj->_noType = "bar";
		$obj->reset();
		
		$this->assertEqual($obj->id(), "");
		$this->assertEqual($obj->_name, "bar");
		$this->assertEqual($obj->_age, 30);
		$this->assertEqual($obj->_grade, 5.0);
		$this->assertEqual($obj->_date, $time);
		$this->assertEqual($obj->_dateTime, $time);
		$this->assertEqual($obj->_time, $time);
		$this->assertEqual($obj->_timeStamp, $time);
		$this->assertEqual($obj->_noValue, "bar");
		$this->assertEqual($obj->_noType, "bar");
	}
	
	function test_reset_shouldResetUnchangedPublicStrings()
	{
		$obj = new MyDatabaseClass();
		$obj->reset();
		
		$this->assertEqual($obj->id(), "");
		$this->assertEqual($obj->_name, "foo");
		$this->assertEqual($obj->_age, 20);
		$this->assertEqual($obj->_grade, 10.0);
		$this->assertEqual($obj->_date, "");
		$this->assertEqual($obj->_dateTime, "");
		$this->assertEqual($obj->_time, "");
		$this->assertEqual($obj->_timeStamp, "");
		$this->assertEqual($obj->_noValue, "");
		$this->assertEqual($obj->_noType, "foo");
	}
	
	function test_save_shouldResetObject()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$this->assertEqual($obj->_name, "foo");
		$this->assertEqual($obj->_age, 20);
		$this->assertEqual($obj->_grade, 10.0);
		$this->assertEqual($obj->_date, "0000-00-00");
		$this->assertEqual($obj->_dateTime, "0000-00-00 00:00:00");
		$this->assertEqual($obj->_time, "00:00:00");
		$this->assertEqual($obj->_timeStamp, "0000-00-00 00:00:00");
		$this->assertEqual($obj->_noValue, "");
		$this->assertEqual($obj->_noType, "foo");
	}
	
	function test_save_shouldSetBaseVariablesAndInsertIntoDatabase()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$this->assertEqual(strlen($obj->id()), 40);
		
		$id = $obj->id();
		Wigbi::dbHandler()->query("SELECT * FROM " . $obj->collectionName() . " WHERE ID = '" . $obj->id() . "'");
		
		$this->assertNotNull(Wigbi::dbHandler()->getNextRow());
		
		$obj->save();
		
		$this->assertEqual($obj->id(), $id);
		
		Wigbi::dbHandler()->query("SELECT * FROM " . $obj->collectionName() . " WHERE ID = '" . $id . "'");
		
		$this->assertNotNull(Wigbi::dbHandler()->getNextRow());
	}
	
	function test_save_shouldUpdateDatabaseForPreviouslySavedObject()
	{
		$obj = new MyDatabaseClass();
		$obj->_name = "foo bar";
		$obj->_age = 40;
		$obj->_grade = 5.0;
		$obj->_noValue = "yes 'now'";
		$obj->_noType = "no, right";
		$obj->save();
		
		$this->assertEqual(strlen($obj->id()), 40);
		
		$id = $obj->id();
		Wigbi::dbHandler()->query("SELECT * FROM " . $obj->collectionName() . " WHERE ID = '" . $id . "'");
		$row = Wigbi::dbHandler()->getNextRow();

		$this->assertEqual($row["id"], $id);
		$this->assertEqual($row["name"], "foo bar");
		$this->assertEqual($row["age"], 40);
		$this->assertEqual($row["grade"], 5.0);
		$this->assertEqual($row["noValue"], "yes 'now'");
		$this->assertEqual($row["noType"], "no, right");
		
		$obj->_name = "bar foo";
		$obj->_age = 50;
		$obj->_grade = 2.5;
		$obj->_noValue = "yes 'still'";
		$obj->_noType = "no, not even now";
		$obj->save();
		
		$this->assertEqual($obj->id(), $id);
		
		Wigbi::dbHandler()->query("SELECT * FROM " . $obj->collectionName() . " WHERE ID = '" . $id . "'");
		$row = Wigbi::dbHandler()->getNextRow();

		$this->assertEqual($row["id"], $id);
		$this->assertEqual($row["name"], "bar foo");
		$this->assertEqual($row["age"], 50);
		$this->assertEqual($row["grade"], 2.5);
		$this->assertEqual($row["noValue"], "yes 'still'");
		$this->assertEqual($row["noType"], "no, not even now");
		$this->assertFalse(Wigbi::dbHandler()->getNextRow());
	}
	
	function test_search_shouldAcceptSearchFilterObject()
	{
		$obj = new MyDatabaseClass();
		$obj->_name = "Robert";
		$obj->save();
		
		$obj = new MyDatabaseClass();
		$obj->_name = "Robbie Robertson";
		$obj->save();
		
		$obj = new MyDatabaseClass();
		$obj->_name = "Agatha Cristie";
		$obj->save();
		
		$obj = new MyDatabaseClass();
		$obj->_name = "Roberta";
		$obj->save();
		
		$filter = new SearchFilter();
		$filter->addSearchRule("name LIKE '%robert%'");
		$filter->addSortRule("name");
		$filter->setPaging(0, 1);
		
		$result = $obj->search($filter);
		$objects = $result[0];
		$object = $objects[0];
		
		$this->assertEqual(sizeof($result), 2);
		$this->assertEqual(sizeof($objects), 1);
		$this->assertEqual($object->_name, "Robbie Robertson");
		$this->assertEqual($result[1], 3);
	}
	
	function test_search_shouldAcceptSearchFilterString()
	{
		$obj = new MyDatabaseClass();
		$obj->_name = "Robert";
		$obj->save();
		
		$obj = new MyDatabaseClass();
		$obj->_name = "Robbie Robertson";
		$obj->save();
		
		$obj = new MyDatabaseClass();
		$obj->_name = "Agatha Cristie";
		$obj->save();
		
		$obj = new MyDatabaseClass();
		$obj->_name = "Roberta";
		$obj->save();
		
		$filter = new SearchFilter();
		$filter->addSearchRule("name LIKE '%robert%'");
		$filter->addSortRule("name");
		$filter->setPaging(0, 1);
		$filter = $filter->toString();
		
		$result = $obj->search($filter);
		$objects = $result[0];
		$object = $objects[0];
		
		$this->assertEqual(sizeof($result), 2);
		$this->assertEqual(sizeof($objects), 1);
		$this->assertEqual($object->_name, "Robbie Robertson");
		$this->assertEqual($result[1], 3);
	}
	
	function test_searchListItems_shouldReturnFalseForUnsavedParent()
	{
		$obj = new MyDatabaseClass();
		
		$this->assertFalse($obj->searchListItems("objects", ""));
	}
	
	function test_searchListItems_shouldReturnFalseForInvalidList()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$this->assertFalse($obj->searchListItems("invalid", ""));
	}
	
	function test_searchListItems_shouldAutoDeleteNonExistingItems()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child->delete();
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$filter = new SearchFilter();
		$filter->addSearchRule("name LIKE '%robert%'");
		$filter->addSortRule("name");
		$filter->setPaging(0, 1);
		$filter = $filter->toString();
		
		$result = $obj->searchListItems("objects", $filter);
		$objects = $result[0];
		$object = $objects[0];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 1);
		$this->assertEqual($object->_name, "Robert");
		$this->assertEqual($result[1], 2);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_searchListItems_shouldAcceptSearchFilterObject()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$filter = new SearchFilter();
		$filter->addSearchRule("name LIKE '%robert%'");
		$filter->addSortRule("name");
		$filter->setPaging(0, 1);
		
		$result = $obj->searchListItems("objects", $filter);
		$objects = $result[0];
		$object = $objects[0];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 1);
		$this->assertEqual($object->_name, "Robbie Robertson");
		$this->assertEqual($result[1], 3);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_searchListItems_shouldAcceptSearchFilterString()
	{
		$obj = new MyDatabaseClass();
		$obj->save();
		
		$child = new MyDatabaseClass();
		$child->_name = "Robert";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Robbie Robertson";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Agatha Cristie";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$child = new MyDatabaseClass();
		$child->_name = "Roberta";
		$child->save();
		
		$this->assertTrue($obj->addListItem("objects", $child->id()));
		
		$filter = new SearchFilter();
		$filter->addSearchRule("name LIKE '%robert%'");
		$filter->addSortRule("name");
		$filter->setPaging(0, 1);
		$filter = $filter->toString();
		
		$result = $obj->searchListItems("objects", $filter);
		$objects = $result[0];
		$object = $objects[0];
		
		$this->assertEqual(sizeof($result), 3);
		$this->assertEqual(sizeof($objects), 1);
		$this->assertEqual($object->_name, "Robbie Robertson");
		$this->assertEqual($result[1], 3);
		$this->assertEqual($result[2], "MyDatabaseClass");
	}
	
	function test_setupDatabase_shouldCreateCompleteTable()
	{
		//Create an instance of the class and add some data lists
		$obj = new MyDatabaseClass();
		
		//Assert that all public variables have been handled
		foreach ($obj->databaseVariables() as $property)
		{
			$columnName = $property;
			if (substr($property, 0, 1) == "_")
				$columnName = substr($property, 1, strlen($property));
			
			$this->assertTrue(Wigbi::dbHandler()->tableColumnExists($obj->collectionName(), $columnName));
		}
		
		//Assert that all data lists are handled
		foreach ($obj->lists() as $list)
			$this->assertTrue(Wigbi::dbHandler()->tableExists($list->tableName()));
	}
	
	function test_toJsVariable_shouldNotAddScriptTagByDefault()
	{
		$obj = new MyDatabaseClass();
		
		ob_start();
		print $obj->toJsVariable("myVar");
		$result = ob_get_clean();
		
		$expectedResult  = "var myVar = new MyDatabaseClass();";
		$expectedResult .= '$.extend(myVar' . ", JSON.parse('" . json_encode($obj) . "'));";
		
		$this->assertEqual($result, $expectedResult);
	}
	
	function test_toJsVariable_shouldAddScriptTagIfRequested()
	{
		$obj = new MyDatabaseClass();
		
		ob_start();
		print $obj->toJsVariable("myVar", true);
		$result = ob_get_clean();
		
		$expectedResult  = "var myVar = new MyDatabaseClass();";
		$expectedResult .= '$.extend(myVar' . ", JSON.parse('" . json_encode($obj) . "'));";
		$expectedResult = '<script type="text/javascript">' . $expectedResult . '</script>';
		
		$this->assertEqual($result, $expectedResult);
	}
	
	function test_validate_shouldReturnEmptyArrayForNoError()
	{
		$obj = new MyValidationClass();
		
		$this->assertEqual(sizeof($obj->validate()), 0);
	}
	
	function test_validate_shouldReturnPopulatedArrayForError()
	{
		$obj = new MyValidationClass();
		$obj->collectionName("InvalidValidationClass");
		
		$this->assertEqual(sizeof($obj->validate()), 1);
	}
}



class MyDatabaseClass extends WigbiDataPlugin
{
	public $_name = "foo__20";
	public $_age = 20;
	public $_grade = 10.0;
	public $_date = "__DATE";
	public $_dateTime = "__DATETIME";
	public $_timeStamp = "__TIMESTAMP";
	public $_time = "__TIME";
	public $_noValue = "__FILE";
	public $_noType = "foo";
	public $_text = "__TEXT";
	public $_bool = true;
	
	private $_private = "foo__20";
	protected $_protected = "foo__20";
	public function getPrivate() { return $this->_private; }
	public function getProtected() { return $this->_protected; }
	
	
	
	public function __construct()
	{
		parent::__construct();
		$this->registerList("objects", "MyDatabaseClass");
		$this->registerList("objects_sorted", "MyDatabaseClass", false, "name");
		$this->registerList("objects_synced", "MyDatabaseClass", true);
	}
}



class MyValidationClass extends WigbiDataPlugin
{
	public function validate()
	{
		if ($this->collectionName() == "InvalidValidationClass")
			return array("invalidCollectionName");
		parent::validate();
	}
}



class MyPlugin extends WigbiDataPlugin { }
class MyParty extends WigbiDataPlugin { }
class MyBus extends WigbiDataPlugin { }
class MyBox extends WigbiDataPlugin { }
class MyLunch extends WigbiDataPlugin { }
class MyCash extends WigbiDataPlugin { }
class MyPass extends WigbiDataPlugin { }

?>