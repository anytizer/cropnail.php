# cropnail.php

Image thumbnailer that maintains aspect ratio in target image.

  * Features cropping an image into any image size
  * Tries to include best-fit portion
  * Trims off vertical or horizontal sides if target ratio was different
  * Source image can be of any size
  * Target image can be of any size


## Usage

Detailed usages are at: <a href="phpunit/tests/ResizingTest.php">PHP Unit Tests</a> as runner example.

    use anytizer\images\cropnail;
    
    $x = 200;
    $y = 150;

    $cropnail = new cropnail($x, $y);
    $cropnail->resize($src_file, $target_file);


## Installation

    composer require anytizer/cropnail.php:dev-master


## Samples


### Original Image

![Original Image](images/photo.jpg)


### cropnail-ed Images

| Images                                    | Images                                    |
| ----------------------------------------- | ----------------------------------------- |
| ![Screenshot](resized/photo-100x100.jpg)  | ![Screenshot](resized/photo-200x400.jpg)  |
| *100 x 100*                               | *200 x 400*                               | 
| ![Screenshot](resized/photo-100x200.jpg)  | ![Screenshot](resized/photo-400x100.jpg)  |
| *100 x 200*                               | *400 x 100*                               |
| ![Screenshot](resized/photo-100x400.jpg)  | ![Screenshot](resized/photo-400x200.jpg)  |
| *100 x 400*                               | *400 x 200*                               |
| ![Screenshot](resized/photo-200x100.jpg)  | ![Screenshot](resized/photo-400x400.jpg)  |
| *200 x 100*                               | *400 x 400*                               |
