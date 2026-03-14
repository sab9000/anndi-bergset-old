<?php

class Image extends BaseClass {
   
   // Sequence number of image within referer page.
   protected $seqNo;
   // Working dimension of image.
   protected $dims = array();
   // Set to true if small thumbnails is to be used.
   protected $smallThumbs;
   
   public function __construct( $ref, $seq = null ) {
      
      $this->ref = $ref;
      
      if ( isset( $seq ) ) {
         
         $this->seqNo = $seq;
         
         $this->loadImageData();
         
      }
      
   }
   
   public function loadImageData() {
      
      $imageList = $this->queryField( 'images' );
      
      foreach ( $imageList as $image ) {
         
         if ( $image->seqid == $this->seqNo ) {
            
            $this->dims[ 'origx' ] = $image->imgx;
            $this->dims[ 'x' ] = $image->imgx;
            $this->dims[ 'origy' ] = $image->imgy;
            $this->dims[ 'y' ] = $image->imgy;
            break;
            
         }
         
      }
      
   }
   
   public function setDimension( $prefs = array() ) {
      
      $ox = $this->dims[ 'origx' ];
      $oy = $this->dims[ 'origy' ];
      
      if ( isset( $prefs[ 'longest' ] ) && is_numeric( $prefs[ 'longest' ] ) ) {
         
         if ( $ox > $oy ) {
            
            $this->dims[ 'x' ] = $prefs[ 'longest' ];
            $this->dims[ 'y' ] = floor( ($oy/$ox) * $prefs[ 'longest' ] ); 
            
         }
         else {
            
            $this->dims[ 'y' ] = $prefs[ 'longest' ];
            $this->dims[ 'x' ] = floor( ($ox/$oy) * $prefs[ 'longest' ] );
            
         }

      }
      
   }
   
   public function getUrl( $origSize = false, $thumb = false ) {
      
      $fileName = 'image.jpg';
      
      if ( $origSize ) {
         
         $this->dims[ 'x' ] = $this->dims[ 'origx' ];
         $this->dims[ 'y' ] = $this->dims[ 'origy' ];
         
      }
      
      if ( $thumb ) {
         
         $this->dims[ 'x' ] = $this->smallThumbs ? Settings::get( 'images', 'thumbx_min' ) : Settings::get( 'images', 'thumbx' );
         $this->dims[ 'y' ] = $this->smallThumbs ? Settings::get( 'images', 'thumby_min' ) : Settings::get( 'images', 'thumby' );
         
         $fileName = 'thumb.jpg';
         
      }
      
      return '/image/' . $this->ref . '/' . $this->seqNo . '/' . $this->dims[ 'x' ] . '/' . $this->dims[ 'y' ] . '/' . $fileName;
      
   }
   
   public function getThumbUrl() {
      
      return $this->getUrl( false, true );
      
   }
   
   public function getX() {
    
      return $this->dims[ 'x' ];
      
   }
   
   public function getY() {
    
      return $this->dims[ 'y' ];
      
   }
   
   public function useSmallthumbs() {
      
      $this->smallThumbs = true;
      
   }

   
}

?>
