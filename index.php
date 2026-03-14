<?php

// Include tools and lists.
#include_once( 'inc/imagelist.php' );
include_once( 'inc/menudef.php' );
include_once( 'inc/tools.php' );

// Set default language.
$curLang = 'eng';

// Extract path and query variables from rewritten URI.
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
if ( in_array( $path[0], $supportedLangs ) ) {
   
   $curLang = $path[0];
   array_shift( $path );
   $doPath = '/' . implode( '/', $path );
   
}

$basepath = '/' . $path[0];

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

// Process content.
if ( $content ) {

   // Set it OOP is used.
   $useOOP = false;
   
   // Merge menues.
   $item = searchArrayMulti( array_merge( $menuTop[$curLang], $menuFront[$curLang], $menuProduct[$curLang] ?? array() ), $doPath, null, 3 );
   $urlpath = '';
   if ( !is_null( $item ) ) {

      $urlpath = $item[1];
      
   }
   else {
      
      $useOOP = true;
      
   }

   $realurl = str_replace( '.', '/', $urlpath ) . ( $curLang != $supportedLangs[0] ? '_' . $curLang : '' ) . '.php';
   header( 'Content-Type: text/html; charset=UTF-8' );
   
   // Insert top template if not told otherwise.
   if ( ($item[ 3 ] ?? false) !== true ) {

      echo parseCode( file_get_contents( 'inc/templ-top.php' ) );

   }
   // Insert content.
   if ( !$useOOP && file_exists( $realurl ) ) {

      echo parseCode( file_get_contents( $realurl ) );

   }
   else {

      echo parseOOPath( $doPath );

   }
   // Insert bottom template if not told otherwise.
   if ( ($item[ 3 ] ?? false) !== true ) {
   
      echo parseCode( file_get_contents( 'inc/templ-bottom.php' ) );
      
   }
   
}
// Stream ordinary files (images,css,js).
else {

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
   } else {
      $curCT = 'application/octet-stream';
   }

   if ( file_exists( realpath( $realdopath ) ) ) {
      if ( !empty($curCT) ) header( 'Content-Type: ' . $curCT );
      readfile( realpath($realdopath) );
   }
}

?>
