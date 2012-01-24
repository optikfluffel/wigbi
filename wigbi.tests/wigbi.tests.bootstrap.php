<?php

require("php/io/FakePhpIncluder.php");

$wigbi_test_config = array();

$wigbi_test_config["application"] = array();
$wigbi_test_config["application"]["name"] = "application";
$wigbi_test_config["application"]["clientRoot"] = "/wigbi_dev/";

$wigbi_test_config["include"] = array();
$wigbi_test_config["include"]["php"] = "foo_php,bar_php,foobar_php";

Wigbi::cache("foo");
Wigbi::configuration(new ArrayBasedConfiguration($wigbi_test_config));
Wigbi::cookies("foo");
Wigbi::cssIncluder("foo");
Wigbi::fileSystem("foo");
Wigbi::jsIncluder("foo");
Wigbi::logger("foo");
Wigbi::phpIncluder(new FakePhpIncluder());
Wigbi::session("foo");
Wigbi::translator("foo");

?>