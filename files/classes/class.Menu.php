<?php

class Menu {
   
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
            $mStr .= $this->makeMenu( $value[3], $basepath );
            $mStr .= "</ul>\n";
            
         }
         
         // Close menu block.
         if ( $value[ 2 ] ) {
            
            $mStr .= "</li>\n";
            
         }
         
      }
      
      return $mStr;
   
   }
   
}

?>
