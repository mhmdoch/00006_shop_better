<?php

namespace App\Helper;

class Thumbnail
{
    public function toJPGwithThumb($imageFileName, $imageFileType, $id, $req): void {
        $path = 'webroot/uploads/';

        $source = $path . $imageFileName . "." . $imageFileType;
        $destination = $path . $imageFileName . ".jpg";
        $thumbDestination = $path . "thumb_" . $imageFileName . ".jpg";


        $oldSize = getimagesize($source);
        $oldWidth = $oldSize[0];
        $oldHeight = $oldSize[1];

        $newWidth = min(1280, $oldWidth);
        $newHeight = (int) ($oldHeight * $newWidth / $oldWidth);

        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $oldImage = imagecreatefromjpeg($source);
        } elseif ($imageFileType == "png") {
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

        if ($source !== $destination && file_exists($source)) {
            unlink($source);
        }

        $thumbWidth = 300;
        $thumbHeight = (int) ($oldHeight * $thumbWidth / $oldWidth);
        
        $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);

        imagecopyresampled(
            $thumb,
            $oldImage,
            0, 0,
            0, 0,
            $thumbWidth,
            $thumbHeight,
            $oldWidth,
            $oldHeight
        );

        imagejpeg($thumb, $thumbDestination, 100);

        $fileSize = filesize($destination);
        $req->getModel("Catalog")->updateZFile($id, $fileSize);
    }
}
