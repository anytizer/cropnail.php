# Cropnail

Image thumbnailer that maintains aspect ratio in target image.

  * Features cropping an image into any image size
  * Tries to include best-fit portion
  * Trims off vertical or horizontal sides if target ratio was different
  * Source image can be of any size
  * Target image can be of any size


## Usage

Detailed usages are at: <a href="phpunit/tests/Test.php">PHP Unit Tests</a> as runner example.

	$x = 200;
	$y = 150;

    $cropnail = new cropnail($x, $y);
    $cropnail->resize($src_file, $target_file);


## Samples

| Images                                        | Images                                        | |-----------------------------------------------|-----------------------------------------------|
| ![Screenshot](/resized/IMG_9842-100x100.jpg)  | ![Screenshot](/resized/IMG_9842-400x200.jpg)  |
| *100x100*                                     | *400x200*                                     | 
| ![Screenshot](/resized/IMG_9842-100x200.jpg)  | ![Screenshot](/resized/IMG_9842-400x400.jpg)  |
| *100x200*                                     | *400x400*                                     |
| ![Screenshot](/resized/IMG_9842-200x100.jpg)  | ![Screenshot](/resized/IMG_9842-200x400.jpg)  |
| *200x100*                                     | *200x400*                                     |
