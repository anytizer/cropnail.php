<?php
namespace cli;

define("__ROOT__", dirname(__FILE__));
require_once(__ROOT__."/../src/libraries/classes/images/class.cropnail.inc.php");

use images\cropnail;

help();

switch(count($argv))
{
	case 2:
		# cropnail list
		# cropnail list 300x500
		process_2($argv);
		break;
	case 4:
		process_4($argv);
		break;
	default:
		stop("Unknown number of parameters.");
}

function process_2($argv)
{
	#stop("Parameter 2");
	switch($argv[1])
	{
		case "list":
			process_list();
			break;
		default:
			stop("Invalid selector: {$argv[1]}.");
	}
}

function stop($message="")
{
	echo "\r\n";
	echo $message;
	die();
}

class handler
{
	/**
	 * Creates resizing command
	 */
	public function resizing_command($file="abc.png")
	{
		$dimensions = "200x200";

		$f = pathinfo($file);
		$target = "target/{$f['filename']}-{$dimensions}.{$f['extension']}";
		$command = "cropnail {$dimensions} {$file} {$target}";

		return $command;
	}
}

function process_list()
{
	$cwd = getcwd();
	echo "
List of images found in this directory:
	- {$cwd}
	- Make sure that that target DIR exists.
";

	// {$cwd}/
	$srcs = array(
		"jpg" => glob("*.[jJ][pP][gG]"),
		"jpeg" => glob("*.[jJ][pP][eE][gG]"),
		"png" => glob("*.[pP][nN][gG]"),
	);
	$srcs = array_merge($srcs["jpg"], $srcs["jpeg"], $srcs["png"]);
	$srcs = array_map(array(new handler(), "resizing_command"), $srcs);
	#print_r($srcs);
	
	echo "\r\n";
	echo implode("\r\n", $srcs);
	echo "\r\n";
}

function process_4($argv)
{
	#stop("Parameter 4");

	$dimensions = explode("x", $argv[1]);
	if(count($dimensions)!=2)
	{
		stop("Error: Dimensions should be WIDTHxHEIGHT eg. 200x300.");
	}

	$x = (int)$dimensions[0];
	$y = (int)$dimensions[1];
	if(!is_int($x) || !is_int($y))
	{
		stop("Error: Dimensions should be integers. {$x}, {$y}");
	}

	$source = $argv[2];
	$target = $argv[3];

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
	echo("
Cropnail is a library to resize your images.
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
