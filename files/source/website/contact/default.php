<?php

class ContactDefault extends BasePage {
   
   public function __construct() {
   
      $this->setInputRestrictions( array(
            'execute' => array(
               'params' => array( IC_DEFAULT ),
               'post' => array(
                  'save' => array(
                     'memberuuid' => IC_DEFAULT
                     )
                  )
               )
            )
         );
      
   }
   
   public function send() {

      $vName = $_POST[ 'name' ];
      $vEmail = $_POST[ 'email' ];
      $vMessage = $_POST[ 'message' ];
      
      $responseEmail = 'anndi@bergset.com';
      #$responseEmail = 'sab@bergset.com';
      $subject = "Response from web form: $vName";
      
      $msg = "From: $vName <$vEmail>\n\n$vMessage\n\n";
      
      // Set sensible headers.
      $headers = array();
      $headers[] = "MIME-Version: 1.0";
      $headers[] = "Content-type: text/plain; charset=iso-8859-1";
      $headers[] = "From: " . $vName . " <" . $vEmail . ">";
      $headers[] = "Reply-To: " . $vName . " <" . $vEmail  . ">";
      $headers[] = "Subject: " . $subject;
      $headers[] = "X-Mailer: PHP/" . phpversion();
      
      
      if ( $ret = mail( $responseEmail, $subject, $msg, implode("\r\n", $headers), "-f $vEmail" ) ) {
         
         $this->redirectTo( 'contact.response' );         
         
      }
      else {
         
         die( "Some email stuff went wrong." );
         
      }

   }
   
   public function response() {
      
      $this->ref = 'response';

      $this->setTemplate( 'contact.response' );
      $this->setData( array(
         'title' => $this->queryField( 'title' ),
         'text' => $this->queryField( 'text' )
         ) );
      
   }
   
}

?>
