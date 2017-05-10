<?php
namespace tests;
use images\cropnail;
use PHPUnit\Framework\TestCase;

class ResizingTest extends TestCase
{
	public function setup()
	{
	}

	public function testResizeImages()
	{
		$srcs = glob(__ROOT__."/../images/*.[jJ][pP][gG]");
		$target_dir = __ROOT__."/../resized";
		
		$sizes = array(
			array(100, 100),
			array(100, 200),
			array(200, 100),
			array(100, 400),
			array(400, 100),
			array(200, 400),
		);
		
		foreach($srcs as $src_file)
		{
			foreach($sizes as $size)
			{
				$name = basename($src_file);
				$info = pathinfo($name);
				
				$x = $size[0];
				$y = $size[1];
				$target_file = "{$target_dir}/{$info['filename']}-{$x}x{$y}.jpg";
				
				$cropnail = new cropnail($x, $y);
				$cropnail->resize($src_file, $target_file);
			}		
		}
		
		$this->assertTrue(true);
	}
}
