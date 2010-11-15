<?php class ImageFileBehavior extends UnitTestCase
{
	private $imageFile;
	

	function ImageFileBehavior()
	{
		$this->UnitTestCase("ImageFile data plugin");
	}
	
	function setUp()
	{
		$this->file = new ImageFile();
	}
	
	function tearDown() { }
	
	function test_setupDatabase_shouldNotFail()
	{
		Wigbi::start();
		$this->file->setupDatabase();
	}	



	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->file = new ImageFile();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->file->className(), "ImageFile");
		$this->assertEqual($this->file->collectionName(), "ImageFiles");
		
		$this->assertEqual($this->file->fileUrl(), "__FILE");
		$this->assertEqual($this->file->fileName(), "__50");
		$this->assertEqual($this->file->description(), "__100");
		$this->assertEqual($this->file->author(), "__50");
		$this->assertEqual($this->file->width(), 0);
		$this->assertEqual($this->file->height(), 0);
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->file->className(), "ImageFile");
		$this->assertEqual($this->file->collectionName(), "ImageFiles");
		
		$this->assertEqual($this->file->fileUrl(), "");
		$this->assertEqual($this->file->fileName(), "");
		$this->assertEqual($this->file->description(), "");
		$this->assertEqual($this->file->author(), "");
		$this->assertEqual($this->file->width(), 0);
		$this->assertEqual($this->file->height(), 0);
	}
			
	

	function test_properties_shouldBePersisted()
	{
		$this->file->fileUrl("file");
		$this->file->fileName("name");
		$this->file->description("description");
		$this->file->author("author");
		$this->file->width(65);
		$this->file->height(45);
		$this->file->save();
		
		$tmpObj = new ImageFile();
		$tmpObj->load($this->file->id());
		
		$this->assertEqual($tmpObj->fileUrl(), "file");
		$this->assertEqual($tmpObj->fileName(), "name");
		$this->assertEqual($tmpObj->description(), "description");
		$this->assertEqual($tmpObj->author(), "author");
		$this->assertEqual($tmpObj->width(), 65);
		$this->assertEqual($tmpObj->height(), 45);
	}
	
    
	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->file->fileUrl("       ");
		$this->file->width(-1);
		$this->file->height(-1);
		
		$this->assertEqual($this->file->validate(), array("fileUrlRequired", "widthNegative", "heightNegative"));
		
		$this->file->fileUrl("foo bar");
		
		$this->assertEqual($this->file->validate(), array("widthNegative", "heightNegative"));
		
		$this->file->width(1);		
		
		$this->assertEqual($this->file->validate(), array("heightNegative"));
		
		$this->file->height(1);
		
		$this->assertEqual($this->file->validate(), array());
	}
}

?>