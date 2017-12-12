<?php
namespace cli;

class handlers
{
	/**
	 * Creates resizing command
	 */
	public function resizing_command($file="abc.png")
	{
		//$dimensions = "200x200"; // square
		$dimensions = "200x400"; // tall
		//$dimensions = "400x200"; // wide

		$f = pathinfo($file);
		$target = "{$dimensions}/{$f['filename']}-{$dimensions}.{$f['extension']}";
		$command = "cropnail {$dimensions} \"{$file}\" \"{$target}\"";

		return $command;
	}

	public function get_size($file="abc.png")
	{
		$info = getimagesize($file);
		
		$width = $info[0]??0;
		$height = $info[1]??0;
		
		//return $info;
		return "{$width}x{$height}";
	}

	/**
	 * Extracts all meta of an image
	 */
	public function meta($file="abc.png")
	{
		$info = getimagesize($file);

		$width = $info[0]??0;
		$height = $info[1]??0;

		$orientation = ($height > $width)?"tall":(($width > $height)?"wide":"square");

		$meta = array(
			"file" => $file,
			"width" => $width,
			"height" => $height,
			"orientation" => $orientation
		);

		return $meta;
	}

	public function move_by_orientations($meta=array())
	{
		$command = "move \"{$meta['file']}\" {$meta['orientation']}";
		return $command;
	}
}