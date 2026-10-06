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
            $newImage,  // Target Pic
            $oldImage,  // Source Pic
            0, 0,       // Target Start X, Y new image
            0, 0,       // Source Start X, Y old image
            $newWidth,
            $newHeight,
            $oldWidth,
            $oldHeight
        );

        imagejpeg($newImage, $destination, 100);

        imagedestroy($oldImage);
        //imagedestroy($newImage);

        if ($source !== $destination && file_exists($source)) {
            unlink($source);
        }

        $src_w = imagesx($newImage);
        $src_h = imagesy($newImage);

        $thumbMaxEdgeLength = 300;

        if ($src_w >= $src_h) {
            $thumbWidthRatio = $src_w / $thumbMaxEdgeLength;

            $thumbWidth = $thumbMaxEdgeLength;
            $thumbHeight = $src_h / $thumbWidthRatio;
        } else {
            $thumbHeightRatio = $src_h / $thumbMaxEdgeLength;

            $thumbHeight = $thumbMaxEdgeLength;
            $thumbWidth = $src_w / $thumbHeightRatio;
        }

        $thumbWidth = (int) $thumbWidth;
        $thumbHeight = (int) $thumbHeight;

        $newThumbFront = imagecreatetruecolor($thumbWidth, $thumbHeight);
        $newThumbBackground = imagecreatetruecolor($thumbMaxEdgeLength, $thumbMaxEdgeLength);

        imagecopyresampled(
            $newThumbFront,
            $newImage,
            0, 0,
            0, 0,
            $thumbWidth,
            $thumbHeight,
            $src_w,
            $src_h
        );

        // for ($i = 0; $i < 10; $i++) {
        //     imagefilter($newImage, IMG_FILTER_GAUSSIAN_BLUR);
        // }
        // imagefilter($newImage, IMG_FILTER_BRIGHTNESS, -50);


        imagecopyresampled(
            $newThumbBackground,
            $newImage,
            0, 0,
            0, 0,
            $thumbMaxEdgeLength,
            $thumbMaxEdgeLength,
            $src_w,
            $src_h
        );

        for ($i = 0; $i < 300; $i++) {
            imagefilter($newThumbBackground, IMG_FILTER_GAUSSIAN_BLUR);
        }
        imagefilter($newThumbBackground, IMG_FILTER_BRIGHTNESS, -50);

        imagecopy(
            $newThumbBackground,
            $newThumbFront,
            (int) (($thumbMaxEdgeLength - $thumbWidth) / 2), (int) (($thumbMaxEdgeLength - $thumbHeight) / 2),
            0, 0,
            $thumbWidth,
            $thumbHeight
        );

        imagejpeg($newThumbBackground, $thumbDestination, 100);

        imagedestroy($newImage);
        imagedestroy($newThumbFront);
        imagedestroy($newThumbBackground);


        $fileSize = filesize($destination);
        $req->getModel("Catalog")->updateZFile($id, $fileSize);
    }
}
