<?php

class ProductThumbs extends BasePage {
 
   public function Execute() {
      
      $this->ref = $this->getPref('parentdata')[ 'ref' ];
      $imageList = $this->queryField( 'images' );
      
      // Make sure thumbs have half size if there are more than 5.
      $smallThumbs = false;
      if ( count( $imageList ) > 5 ) $smallThumbs = true;  
      
      $out = '';
      foreach ( $imageList as $image ) {
         
         $obj = new Image( $this->ref, $image->seqid );
         
         if ( $smallThumbs ) $obj->useSmallThumbs();
         
         $urlThumb = $obj->getThumbUrl();
         $thX = $obj->getX();
         $thY = $obj->getY();
         
         $out .= "<div>\n";
         $out .= "<img alt=\"\" src=\"" . $urlThumb . "\" width=\"" . $thX . "\" height=\"" . $thY . "\" ref=\"" . $this->ref . '_' . $image->seqid . "\"/>";
         $out .= "</div>\n";
         
      }
      
      return $out; 
      
   }
   
}

?>
