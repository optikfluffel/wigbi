<?php

class UserBehavior extends UnitTestCase
{
	private $user;

	

	function UserBehavior()
	{
		$this->UnitTestCase("User data plugin");
	}
	
	function setUp()
	{
		$this->user = new User();
	}
	
	function tearDown() { }
		
	
	function test_constructor_objectVariablesShouldBeOfCorrectType()
	{
		WigbiDataPlugin::autoReset(false);
		$this->rating = new User();
		WigbiDataPlugin::autoReset(true);
		
		$this->assertEqual($this->user->className(), "User");
		$this->assertEqual($this->user->collectionName(), "Users");
		
		$this->assertEqual($this->rating->userName(), "__20");
		$this->assertEqual($this->rating->password(), "__40");
		$this->assertEqual($this->rating->email(), "__100");
		$this->assertEqual($this->rating->firstName(), "__30");
		$this->assertEqual($this->rating->lastName(), "__30");
		$this->assertEqual($this->rating->isAdmin(), false);
	}
	
	function test_constructor_objectShouldAutoReset()
	{
		$this->assertEqual($this->user->className(), "User");
		$this->assertEqual($this->user->collectionName(), "Users");
		
		$this->assertEqual($this->user->userName(), "");
		$this->assertEqual($this->user->password(), "");
		$this->assertEqual($this->user->email(), "");
		$this->assertEqual($this->user->firstName(), "");
		$this->assertEqual($this->user->lastName(), "");
		$this->assertEqual($this->user->isAdmin(), false);
	}
	
	function test_constructor_shouldRegisterListsAndFunctions()
	{	
		$lists = $this->user->lists();
		
		$this->assertEqual(sizeof($lists), 0);
		
		$functions = $this->user->ajaxFunctions();
		
		$this->assertEqual(sizeof($functions), 4);
		
		$function = $functions[0];
		
		$this->assertEqual($function->name(), "getCurrentUser");
		$this->assertEqual($function->parameters(), array());
		$this->assertEqual($function->isStatic(), true);
		
		$function = $functions[1];
		
		$this->assertEqual($function->name(), "isLoggedIn");
		$this->assertEqual($function->parameters(), array());
		$this->assertEqual($function->isStatic(), false);
		
		$function = $functions[2];
		
		$this->assertEqual($function->name(), "login");
		$this->assertEqual($function->parameters(), array("userName", "password"));
		$this->assertEqual($function->isStatic(), true);
		
		$function = $functions[3];
		
		$this->assertEqual($function->name(), "logout");
		$this->assertEqual($function->parameters(), array());
		$this->assertEqual($function->isStatic(), true);
	}
			

    	
	function test_properties_shouldBePersisted()
	{
		$this->user->userName("name");
		$this->user->password("pwd");
		$this->user->email("foo.bar@gmail.com");
		$this->user->firstName("Foo");
		$this->user->lastName("Bar");
		$this->user->isAdmin(true);
		
		$this->user->save();
		
		$tmpObj = new User();
		$tmpObj->load($this->user->id());
		
		$this->assertEqual($tmpObj->userName(), "name");
		$this->assertEqual($tmpObj->password(), sha1("pwd"));
		$this->assertEqual($tmpObj->email(), "foo.bar@gmail.com");
		$this->assertEqual($tmpObj->firstName(), "Foo");
		$this->assertEqual($tmpObj->lastName(), "Bar");
		$this->assertEqual($tmpObj->isAdmin(), true);
	}
	
    
	
	function test_isLoggedIn_shouldReturnFalseForUnsavedUser()
	{
		$user = new User();
		$this->assertFalse($user->isLoggedIn());
	}
	
	function test_login_shouldReturnFalseForInvalidUserName()
	{
		$this->assertFalse(User::login("foo", "pwd"));
	}
	
	function test_login_shouldReturnFalseForInvalidPassword()
	{
		$this->assertFalse(User::login("name", "foo"));
	}
	
	function test_login_shouldReturnTrueForValidCredentials()
	{
		$this->assertTrue(User::login("name", "pwd"));
		$this->assertEqual(Wigbi::sessionHandler()->get("User.currentUser"), $this->user->loadBy("userName", "name"));
	}
	
	function test_isLoggedIn_shouldReturnFalseForNonLoggedInUser()
	{
		$this->assertFalse($this->user->isLoggedIn());
	}
	
	function test_isLoggedIn_shouldReturnTrueForNonLoggedInUser()
	{
		$this->user->loadBy("userName", "name");
		
		$this->assertEqual($this->user->userName(), "name");
		$this->assertEqual($this->user->password(), sha1("pwd"));
		$this->assertEqual($this->user->email(), "foo.bar@gmail.com");
		$this->assertEqual($this->user->firstName(), "Foo");
		$this->assertEqual($this->user->lastName(), "Bar");
		$this->assertEqual($this->user->isAdmin(), true);	
		$this->assertTrue($this->user->isLoggedIn());
	}
	
	function test_getCurrentUser_shouldReturnLoggedInUserWithoutReloading()
	{
		$this->user->loadBy("userName", "name");
		$this->assertEqual(User::getCurrentUser(false), $this->user);
	}
	
	function test_getCurrentUser_shouldReturnLoggedInUserWithReloading()
	{
		$this->user->loadBy("userName", "name");
		$this->assertEqual(User::getCurrentUser(true), $this->user);
	}
	
	function test_logout_shouldLogoutUser()
	{
		User::logout();
		$tmpUser = new User();
		$tmpUser->reset();
		$this->user->loadBy("userName", "name");
		
		$this->assertFalse($this->user->isLoggedIn());
		$this->assertEqual(User::getCurrentUser(true), $tmpUser);
		$this->assertEqual(User::getCurrentUser(false), $tmpUser);
	}
    	
	function test_validate_shouldOnlySucceedForValidObject()
	{
		$this->assertEqual($this->user->validate(), array("userName_required"));
		$this->user->email("foo bar");
		$this->assertEqual($this->user->validate(), array("userName_required", "email_invalid"));
		$this->user->userName("foo bar");
		$this->assertEqual($this->user->validate(), array("email_invalid"));
		$this->user->email("foo.bar@gmail.com");
		$this->assertEqual($this->user->validate(), array());
	}
}

?>