<?php
namespace cli;

define("__ROOT__", dirname(__FILE__));
require_once(__ROOT__."/../src/libraries/classes/images/class.cropnail.inc.php");

use images\cropnail;

# cropnail 600x200 source/pexels-photo-680315.jpeg target/01-long.png
# cropnail 600x200 source/pexels-photo-680940.jpeg target/02-long.png
# cropnail 600x200 source/pexels-photo-691668.jpeg target/03-long.png
# cropnail 600x200 source/pexels-photo-695657.jpeg target/04-long.png
# cropnail 600x200 source/pexels-photo-209712.jpeg target/05-long.png

# resize 200x200 -- entire files found...

#print_r($argv);
help();
/*
Array
(
    [0] => cropnail.php
    [1] => 200x200
    [2] => source.png
    [3] => target.png
)
*/

switch(count($argv))
{
	case 2:
		process_2($argv);
		break;
	case 4:
		process_4($argv);
		break;
	default:
		die("Unknown number of parameters.");
}
#die("END of execution");

function process_2($argv)
{
	#die("Parameter 2");
	switch($argv[1])
	{
		case "list":
			process_list();
			break;
	}
}

class handler
{
	public function listing_command($file="abc.png")
	{
		$dimensions = "200x200";

		$f = pathinfo($file);
		#$target = preg_replace("/^(.*?)\.([jpg|jpeg|png])$/is", "aa-$1-{$dimensions}.$2", $file);
		$target = "target/{$f['filename']}-{$dimensions}.{$f['extension']}";
		$command = "cropnail {$dimensions} {$file} {$target}";
		return $command;
	}
}

function process_list()
{
	$cwd = getcwd();
	echo "
List of image files found in this directory.
DIR: {$cwd}
";

	// {$cwd}/
	$srcs = array(
		"jpg" => glob("*.[jJ][pP][gG]"),
		"jpeg" => glob("*.[jJ][pP][eE][gG]"),
		"png" => glob("*.[pP][nN][gG]"),
	);
	$srcs = array_merge($srcs["jpg"], $srcs["jpeg"], $srcs["png"]);
	$srcs = array_map(array(new handler(), "listing_command"), $srcs);
	#print_r($srcs);
	
	echo "\r\n";
	echo implode("\r\n", $srcs);
	echo "\r\n";
}

function process_4($argv)
{
	#die("Parameter 4");

	$dimensions = explode("x", $argv[1]);
	if(count($dimensions)!=2)
	{
		die("Error: Dimensions should be WIDTHxHEIGHT eg. 200x300.");
	}

	$x = (int)$dimensions[0];
	$y = (int)$dimensions[1];
	if(!is_int($x) || !is_int($y))
	{
		die("Error: Dimensions should be integers. {$x}, {$y}");
	}

	$source = $argv[2];
	$target = $argv[3];

	#print_r($dimensions);

	#print_r($argv);

	$cropnail = new cropnail($x, $y);
	$cropnail->resize($source, $target);
}


function help()
{
	echo("
Cropnail is a library to resize your images.
Usage:
	cropnail 200x200 source.png target.png
    cropnail 200x200 source.jpeg target.png
	cropnail 200x200 DIR
	cropnail list
    cropnail resize 300x500
    cropnail border 2px #FFFFFF
");
}
