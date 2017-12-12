<?php
namespace cli;

define("__ROOT__", dirname(__FILE__));
require_once(__ROOT__."/../src/libraries/classes/images/class.cropnail.inc.php");
require_once(__ROOT__."/class.handlers.inc.php");
require_once(__ROOT__."/class.clis.inc.php"); // CLIs

use images\cropnail;
use cli\handlers;

help();

switch(count($argv))
{
	case 2:
		# cropnail list
		# cropnail list 300x500
		cli_2($argv);
		break;
	case 4:
		cli_4($argv);
		break;
	default:
		stop("Unknown number of parameters.");
}

function get_files()
{
	$srcs = array(
		"jpg" => glob("*.[jJ][pP][gG]"),
		"jpeg" => glob("*.[jJ][pP][eE][gG]"),
		"png" => glob("*.[pP][nN][gG]"),
	);
	
	$srcs = array_merge($srcs["jpg"], $srcs["jpeg"], $srcs["png"]);
	return $srcs;
}

function get_list()
{
	$srcs = get_files();
	$srcs = array_map(array(new handlers(), "resizing_command"), $srcs);

	return $srcs;
}

function process_list()
{
	$cwd = getcwd();

	echo "
List of images found in this directory:
	- {$cwd}
	- Make sure that that target DIR exists.
";
	$srcs = get_list();
	
	echo "\r\n";
	echo implode("\r\n", $srcs);
	echo "\r\n";
}

function process_report()
{
	$files = get_files();
	$sizes = array_map(array(new handlers(), "get_size"), $files);
	
	//print_r($files);
	//print_r($sizes);

	/**
	 * Counts how many images exist in each dimensions
	 */
	$dimensions = array();
	foreach($sizes as $dimension)
	{
		$dimensions[$dimension] = ($dimensions[$dimension]??0)+1;
	}

	echo "
Count of images based on dimensions.
";

	foreach($dimensions as $WxH => $total)
	{
		list($width, $height) = explode("x", $WxH);
		echo sprintf("\n%7s x %7s : %7s", $width, $height, $total);
	}
}

/**
 * Actual image resize in specified dimension
 */
function resize($source="", $target="", $x=0, $y=0)
{
	/**
	 * Performs the actual cropnail work.
	 */
	$cropnail = new cropnail($x, $y);
	$cropnail->resize($source, $target);
}

/**
 * Displays usage information
 */
function help()
{
	echo("Cropnail is a library to resize your images.
Usage:
	cropnail 200x200 source.png target.png
	cropnail 200x200 source.jpeg target.png
	cropnail 200x200 DIR
	cropnail list
	cropnail report
	cropnail group
		- Puts photos in their dimensions
	cropnail list 300x500
	cropnail resize 300x500
	cropnail border 2px #FFFFFF
");
}

/**
 * Stop executing
 */
function stop($message="")
{
	echo "\r\n";
	echo $message;
	die();
}