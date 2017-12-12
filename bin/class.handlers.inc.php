<?php
namespace cli;

class handlers
{
	/**
	 * Creates resizing command
	 */
	public function resizing_command($file="abc.png")
	{
		$dimensions = "200x200";

		$f = pathinfo($file);
		$target = "target/{$f['filename']}-{$dimensions}.{$f['extension']}";
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
}