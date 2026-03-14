<?php

require_once( 'element_base.php' );

class Element_Productthumbs extends Element_Base {
   
   public function write() { 

      global $curLang;
      
      $dataFile = "files/data/products.txt";

      // Size of thumbnails.
      $thumbDims = array( 100, 100 );
      
      // Change thumbnail sizes if given in settings.
      if ( isset( $this->settings[ 'pref' ][ 'tsize' ] ) ) {
         
         $thumbDims = array( $this->settings[ 'pref' ][ 'tsize' ], $this->settings[ 'pref' ][ 'tsize' ] );
         
      }
      
      // Standard image size in product box.
      $imSizeLongest = 500;
      
      // Load product data.
      $data = json_decode( file_get_contents( $dataFile ) );

      $strOut = '';
      foreach ( $data->product as $d ) {
         
         if ( $d->id == $this->settings[ 'ref' ] ) {
         
            foreach ( $d->images as $im ) {
               
               $sizes = array(
                  'x'=>$imSizeLongest,
                  'y'=>$imSizeLongest
                  );
               if ( $im->imgx > $im->imgy ) {
                  
                  $sizes[ 'y' ] = floor( $imSizeLongest*($im->imgy/$im->imgx) );
                  
               }
               else if ( $im->imgy > $im->imgx ) {
                  
                  $sizes[ 'x' ] = floor( $imSizeLongest*($im->imgx/$im->imgy) );
                  
               }
               
               $strOut .= "<div><img alt=\"\" src=\"/image/" . $d->id . "/" . $im->seqid . "/" . $thumbDims[ 0 ] . "/" . $thumbDims[ 1 ] . "/thumb.jpg\" width=\"" . $thumbDims[ 0 ] . "\" height=\"" . $thumbDims[ 1 ] . "\" ref=\"/image/" . $d->id . "/" . $im->seqid . "/" . $sizes[ 'x' ] . "/" . $sizes[ 'y' ] . "/image.jpg\"/></div>\n";
               
            }
            
         }
         
      }

      return $strOut;
      
   }
   
}

?>
