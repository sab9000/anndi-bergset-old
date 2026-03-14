<?php

class Controller extends BaseClass {

   public function __construct() {
   }
   
   public function processRequest() {
      
      $content = true;
      $qvars = array();
      $qs = explode( '&', $_SERVER[ 'QUERY_STRING' ] );
      foreach ($qs as $q ) {
   
         if ( strstr( $q, '=' ) !== false ) {
      
            list( $key, $value ) = explode( '=', $q );
            $qvars[$key] = $value;
   
         }
   
      }
      $doPath = $qvars[ 'dopath' ] ?? '/';
     
      $realdopath = substr( $doPath, 1);

      // Capture root path.
      if ( $realdopath == 'index.php' || $realdopath == 'index.html' ) {
         $realdopath = '';
         $doPath = '/';
      }
      $path = explode( '/', $realdopath );

      // Check language.
      if ( in_array( $path[0], explode( ',', Settings::get( 'setup', 'supportedlanguages' ) ) ) ) {
         
         // Save the current language in the runtime data.
         RunTimeData::set( 'language', 'current', $path[ 0 ] );
         
         // Clean up path.
         if ( empty( $path[ 1 ] ) ) {
            
            $path = array();
            $realdopath = '';
            $doPath = '/';
            
         }

         // Remove the language code from the path.
         array_shift( $path );
         $doPath = '/' . implode( '/', $path );
         $realdopath = substr( $doPath, 1);
            
      }
      else {
         
         // Set language to default language.
         RunTimeData::set( 'language', 'current', Settings::get( 'setup', 'defaultlanguage' ) );
         
      }
      
      // Set the current language prefix to URLs depending on the default and current languages.
      RunTimeData::set( 'language', 'reallanguagepath', RunTimeData::get( 'language', 'current' ) != Settings::get( 'setup', 'defaultlanguage' ) ? '/' . RunTimeData::get( 'language', 'current' ) . '/' : '/' );

      $basepath = '/' . $path[0];

      // Save data.
      RunTimeData::set( 'request', 'basepath', $basepath );
      RunTimeData::set( 'request', 'modulepath', $realdopath );
      
      // Find if this is "real" file (css, js)
      if ( strstr( $realdopath, '.' ) !== false ) {
         
         // Find file extension.
         $fileParts = explode( '.', $realdopath );
         // Use last part as extension.
         $filetype = array_pop( $fileParts );
         // Build rest of file back up.
         $file = implode( $fileParts );
         
         if ( !empty($filetype) ) {
            $content = false;
         }
         
      }

      if ( $content ) {
         
         $this->execute( $realdopath, $qvars );
         
      }
      else {
         
         $this->streamStatic( $realdopath, $filetype );
         
      }
      
   }
   
   public function execute( $path, $qvars = null ) {
      
      $this->findModule( $path );
      
   }
   
   public function findModule( $path ) {

      // Check registered pages for static urls.
      $item = Menu::checkUrl( '/' . $path );

      if ( !is_null( $item ) ) {
         
         $urlpath = $item[ 'path' ];
         
         $basepage = new Basepage();
         $basepage->setTemplate( $item[ 'template' ] );
         
         $content = $basepage->runTemplate( array( 'ref' => $item[ 'id' ] ) );
         
         if ( $content ) {
            
            echo $content;
            
         }
         
      }
      else {

         // Check if any page can be found.
         list( $foundFile, $fileName, $className, $restParams ) = $this->parseInstancePath( PAGES_ROOT_PATH . $path, 'default', 'php', true );
         //header( 'Content-Type: text/html; charset=UTF-8' );

         // If php file was found.
         if ( $foundFile ) {
            
            include_once( $fileName );

            if ( class_exists( $className ) ) {

               $object = new $className();
               
               $function = $restParams[ 0 ];
               
               if ( !method_exists( $object, $function ) ) {
                              
                  $function = 'execute';
                  
               }
               else {
                  
                  array_shift( $restParams );
                  
               }

               if ( $object->hasInputChecks() ) {
         					   
                  // Validate inputs against the method to be called.
                  $params = $object->validateInputChecks( $restParams, $function );
         					   
                  // Validate GPC params and return them to global GPC variables.
                  #$_GET = $object->validateInputChecks( $_GET, $function, 'get' );
                  #$_POST = $object->validateInputChecks( $_POST, $function, 'post' );
                  #$_COOKIE = $object->validateInputChecks( $_COOKIE, $function, 'cookie' );
                  #$files = $object->validateInputChecks( $files, $function, 'files' );
                           
               }
              
               $handler = array( $object, $function );
                  
               if ( is_callable( $handler ) ) {

                  $return = call_user_func_array( $handler, $restParams );

                  if ( $return === false ) {

                     die( "Error..." );
                     
                  }
                  
                  $data = $object->getData();
                  $template = $object->getTemplate();

                  if ( $content = $object->runTemplate( $data, $template ) ) {

                     echo $content;                     
                     
                  }
   
               }
               
            }
            
            
         }
         else {
            
            die( "No main view file found!" );
            
         }
         
         
      }
      
   }
   
   public function streamStatic( $path, $filetype ) {
      
      $contTypes = array(
         'css' => 'text/css',
         'js' => 'text/javascript',
         'jpg' => 'image/jpeg',
         'gif' => 'image/gif',
         'png' => 'image/png',
         'ico' => 'image/x-icon',
         'doc' => 'application/msword',
         'pdf' => 'application/pdf',
         'otf' => 'application/x-font-opentype',
         'ttf' => 'application/x-font-ttf'
         );
      if ( array_key_exists( $filetype, $contTypes ) ) {
         
         $curCT = $contTypes[ $filetype ];
         
      }
      else {
      
         $curCT = 'application/octet-stream';
         
      }
   
      if ( file_exists( realpath( $path ) ) ) {
         
         if ( !empty( $curCT ) ) {
            
            header( 'Content-Type: ' . $curCT );
            
         }
         
         readfile( realpath( $path ) );
         
      }
      
   }
   
}

?>
