<?php

namespace App\Helper;

class Thumbnail
{

    public function thumbalizer($image, $width = 200, $height = 200) {
        $path = 'webroot/uploads/';
        
        $source = $path . $image;
        $destination = $path . "thumb_" . $image;

        $oldSize = getimagesize($source);
        $oldWidth = $oldSize[0];
        $oldHeight = $oldSize[1];

        $oldImage = imagecreatefromjpeg($source);
        $newImage = imagecreatetruecolor($width, $height);

        imagecopyresampled(
            $newImage,
            $oldImage,
            0, 0,
            0, 0,
            $width,
            $height,
            $oldWidth,
            $oldHeight
        );

        imagejpeg($newImage, $destination, 100);

        imagedestroy($oldImage);
        imagedestroy($newImage);

    }
}
