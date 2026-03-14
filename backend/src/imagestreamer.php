<?php

// Set time zone.
if ( function_exists( 'date_default_timezone_set' ) ) {
   
   date_default_timezone_set( 'Europe/Oslo' );
   
}

$prodId = $_REQUEST[ 'pid' ];
$seqId = $_REQUEST[ 'sid' ];
$x = $_REQUEST[ 'x' ];
$y = $_REQUEST[ 'y' ];
$type = $_REQUEST[ 'typ' ];

$resDir = '../../files/webroot/www/resources/products/images/';
$errorImage = '../../files/webroot/www/images/missingimage.jpg';

// Check if thumbnail or image is requested.
$thumbPost = '';
if ( $type == 'thumb' ) {
   
   $thumbPost = '-p';
   
}

// Create original filename.
$fileName = "product-${prodId}-${seqId}${thumbPost}.jpg";

$image = null;

// Check if original image exists.
if ( !file_exists( $resDir . $fileName ) ) {
   
   $image = new Imagick( $errorImage );

}
else {

   $image = new Imagick( $resDir . $fileName );

}

$image->setImageResolution( 72, 72 );
$image->scaleImage( $x, $y, true );

$dim = $image->getImageGeometry();
$new_x = $dim[ 'width' ];
$new_y = $dim[ 'height' ];

$im2 = new Imagick();
$im2->newImage( $x, $y, 'white', 'jpg' );
$im2->setImageColorspace( $image->getImageColorspace() );

$posx = floor($x/2)-floor($new_x/2);
$posy = floor($y/2)-floor($new_y/2);

$im2->compositeImage( $image, $image->getImageCompose(), $posx, $posy );



$dim = $im2->getImageGeometry();

header("Content-Type: image/jpeg");
echo $im2;

?>
