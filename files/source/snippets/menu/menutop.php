<?php

snippet( 'menu.default' );

class MenuMenutop extends MenuDefault {
   
   public function Execute() {
      
      // Get menu data for the group.
      $menuData = Menu::getMenuData( 'menutop' );

      // Create menu
      $menuStr = $this->makeMenu( $menuData );

      return $menuStr;
      
   }
   
}

?>
