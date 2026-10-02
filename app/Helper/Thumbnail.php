<?php

namespace App\Helper;

class Thumbnail
{

    public function allToJPG($imageFileName, $imageFileType) {

    }

    public function thumbalizer($imageFileName, $imageFileType) {
        $path = 'webroot/uploads/';

        $source = $path . $imageFileName . "." . $imageFileType;
        $destination = $path . "thumb_" . $imageFileName . "." . $imageFileType;

        $oldSize = getimagesize($source);
        $oldWidth = $oldSize[0];
        $oldHeight = $oldSize[1];

        $newWidth = 300;
        $newHeight = (int) ($oldHeight * $newWidth / $oldWidth);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $oldImage = imagecreatefromjpeg($source);
        } else {
            $oldImage = imagecreatefrompng($source);
        };

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled(
            $newImage,
            $oldImage,
            0, 0,
            0, 0,
            $newWidth,
            $newHeight,
            $oldWidth,
            $oldHeight
        );

        imagejpeg($newImage, $destination, 100);

        imagedestroy($oldImage);
        imagedestroy($newImage);

    }
}
