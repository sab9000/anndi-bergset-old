<?php

class Element_Menufront {
   
   public static function write() { 

      global $menuFront, $curLang;
      
      $menuStr = '';
      $counter = 1;
      foreach ( $menuFront[ $curLang ] as $key=>$value ) {
         
         $menuStr .= "
            <div class=\"fpb_item fpb_item" . $counter++ . "\">
            <div class=\"fpb_itemimage\">
            <a href=\"" . $key . "\"><img alt=\"" . $value[0] . "\" src=\"/images/fpb-image-" . ltrim( $key, '/' ) . ".jpg\" width=\"150\" height=\"322\" /></a>
            </div>
            <span class=\"fpb_itemtext\"><a href=\"" . $key . "\">" . $value[0] . "</a></span>
            </div>
            ";
         
      }
      
      return $menuStr;
      
   }
   
}

?>
