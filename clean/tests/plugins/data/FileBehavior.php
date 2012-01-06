<?php

class FileBehavior extends UnitTestCase
{
	private $file;

	

	function FileBehavior()
	{
		$this->UnitTestCase("File data plugin");
	}
	
	function setUp()
	{
		$this->file = new File();
	}
	
	function tearDown() { }
	
	
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->file = new File();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->file->className(), "File");
		$this->assertEqual($this->file->collectionName(), "Files");
		
		$this->assertEqual($this->file->fileUrl(), "__FILE");
		$this->assertEqual($this->file->fileName(), "__50");
		$this->assertEqual($this->file->description(), "__100");
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->file->className(), "File");
		$this->assertEqual($this->file->collectionName(), "Files");
		
		$this->assertEqual($this->file->fileUrl(), "");
		$this->assertEqual($this->file->fileName(), "");
		$this->assertEqual($this->file->description(), "");
	}
			
	    
	
	function test_properties_shouldBePersisted()
	{
		$this->file->fileUrl("file");
		$this->file->fileName("name");
		$this->file->description("description");
		$this->file->save();
		
		$tmpObj = new File();
		$tmpObj->load($this->file->id());
		
		$this->assertEqual($tmpObj->fileUrl(), "file");
		$this->assertEqual($tmpObj->fileName(), "name");
		$this->assertEqual($tmpObj->description(), "description");
	}
    
    
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->file->fileUrl("       ");
		
		$this->assertEqual($this->file->validate(), array("fileUrl_required"));
		
		$this->file->fileUrl("foo bar");
		
		$this->assertEqual($this->file->validate(), array());
	}
}

?>