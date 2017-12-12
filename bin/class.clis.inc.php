<?php
namespace cli;

function cli_2($argv)
{
	#stop("Parameter 2");
	switch($argv[1])
	{
		case "list":
			process_list();
			break;
		case "report":
			process_report();
			break;
		default:
			stop("Invalid selector: {$argv[1]}.");
			break;
	}
}

function cli_3($argv)
{
	switch($argv[1])
	{
		case "size":
			process_size($argv[2]);
			break;
		default:
			stop("Unknown size");
			break;
	}
}

function cli_4($argv)
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

	resize($source, $target, $x, $y);
}