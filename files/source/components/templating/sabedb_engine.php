<?php

class SABEDB_Engine extends BaseClass {
   
   protected $code;
   protected $data;
   protected $context;
   
   public function setTemplateCode( $code ) {
      
      $this->code = $code;
      
   }
   
   public function setData( $data ) {

      $this->data = $data;
      $this->ref = $this->data[ 'ref' ] ?? null;
      
   }
   
   public function run() {
      
      $this->context = 'website';

      return $this->parseCode();
      
   }
   
   private function parseCode() {

      $search = '/<sabedb:(\w+) id="([\w\/\\-_\.]+)"( ref="){0,1}([\w\/\\-_\.]*)("){0,1}( pref="){0,1}([\w\/\\-_;:,.]*)("){0,1}( group="){0,1}([\w\/\\-_;:,.]*)("){0,1} \/>/';
      $replace = array( $this, 'processToView' );

      $content = preg_replace_callback( $search, $replace, $this->code );

      return $content;
   
   }
   
   private function processToView( $matches ) {

      $type = $matches[ 1 ];
      $id = $matches[ 2 ];
      $ref = $matches[ 4 ];
      $pref = $matches[ 7 ];
      $group = $matches[ 10 ];

      $this->context = $type;
      
      switch ( $type ) {
      
         case 'content':
            return $this->processContent( $id );
            break;
            
         case 'snippet':
            return $this->parseOOPath( $id );
            break;
            
         case 'setup':
            return $this->parseSetup( $id );
            break;
            
         case 'include':
            return $this->parseInclude( $id );
            break;
            
         case 'ref':
            return $this->ref;
            break;
   
      }
      
   }
   
   private function processContent( $id ) {

      // If a key exists in received data that matches content id.
      if ( isset( $this->data[ $id ] ) ) {
         
         return $this->data[ $id ];
         
      }
      
      // If language versions of key exists.
      $key = $id . '_' . RunTimeData::get( 'language', 'current' );
      if ( isset( $this->data[ $key ] ) ) {
         
         return $this->data[ $key ];
         
      }
      
      // If no received data was found, consult database.
      return $this->queryField( $id );
      
   }
   
   private function parseOOPath( $path ) {

      $basePath = PAGES_ROOT_PATH;
      
      // Change context.
      switch ( $this->context ) {
         
         case 'snippet':
            $basePath = SNIPPETS_ROOT_PATH;
            break;
         
      }

      list( $foundFile, $fileName, $className, $restParams ) = $this->parseInstancePath( $basePath . $path, 'default', 'php', true );

      // If php file was found.
      if ( $foundFile ) {
         
         include_once( $fileName );

         if ( class_exists( $className ) ) {
           
            // Send parent's data to instantiated class.
            $prefs = array(
               'parentdata' => $this->data
               );
            // Instantiate class. 
            $object = new $className( $prefs );
            
            $function = $restParams[ 0 ] ?? null;

            if ( $function === null || !method_exists( $object, $function ) ) {
                           
               $function = 'execute';
               
            }
            else {
               
               array_shift( $restParams );
               
            }
           
            $handler = array( $object, $function );
               
            if ( is_callable( $handler ) ) {

               $return = call_user_func_array( $handler, $restParams );

               if ( $return !== false ) {

                  return $return;
                  
               }
               
            }
            
         }
         
         
      }
      else {
         
         die( "No page file found!".$path );
         
      }
      
   }
   
   public function parseSetup( $id, $ref = null ) {
      
      switch ( $id ) {
      
         case 'jscode':
            $fileBase = 'js/src/filedeps/';
            $fileName = $fileBase . 'files.' . RunTimeData::get( 'request', 'modulepath' ) . '.js';

            if ( file_exists( $fileName ) ) {
            
               $content = "<script type=\"text/javascript\">\n";
               $content .= file_get_contents( $fileName );
               $content .= "</script>\n";
               return $content;
               
            }
            break;
            
         case 'include':
            $basePage = new BasePage();
            $content = $basePage->runTemplate( null, $ref );
            return $content;
            break;
            
      }
      
   }   
   
   public function parseInclude( $id ) {
      
      $basePage = new BasePage();
      $content = $basePage->runTemplate( null, $id );
      return $content;
      
   }
   
}

?>
