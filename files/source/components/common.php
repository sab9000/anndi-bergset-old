<?php

define( 'CONFIGURATION_ROOT_PATH', '../../configuration/' );
define( 'COMPONENTS_ROOT_PATH', '../../source/components/' );
define( 'SNIPPETS_ROOT_PATH', '../../source/snippets/' );
define( 'PAGES_ROOT_PATH', '../../source/website/' );

function import( $path ) {
   
   $filePath = str_replace( '.', '/', $path );
   
   $fullPath = COMPONENTS_ROOT_PATH . $filePath . '.php';
   
   if ( file_exists( $fullPath ) ) {
      
      include_once( $fullPath );
      
   }
   
}

function configure( $path ) {
   
   $filePath = str_replace( '.', '/', $path );
   
   $fullPath = CONFIGURATION_ROOT_PATH . $filePath . '.php';
   
   if ( file_exists( $fullPath ) ) {
      
      include_once( $fullPath );
      
   }
   
}

function snippet( $path ) {
   
   $filePath = str_replace( '.', '/', $path );
   
   $fullPath = SNIPPETS_ROOT_PATH . $filePath . '.php';
   
   if ( file_exists( $fullPath ) ) {
      
      include_once( $fullPath );
      
   }
   
}

function redirect( $url = '' ) {
      
   // RFC "Found".
   header( ' ', true, 302 );
   
   // Redirect.
   header( "Location: $url" );
   
   // If no success.
   die( sprintf( '<h1>HTTP/1.0 302 Found</h1>The object has moved <a href="%s">here</a>.', htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' ) ) );
      
}

?>
