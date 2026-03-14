<?php

// Array of supported languages.
$supportedLangs = array( 'eng', 'nor' );

// Define top menu.
$menuTop = array(
   'eng' => array(
      '/' => array( 'home', 'files.frontpage', true ),
      '/shop' => array( 'shop', 'files.shop', true ),
      '/portfolio' => array( 'portfolio', 'files.portfolio', true ),
      '/about' => array( 'about', 'files.about', true ),
      '/contact' => array( 'contact', 'files.contact', true ),
      '/blog' => array( 'blog', 'files.blog', true )
      ),
   'nor' => array(
      '/' => array( 'heim', 'files.frontpage', true )
      )
   );

$menuFront = array(
   'eng' => array(
      '/interiordesign' => array( 'Interior Design', 'files.interiordesign', true ),
      '/paintandneedlework' => array( 'Paint and Needlework', 'files.paintandneedlework', true ),
      '/graphicdesign' => array( 'Graphic Design', 'files.graphicdesign', true ),
      '/bakedgoods' => array( 'Baked Goods', 'files.bakedgoods', true )
      ),
   'nor' => array(
      '/interiordesign' => array( 'Interiørdesign', 'files.interiordesign', true ),
      '/paintandneedlework' => array( 'Måling og sying', 'files.paintandneedlework', true ),
      '/graphicdesign' => array( 'Grafisk design', 'files.graphicdesign', true ),
      '/bakedgoods' => array( 'Bakarvarer', 'files.bakedgoods', true )
      )
   
   );

$menuProduct = array(
   'eng' => array(
      '/cbks001' => array( '', 'files.product_cbks001', true, true ),
      '/dwb001' => array( '', 'files.product_dwb001', true, true ),
      '/dwc001' => array( '', 'files.product_dwc001', true, true ),
      '/dwt001' => array( '', 'files.product_dwt001', true, true ),
      '/sp001' => array( '', 'files.product_sp001', true, true ),
      '/bcc001' => array( '', 'files.product_bcc001', true, true ),
      '/bgc001' => array( '', 'files.product_bgc001', true, true ),
      '/bkk001' => array( '', 'files.product_bkk001', true, true ),
      '/bkk002' => array( '', 'files.product_bkk002', true, true ),
      '/bph001' => array( '', 'files.product_bph001', true, true ),
      '/ds001' => array( '', 'files.product_ds001', true, true ),
      '/il001' => array( '', 'files.product_il001', true, true ),
      '/il002' => array( '', 'files.product_il002', true, true ),
      '/il003' => array( '', 'files.product_il003', true, true ),
      '/jl001' => array( '', 'files.product_jl001', true, true ),
      '/ms001' => array( '', 'files.product_ms001', true, true ),
      '/ms002' => array( '', 'files.product_ms002', true, true ),
      '/ms003' => array( '', 'files.product_ms003', true, true ),
      '/ms004' => array( '', 'files.product_ms004', true, true ),
      '/ms005' => array( '', 'files.product_ms005', true, true ),
      '/ms006' => array( '', 'files.product_ms006', true, true ),
      '/ms007' => array( '', 'files.product_ms007', true, true ),
      '/ms008' => array( '', 'files.product_ms008', true, true ),
      '/ms009' => array( '', 'files.product_ms009', true, true ),
      '/ms010' => array( '', 'files.product_ms010', true, true ),
      '/ms011' => array( '', 'files.product_ms011', true, true ),
      '/gdbs001' => array( '', 'files.product_gdbs001', true, true ),
      '/gdpa001' => array( '', 'files.product_gdpa001', true, true ),
      '/gdpa002' => array( '', 'files.product_gdpa002', true, true ),
      '/gdpa003' => array( '', 'files.product_gdpa003', true, true ),
      '/gdws001' => array( '', 'files.product_gdws001', true, true ),
      '/gdws002' => array( '', 'files.product_gdws002', true, true ),
      '/gdws003' => array( '', 'files.product_gdws003', true, true ),
      '/id001' => array( '', 'files.product_id001', true, true ),
      '/id002' => array( '', 'files.product_id002', true, true ),
      '/id003' => array( '', 'files.product_id003', true, true ),
      '/id004' => array( '', 'files.product_id004', true, true ),
      '/id005' => array( '', 'files.product_id005', true, true ),
      '/byc001' => array( '', 'files.product_byc001', true, true )
      )
   );

$languageStrings = array(
   '0001' => array(
      'nor' => 'Våre tilbod',
      'eng' => ''
      )
   );

?>
