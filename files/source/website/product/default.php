<?php

class ProductDefault extends BasePage {
 
   public function Execute( $ref ) {

      $this->ref = $ref;

      $group = $this->queryField( 'group' )[ 0 ];
      
      // Get product database.
      $dbList = $this->getDataSet();

      $groupArray = array();
      foreach ( $dbList->product as $product ) {

         if ( in_array( $group, $product->group ) ) {
            
            $groupArray[] = $product->id;
            
         }
         
      }

      $current = array_search( $ref, $groupArray );
      $next = $current+1;
      $prev = $current-1;
      if ( $current == 0 ) {
         
         $prev = count( $groupArray )-1;
         
      }
      else if ( $current == count( $groupArray )-1 ) {
         
         $next = 0;
         
      }
      
      // Language.
      $curLanguage = RunTimeData::get( 'language', 'current' );
      $defaultLanguage = Settings::get( 'setup', 'defaultlanguage' );
      
      $languageCode = $curLanguage != $defaultLanguage ? '/' . $curLanguage : '';
      
      $this->setTemplate( 'product' );
      $data = array(
         'ref' => $ref,
         'next' => $groupArray[ $next ],
         'previous' => $groupArray[ $prev ],
         'languagecode' => $languageCode,
         'textnext_eng' => 'next',
         'textnext_nor' => 'neste',
         'textprev_eng' => 'previous',
         'textprev_nor' => 'forrige'
         );
      $this->setData( $data );

   }
   
   public function getProductImageUrl( $ref, $seq ) {

      // Set template to null to avoid the template engine.
      $this->setTemplate( null );
      
      $image = new Image( $ref, $seq );
      $image->setDimension( array( 'longest' => 500 ) );
      
      $data = array(
         'rawdata' => "<img src=\"" . $image->getUrl() . "\" width=\"" . $image->getX() . "\" height=\"" . $image->getY() . "\" data-magnify-src=\"" . $image->getUrl( true ) . "\" />"
         );

      $this->setData( $data );
      
   }
   
}

?>
