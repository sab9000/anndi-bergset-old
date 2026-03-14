<?php

class Menu {

   static $menuData = array();
   
   static function retrieveMenuData() {
   
      // Data file.
      $dataFile = "../../data/menus.txt";
      
      // Load product data.
      $data = json_decode( file_get_contents( $dataFile ) );
      
      foreach ( $data as $group => $items ) {

         foreach ( $items as $data ) {
            
            self::setMenuItem( $group, $data->id, $data->url, $data->path, $data->title_eng, $data->title_nor, $data->template );
            
         }
         
      }
   
   }
   
   static function setMenuItem( $group, $key, $url, $path, $title_eng, $title_nor, $template ) {
      
      if ( !isset( self::$menuData[ $group ] ) ) {
      
         self::$menuData[ $group ] = array();
         
      }
      
      self::$menuData[ $group ][] = array(
         'id' => $key,
         'url' => $url,
         'path' => $path,
         'title_eng' => $title_eng,
         'title_nor' => $title_nor,
         'template' => $template
         );
      
   }
   
   static function getMenuData( $menuGroup ) {
      
      // Retrieve menu data if empty.
      if ( empty( self::$menuData ) ) {
         
         self::retrieveMenuData();
         
      }
      
      if ( isset( self::$menuData[ $menuGroup ] ) ) {
         
         return self::$menuData[ $menuGroup ];
         
      }
      
   }
   
   static function checkUrl( $path ) {
      
      // Retrieve menu data if empty.
      if ( empty( self::$menuData ) ) {
         
         self::retrieveMenuData();
         
      }
      
      $out = null;

      foreach ( self::$menuData as $m ) {
         
         foreach ( $m as $item ) {
            
            if ( $item[ 'url' ] == $path ) {

               $out = $item;
               
            }
            
         }
         
      }
      
      return $out;
      
   }


}

?>
