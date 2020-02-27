<?php
// src/Controller/Component/DatatablesComponent.php
namespace App\Model\Behavior;

use \Imagine\Image\Box;
use \Imagine\Image\Point;

class Imagine
{

	public function gdImageCropAndSave($source, $saveLocation = false , $targetSize = array('width'=> 218, 'height' => 290)){

        $imagine   = new \Imagine\Gd\Imagine();
        $image = $imagine->open($source);
        
        $originalSize = $image->getSize();
        $originalWidth = $originalSize->getWidth();
        $originalHeight = $originalSize->getHeight();

        $targetWidth = $targetSize['width'];
        $targetHeight = $targetSize['height'];

        // START resize image to fit the width of height of target Size first
        $resizeIsFitToWidth = false;
        $resizeIsFitToHeight = false;
        $resizeToFitWidthRatio = $targetWidth/$originalWidth;
        $image1Width = $originalWidth*$resizeToFitWidthRatio;
        $image1Height = $originalHeight*$resizeToFitWidthRatio;

        $resizeToFitHeightRatio = $targetHeight/$originalHeight;
        $image2Width = $originalWidth*$resizeToFitHeightRatio;
        $image2Height = $originalHeight*$resizeToFitHeightRatio;
        if( $image1Width >= $targetWidth && $image1Height >= $targetHeight ) {
            $resizeIsFitToWidth = true;
            $image->resize( new Box($image1Width,$image1Height) );
        }else {
            $resizeIsFitToHeight = true;
            $image->resize( new Box($image2Width,$image2Height) );
        }
        $originalSize = $image->getSize();
        $originalWidth = $originalSize->getWidth();
        $originalHeight = $originalSize->getHeight();
        // END resize image to fit the width of height of target Size first

        // START get the cropping point
        $center = new \Imagine\Image\Point\Center($originalSize);
        $centerX = $center->getX();
        $centerY = $center->getY();
        $targetX = $centerX - $targetWidth/2;
        $targetY = $centerY - $targetHeight/2;
        // END get the cropping point

        $image->crop( new Point($targetX, $targetY), new Box($targetWidth, $targetHeight) );

        $image->save($saveLocation);
    }

    public function resize($source, $saveLocation = false , $targetSize = array('width'=> 30, 'height' => 30)){
        $imagine    = new \Imagine\Gd\Imagine();
        $image      = $imagine->open($source);
        $image->resize(new Box($targetSize['width'], $targetSize['height']));
        $image->save($saveLocation);
    }

}

?>