<?php

class SiteDefault {
   
   protected $curLanguage;
   protected $defaultLanguage;
   
   public function __construct() {
      
      // Get the language settings.
      $this->curLanguage = RunTimeData::get( 'language', 'current' );
      $this->defaultLanguage = Settings::get( 'setup', 'defaultlanguage' );
      
   }
   
   public function languageLink( $language ) {

      $basePath = RunTimeData::get( 'request', 'basepath' );

      // Check if language prefix should be used.
      if ( $language == $this->defaultLanguage ) {
         
         return $basePath;
         
      }
      else {
         
         return '/' . $language . $basePath;
         
      }
      
   }
   
   public function currentLanguageCode( $pre = '' ) {
      
      $out = '';
      
      if ( $this->curLanguage != $this->defaultLanguage ) {
      
         $out = $this->curLanguage;
         
         if ( $pre == 'prebar' ) {
            
            $out = '_' . $out;
            
         }
         
         if ( $pre == 'slash' ) {
            
            $out = '/' . $out;
            
         }
         
      }
      
      return $out;
      
   }
   
}

?>
