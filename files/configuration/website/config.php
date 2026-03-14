<?php

// Import settings module.
import( 'site.settings' );

Settings::set( 'setup', 'basepathviews', '../../templates/common/views/' );
Settings::set( 'setup', 'supportedlanguages', 'nor,eng' );
Settings::set( 'setup', 'defaultlanguage', 'nor' );

Settings::set( 'images', 'thumbx', '100' );
Settings::set( 'images', 'thumby', '100' );

Settings::set( 'images', 'thumbx_min', '45' );
Settings::set( 'images', 'thumby_min', '45' );

configure( 'website.external' );

?>
