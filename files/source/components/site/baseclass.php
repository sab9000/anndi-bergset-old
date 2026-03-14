<?php

class BaseClass {
   
   // Reference to page id (whole pages, individual items like product)
   protected $ref;
   
   // Temporary data, before MySQL is implemented.
   private $dbData;
   
   public function queryField( $field ) {

      // Load data from 'database'.
      $this->loadDataSet();

      $curLanguage = RunTimeData::get( 'language', 'current' );
      
      $out = null;
      $found = false;
      foreach ( $this->dbData->product as $d ) {

         if ( isset( $this->ref ) && $d->id == $this->ref ) {
         
            // Check if language version of field is present.
            $lField = $field . '_' . $curLanguage;
            if ( isset( $d->$lField ) ) {
               
               $field = $lField;
               
            }
            
            $out = $d->$field;
            $found = true;
            break;
            
         }
         
      }
      
      // Hack until data goes to database.
      if ( !$found ) {
         
         $out = null;
         foreach ( $this->dbData->pages as $d ) {
   
            if ( isset( $this->ref ) && $d->id == $this->ref ) {

               // Check if language version of field is present.
               $lField = $field . '_' . $curLanguage;
               if ( isset( $d->$lField ) ) {
                  
                  $field = $lField;
                  
               }
               
               $out = $d->$field;
               break;
               
            }
            
         }

      }
      
      return $out;
      
   }
   
   protected function loadDataSet() {
      
      // Read data once.
      if ( empty( $this->dbData ) ) {
         
         $dataFile = '../../data/products.txt';
         $dataFile2 = '../../data/pages.txt';
      
         $d1 = json_decode( file_get_contents( $dataFile ) );
         $d2 = json_decode( file_get_contents( $dataFile2 ) );
         // Load product data.
         $this->dbData = $d1;
         $this->dbData->pages = $d2->pages;

      }
      
   }
   
   public function getDataSet() {
      
      $this->loadDataSet();
      
      return $this->dbData;
      
   }
   
   public function parseInstancePath( $path, $defaultFileName, $fileExtension, $doOO = false ) {

      // Make sure all periods are replaced, except the preceding directory changers.
      if ( preg_match( '/([\.\/]*)(.+)/', $path, $matches ) ) {
         
         $path = $matches[ 1 ] . str_replace( '.', '/', $matches[ 2 ] );
         
      }
      
      // Put path parts into array for easy traversing.
      $parts = explode( '/', trim( $path, '/' ) );

      $checkPath = $fileName = '';
      $foundFile = false;
      
      // For OO class finding.
      $restParams = array();
      $className = '';

      while ( !empty( $parts ) ) {
      
         $checkPath = implode( '/', $parts );
         $fileName = $checkPath . ".$fileExtension";
      
         // Check if full file exists.
         if ( file_exists( $fileName ) ) {
         
            // OO class.
            if ( $doOO ) {
               
               $className = ucfirst( $parts[ count( $parts )-2 ] ) . ucfirst( $parts[ count( $parts )-1 ] );
               
            }
            $foundFile = true;
            break;
         
         }
         else if ( file_exists( $checkPath . "/$defaultFileName.$fileExtension" ) ) {
         
            // OO Class.
            if ( $doOO ) {
               
               $className = ucfirst( $parts[ count( $parts )-1 ] ) . ucfirst( $defaultFileName );
               
            }
            
            $fileName = $checkPath . "/$defaultFileName.$fileExtension";
            $foundFile = true;
            break;
         
         }
         else {
         
            if ( $doOO ) {
               
               $restParams[] = array_pop( $parts );
               
            }
            else {
            
               array_pop( $parts );
               
            }
         
         }
      
      }

      return array( $foundFile, $fileName, $className, array_reverse( $restParams ) );
      
   }
   
   public function setRef( $ref ) {
      
      $this->ref = $ref;
      
   }
   
}

?>
