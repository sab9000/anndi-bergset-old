<?php

class HomeDefault extends BasePage {
 
   public function Execute() {
      
      $this->setTemplate( 'home' );
      
      $this->runTemplate();
   }
   
}

?>
