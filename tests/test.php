<?php
namespace test;

require_once "vendor/autoload.php";

#define("__ROOT__", dirname(__FILE__));
#require_once(__ROOT__."/../src/anytizer/images/class.cropnail.inc.php");

use \anytizer\images\cropnail;

$cropnail = new cropnail();
print_r($cropnail);
