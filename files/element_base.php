<?php

class Element_Base {
   
   protected $settings;
   
   public function __construct( $settings = array() ) {
      
      if ( isset( $settings ) ) {
         
         $this->settings = $settings;
         
      }
      
   }
   
}

?>
