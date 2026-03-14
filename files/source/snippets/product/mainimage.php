<?php

class ProductMainimage extends BasePage {
 
   public function Execute() {

      $this->ref = $this->getPref('parentdata')[ 'ref' ];
      
      $image = new Image( $this->ref, 1 );
      $image->setDimension( array( 'longest' => 500 ) );
      
      return "<img src=\"" . $image->getUrl() . "\" width=\"" . $image->getX() . "\" height=\"" . $image->getY() . "\" data-magnify-src=\"" . $image->getUrl( true ) . "\" />";
      
   }
   
}

?>
