<?php

namespace cli;

define("__ROOT__", dirname(__FILE__));
require_once(__ROOT__ . "/../src/libraries/classes/images/class.cropnail.inc.php");
require_once(__ROOT__ . "/class.handlers.inc.php");
require_once(__ROOT__ . "/class.clis.inc.php"); // CLIs
require_once(__ROOT__ . "/class.processors.inc.php");

use images\cropnail;

help();

switch (count($argv)) {
    case 2:
        # cropnail list
        # cropnail list 300x500
        cli_2($argv);
        break;
    case 3:
        // cropnail size wide
        // cropnail size tall
        // cropnail size square
        cli_3($argv);
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

/**
 * Actual image resize in specified dimension
 */
function resize($source = "", $target = "", $x = 0, $y = 0)
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
	images 200x200 source.png target.png
	images 200x200 source.jpeg target.png
	images 200x200 DIR
	images list
	images report
	images group
		- Puts photos in their dimensions
	images list 300x500
	images resize 300x500
	images border 2px #FFFFFF
	images size
		- images size tall
		- images size wide
		- images size square
");
}

/**
 * Stop executing
 */
function stop($message = "")
{
    echo "\r\n";
    echo $message;
    die();
}