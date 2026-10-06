<?php

namespace App\Helper;
use Imagick;


class Thumbmagick extends Imagick
{
    public function thumbalize($name, $id, $req): void
    {
        $imageMaxEdgeLength = 1280;
        $newImg = clone $this;
        $newImg->thumbnailImage($imageMaxEdgeLength, $imageMaxEdgeLength, true);

        $thumbMaxEdgeLength = 300;
        $newThumbFront = clone $this;
        $newThumbFront->thumbnailImage($thumbMaxEdgeLength, $thumbMaxEdgeLength, true);

        $newThumbBG = clone $this;
        $newThumbBG->thumbnailImage($thumbMaxEdgeLength, $thumbMaxEdgeLength, false);
        $newThumbBG->gaussianBlurImage(5, 5);

        $newThumbFrontWidth = (int) (($thumbMaxEdgeLength - $newThumbFront->getImageWidth()) / 2);
        $newThumbFrontHeight = (int) (($thumbMaxEdgeLength - $newThumbFront->getImageHeight()) / 2);

        $newThumbBG->compositeImage(
            $newThumbFront,
            \Imagick::COMPOSITE_OVER,
            $newThumbFrontWidth,
            $newThumbFrontHeight
        );

        $newImg->setImageFormat('jpg');
        $newThumbBG->setImageFormat('jpg');

        $imageToDelete = $this->getImageFilename();
        unlink($imageToDelete);

        $newImg->writeImage("webroot/uploads/{$name}.jpg");
        $newThumbBG->writeImage("webroot/uploads/thumb_{$name}.jpg");

        $newImg->clear();
        $newImg->destroy();

        $newThumbFront->clear();
        $newThumbFront->destroy();

        $newThumbBG->clear();
        $newThumbBG->destroy();

        $fileSize = filesize($newImg);
        $req->getModel("Catalog")->updateZFile($id, $fileSize);
    }
}
