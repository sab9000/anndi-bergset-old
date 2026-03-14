<?php

// General menu maker.
function makeMenu( $menu, $basepath ) {
   
   global $curLang, $supportedLangs;
   
   $mStr = '';
   foreach ( $menu as $key=>$value ) {
      
      // Only display menu items with display bit set to true.
      if ( $value[ 2 ] ) {
      
         $mStr .= "<li";
         if ( $key == $basepath ) {
            $mStr .= ' class="active"';
         }
         $url = ( $curLang != $supportedLangs[0] ? '/' . $curLang : '' ) . $key;
         $mStr .= '><a href="' . $url . '">';
         $mStr .= $value[0];
         $mStr .= '</a>';
         
      }
      
      // Recurse submenus.
      if ( isset( $value[3] ) && is_array( $value[3] ) ) {
         
         $mStr .= "\n<ul>\n";
         $mStr .= makeMenu( $value[3], $basepath );
         $mStr .= "</ul>\n";
         
      }
      
      // Close menu block.
      if ( $value[ 2 ] ) {
         
         $mStr .= "</li>\n";
         
      }
      
   }
   
   return $mStr;
   
}

function searchArrayMulti( $heystack, $needle, $indexSearch, $indexRecurse ) {
   
   // Loop through all items in array.
   $found = null;
   foreach ( $heystack as $key=>$hey ) {
      
      // Define which data to search in.
      $search = null;
      if ( is_null( $indexSearch ) ) {
         
         $search = $key;
         
      }
      else {
         
         $search = $hey[ $indexSearch ];
          
      }
      
      // Compare data.
      if ( $search == $needle ) {
         
         return $hey;
         
      }
      // Make desicions for possible recursion.
      else if ( isset( $hey[ $indexRecurse ] ) && is_array( $hey[ $indexRecurse ] ) ) {
      
         $found = searchArrayMulti( $hey[ $indexRecurse ], $needle, $indexSearch, $indexRecurse );
         
         // If something was found in last recursion, trickle down.
         if ( !is_null( $found ) ) {
            
            return $found;
            
         }
         
      }
      
   }
   
   // Return null if nothing was found in this recursion.
   return $found;
   
}

function parseCode( $code ) {
   
   $search = '/<sabedb:(\w+) id="([\w\/\\-_]+)"( ref="){0,1}([\w\/\\-_]*)("){0,1}( pref="){0,1}([\w\/\\-_;:,.]*)("){0,1} \/>/';

   return preg_replace_callback( $search, function( $m ) {
      return processToView( $m[1], $m[2], $m[4] ?? '', $m[7] ?? '' );
   }, $code );
   
}

function processToView( $type, $id, $ref = null, $pref = null ) {
   
   switch ( $type ) {
      
      case 'content':
         return processParsedCode( $id );
         break;
         
      case 'file':
         return processFileInsert( $id, $ref, $pref );
         break;

      case 'element':
         return processElementInsert( $id );
         break;
         
         
   }
   
}

function processParsedCode( $keyword ) {
   
   global $urlpath;
   
   $strOut = '';
   if ( $keyword == 'jscode' ) {
      
      $fileName = "js/src/filedeps/" . $urlpath . ".js";

      if ( file_exists( $fileName ) ) {
      
         $strOut .= "<script type=\"text/javascript\">\n";
         $strOut .= file_get_contents( $fileName ); 
         $strOut .= "\n</script>";
         
      }
      
   } 
   
   return $strOut;
   
}

function processFileInsert( $id, $ref = null, $pref = null ) {
   
   $fileId = explode( '/', $id ); 
   $fileName = 'files/' . $fileId[ 0 ] . '_' . $fileId[ 1 ] . '.php';
   
   $className = $fileId[ 0 ] . '_' . $fileId[ 1 ];
   
   include ( $fileName );
   
   // Create settings to pass to instantiated class.
   $settings = array();
   if ( isset( $ref ) ) {
      
      $settings[ 'ref' ] = $ref;
      
   }
   // Examine preferences if set.
   if ( isset( $pref ) ) {
      
      // Split definitions.
      $fdef = array();
      $odef = explode( ',', $pref );
      foreach ( $odef as $od ) {
         
         $fd = explode( ':', $od );
         $fdef[ trim( $fd[ 0 ] ) ] = trim( $fd[ 1 ] );  
          
      }
      
      $settings[ 'pref' ] = $fdef;
      
   }
   
   $class = new $className( $settings );
   
   return $class->write();
   
   
}

function processElementInsert( $id ) {
   
   global $urlpath;
   
   $strOut = '';
   if ( $id == 'jscode' ) {
      
      $fileName = "js/src/filedeps/" . $urlpath . ".js";

      if ( file_exists( $fileName ) ) {
      
         $strOut .= "<script type=\"text/javascript\">\n";
         $strOut .= file_get_contents( $fileName ); 
         $strOut .= "\n</script>";
         
      }
      
   } 
   
   return $strOut;
   
}

function parseOOPath( $path ) {
   
   $basePath = 'files/source/website/';
   
   $parts = explode( '/', trim( $path, '/' ) );


   $checkPath = $fileName = '';
   $foundFile = false;
   $restParams = array();
   $className = '';
   while ( !empty( $parts ) ) {
      
      $checkPath = $basePath . implode( '/', $parts );
      $fileName = $checkPath . '.php';
      
      // Check if full file exists.
      if ( file_exists( $fileName ) ) {
         
         $className = ucfirst( $parts[ count( $parts )-2 ] ) . ucfirst( $parts[ count( $parts )-1 ] );
         $foundFile = true;
         break;
         
      }
      else if ( file_exists( $checkPath . '/default.php' ) ) {
         
         $fileName = $checkPath . '/default.php';
         $className = ucfirst( $parts[ count( $parts )-1 ] ) . 'Default';
         $foundFile = true;
         break;
         
      }
      else {
         
         $restParams[] = array_pop( $parts );
         
      }
      
   }
   
   // If php file was found.
   if ( $foundFile ) {
      
      include_once( $fileName );
       
      if ( class_exists( $className ) ) {
        
         $object = new $className();
         
         $function = $restParams[ count( $restParams )-1 ];
         
         if ( !method_exists( $object, $function ) ) {
                        
            $function = 'execute';
            
         }
         else {
            
            array_shift( $restParams );
            
         }
        
         $handler = array( $object, $function );
            
         if ( is_callable( $handler ) ) {
         
            $return = @call_user_func_array( $handler, $restParams );
#$dbgf=fopen('/tmp/debugphp.log','a');fwrite($dbgf,"\n\n".date('Y-m-d_H:i:s.U').":\n".print_r($return,true)."\n");fclose($dbgf);            
         }
         
      }
      
      
   }
   else {
      
      die( "No file found!" );
      
   }
   
}

?>
