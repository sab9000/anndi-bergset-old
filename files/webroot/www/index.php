<?php

// Include common functions.
include( '../../source/components/common.php' );

configure( 'website.config' );
configure( 'website.modules' );

// Start the controller.
$website = new Controller();

$website->processRequest();

?>
