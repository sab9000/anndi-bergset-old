<?php

require_once( 'element_base.php' );

class Element_Productgroup extends Element_Base {
   
   public function write() { 

      global $curLang;

      $dataFile = "files/data/products.txt";
      
      // Load product data.
      $data = json_decode( file_get_contents( $dataFile ) );

      $strOut = '';
      foreach ( $data->product as $d ) {

         if ( isset( $this->settings[ 'ref' ] ) && in_array( $this->settings[ 'ref' ], $d->group ) ) {
         
            $strOut .= "<div><a href=\"/product/" . $d->id . "\"><img alt=\"\" src=\"/image/" . $d->id . "/1/100/100/thumb.jpg\" width=\"100\" height=\"100\" /></a></div>\n";
            
         }
         
      }

      return $strOut;
      
   }
   
}

?>
