<?php

require_once( 'classes/class.Menu.php' );

class Element_Menutop extends Menu {
   
   public static function write() {
      
      global $menuTop, $curLang;
      
      // Create menu
      $menuStr = self::makeMenu( $menuTop[ $curLang ], $basepath );

      return $menuStr;
      
   }
   
}

?>
