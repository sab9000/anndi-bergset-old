<?php
   
class RunTimeData {

   // The global settings.   
   static $data;
   
   static function set( $section, $variable, $value ) {
      
      RunTimeData::$data[ $section ][ $variable ] = $value;
      
   }
   
   static function get( $section, $variable ) {
      
      return RunTimeData::$data[ $section ][ $variable ];
      
   }

}
   
?>
