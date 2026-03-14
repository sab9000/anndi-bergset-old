<?php

class MenuDefault {
   
   protected function MakeMenu( $menu, $basepath = null ) {
   
      $curLanguage = RunTimeData::get( 'language', 'current' );
      $defaultLanguage = Settings::get( 'setup', 'defaultlanguage' );

      $mStr = '';
      foreach ( $menu as $value ) {
         
         // Only display menu items with display bit set to true.
         if ( 1==1 ) {

            $mStr .= "<li";
            if ( $value[ 'url' ] == $basepath ) {
               $mStr .= ' class="active"';
            }
            
            $externalAttr = '';
            if ( substr( $value[ 'url' ], 0, 4 ) == 'http' ) {
            
               $url = $value[ 'url' ];
               $externalAttr = ' target="_blank"';
               
            }
            else {
               
               $url = ( $curLanguage != $defaultLanguage ? '/' . $curLanguage : '' ) . $value[ 'url' ];
               
            }
            $mStr .= '><a href="' . $url . '"' . $externalAttr  . '>';
            $mStr .= $value[ 'title_' . $curLanguage ];
            $mStr .= '</a>';
            $mStr .= "</li>\n";
            
         }
         
         // Recurse submenus.
         /*if ( isset( $value[3] ) && is_array( $value[3] ) ) {
            
            $mStr .= "\n<ul>\n";
            $mStr .= $this->MakeMenu( $value[3], $basepath );
            $mStr .= "</ul>\n";
            
         }*/
         
         // Close menu block.
         /*if ( $value[ 2 ] ) {
            
            $mStr .= "</li>\n";
            
         }*/
         
      }
      
      return $mStr;
   
   }
   
}

?>
