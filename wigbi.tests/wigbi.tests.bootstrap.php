<?php

require("php/io/FakePhpFileIncluder.php");

$wigbi_test_config = array();

$wigbi_test_config["application"] = array();
$wigbi_test_config["application"]["name"] = "application";
$wigbi_test_config["application"]["clientRoot"] = "/wigbi_dev/";

$wigbi_test_config["include"] = array();
$wigbi_test_config["include"]["php"] = "foo_php,bar_php,foobar_php";
$wigbi_test_config["include"]["js"] = "foo_js,bar_js,foobar_js";
$wigbi_test_config["include"]["css"] = "foo_css,bar_css,foobar_css";

Wigbi::configuration(new ArrayBasedConfiguration($wigbi_test_config));

?>