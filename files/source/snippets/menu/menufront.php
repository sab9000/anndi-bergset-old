<?php

class MenuMenufront {
   
   public function Execute() { 

      // Get menu data for the group.
      $menuData = Menu::getMenuData( 'menufront' );
      
      $curLanguage = RunTimeData::get( 'language', 'current' );
      $defaultLanguage = Settings::get( 'setup', 'defaultlanguage' );
      
      $menuStr = '';
      $counter = 1;
      foreach ( $menuData as $value ) {
         
         $url = $curLanguage != $defaultLanguage ? '/' . $curLanguage . $value[ 'url' ] : $value[ 'url' ];
         $title = $value[ 'title_' . $curLanguage ]; 
         
         $menuStr .= "
            <div class=\"fpb_item fpb_item" . $counter++ . "\">
            <div class=\"fpb_itemimage\">
            <a href=\"" . $url . "\"><img alt=\"" . $title . "\" src=\"/images/fpb-image-" . ltrim( $value[ 'id' ], '/' ) . ".jpg\" width=\"150\" height=\"322\" /></a>
            </div>
            <span class=\"fpb_itemtext\"><a href=\"" . $url . "\">" . $title . "</a></span>
            </div>
            ";
         
      }
      
      return $menuStr;
      
   }
   
}

?>
