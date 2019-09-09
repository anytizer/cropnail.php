<?php

namespace cli;

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

    /**
     * Convert list of files into list of dimensions
     */
    $sizes = array_map(array(new handlers(), "get_size"), $files);

    /**
     * Counts how many images exist in each dimensions
     */
    $dimensions = array();
    foreach ($sizes as $dimension) {
        $dimensions[$dimension] = ($dimensions[$dimension] ?? 0) + 1;
    }

    echo "
Count of images based on dimensions.
";

    foreach ($dimensions as $WxH => $total) {
        list($width, $height) = explode("x", $WxH);
        echo sprintf("\n%7s x %7s : %7s", $width, $height, $total);
    }

    /**
     * The orientation detection is my the image dimensions only.
     * It cannot detect the image content.
     * eg. A standing person photographed by moving the camera orientation.
     * eg. Image rotated and saved using a software.
     */
    $wide = 0;
    $tall = 0;
    $square = 0;
    foreach ($sizes as $dimension) {
        list($width, $height) = explode("x", $dimension);

        /**
         * Determine the photo status: Wide or Tall?
         */
        if ($height > $width) {
            ++$tall;
        } else if ($width > $height) {
            ++$wide;
        } else {
            ++$square;
        }
    }
    echo "\r\n
Orientation Report
	Wide Images: {$wide}
	Tall Images (Vertical): {$tall}
	Square Images: {$square}
";
}

function process_size($orientation_selected = "square")
{
    $files = get_files();

    $meta = array_map(array(new handlers(), "meta"), $files);
    #print_r($meta);

    $commands = array_map(array(new handlers(), "move_by_orientations"), $meta);
    #print_r($commands);
    echo "\r\n";
    echo implode("\r\n", $commands);

    echo "

mkdir tall
mkdir wide
mkdir square

";

    stop("Processing size: {$orientation_selected}");
}