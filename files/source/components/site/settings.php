<?php
   
class Settings {

   // The global settings.   
   static $settings;
   
   static function set( $section, $variable, $value ) {
      
      Settings::$settings[ $section ][ $variable ] = $value;
      
   }
   
   static function get( $section, $variable ) {
      
      return Settings::$settings[ $section ][ $variable ];
      
   }
   
   static function setSection( $section, $valuepairs ) {
      
      if ( !is_array( $valuepairs ) ) {
         
         return false;
         
      }
      
      Settings::$settings[ $section ] = $valuepairs;
      
   }
   
   static function getSection( $section ) {
      
      if ( is_array( Settings::$settings[ $section ] ) ) {
         
         return Settings::$settings[ $section ];
         
      }
      else {
         
         return array();
         
      }

   }
   
}
   
?>
