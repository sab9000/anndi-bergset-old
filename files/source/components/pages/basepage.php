<?php

define( 'IC_INTEGER', 0 );
define( 'IC_ESCAPE', 1 );
define( 'IC_ARRAY', 2 );
define( 'IC_DEFAULT', 3 );
define( 'IC_DROP', 4 );

class BasePage extends BaseClass {

   private $checks;
   protected $template;
   protected $fieldData = array();
   protected $basePrefs = array();
   
   public function __construct( $basePrefs ) {
      
      $this->basePrefs = $basePrefs;
      
   }
   
   public function runTemplate( $data = null, $template = null ) {

      // Get base path for views (templates).
      $basePath = Settings::get( 'setup', 'basepathviews' );

      if ( !isset( $template ) ) {
         
         $template = $this->template;
         
      }
      
      // Just return data from page method if no template is found and 'rawdata' is populated.
      if ( is_null( $template ) && isset( $data[ 'rawdata' ] ) ) {
         
         return $data[ 'rawdata' ];
         
      }
      
      list( $foundFile, $fileName ) = $this->parseInstancePath( $basePath . $template, 'default', 'html' );

      if ( $foundFile ) {
         
         $content = $this->parseTemplate( file_get_contents( $fileName ), $data );

         return $content;
         
      }
      else {
         
         die( 'Could not find template file.' );
         
      }
      
   }
   
   public function parseTemplate( $code, $data = array() ) {
      
      $engine = new SABEDB_Engine();
      $engine->setTemplateCode( $code );
      $engine->setData( $data );
      return $engine->run();
      
   }
   
   public function setTemplate( $template ) {
      
      $this->template = $template;
      
   }
   
   public function getTemplate() {
      
      return $this->template;
      
   }
   
   public function setData( $data ) {
      
      $this->fieldData = $data;
      
   }
   
   public function getData() {
      
      return $this->fieldData;
      
   }
   
   public function getPref( $key ) {
      
      return $this->basePrefs[ $key ];
      
   }
   
   public function setInputRestrictions( $checks = false ) {
      
      $this->checks[ 'input' ] = $checks;
      
   }
   
   public function hasInputChecks() {
      
      return ( isset( $this->checks[ 'input' ] ) && count( $this->checks[ 'input' ] ) ) ? true : false;
      
   }
   
   public function validateInputChecks( $params, $function, $key = null ) {
   }
   
   public function redirectTo( $path ) {
      
      $prefix = RunTimeData::get( 'language', 'reallanguagepath' );
      
      $url =  $prefix . str_replace( '.', '/', $path );

      redirect( $url );
      
   }

}

?>
