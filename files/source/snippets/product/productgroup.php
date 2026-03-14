<?php

class ProductProductgroup extends BasePage {
 
   public function Execute( $group ) {

      // Get product database.
      $dbList = $this->getDataSet();

      $groupArray = array();
      foreach ( $dbList->product as $product ) {

         if ( in_array( $group, $product->group ) ) {
            
            $groupArray[] = $product;
            
         }
         
      }
       
      foreach ( $groupArray as $item ) {
      
         // Find language settings.
         $curLanguage = RunTimeData::get( 'language', 'current' );
         $defaultLanguage = Settings::get( 'setup', 'defaultlanguage' );
         
         $prodUrl = '/product/' . $item->id;
         if ( $curLanguage != $defaultLanguage ) {
            
            $prodUrl = '/' . $curLanguage . $prodUrl;
            
         }
         
         $obj = new Image( $item->id, 1 );
         $url = $obj->getThumbUrl();
         
         $out .= "<div>\n";
         $out .= "<a href=\"" . $prodUrl . "\">";
         $out .= "<img alt=\"\" src=\"" . $url . "\" width=\"" . $obj->getX() . "\" height=\"" . $obj->getY() . "\" />";
         $out .= "</a>\n";
         $out .= "</div>\n";
            
      }
      
      return $out; 
      
   }
   
}

?>
