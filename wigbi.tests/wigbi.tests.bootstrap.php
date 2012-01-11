<?php

$wigbi_test_config = array();
$wigbi_test_config["application"] = array();
$wigbi_test_config["application"]["name"] = "application";
$wigbi_test_config["application"]["webRoot"] = "/wigbi_dev/";

//By default, first configure Wigbi using a dummy configuration
Wigbi::configuration(new ArrayBasedConfiguration($wigbi_test_config));




?>