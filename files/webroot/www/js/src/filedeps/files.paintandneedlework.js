$(document).ready( function() {
  
   $( '.pictureslider' ).slick({
      infinite: true,
      arrows: true,
      slidesToShow: 3,
      slidesToScroll: 2
   });
  
   $( '.pictureslider a' ).featherlight( {
      type: 'ajax',
      targetAttr: 'href',
      beforeOpen: function() {
         
         ga( 'send', 'pageview', { 'page': $(this).attr( 'href' ) } );
         
      },
      afterOpen: function() {
         
         $(' .product-item .image img').magnify();
      }
   });

   $( 'body' ).on( 'click', '.product-item .thumbs img', function() {

      ref = $(this).attr( 'ref' );
      img = $(this).parent().parent().parent().find( '.image img' );
      img.attr( 'src', '' );
      
      newref = ref.split( '_' );
      
      $.ajax( '/product/getproductimageurl/' + newref[ 0 ] + '/' + newref[ 1 ] ).done( function( html ) {
         
         cont = img.parent();
         $( 'div.magnify', cont ).remove();
         if ( typeof img !== 'undefined' ) {
            
            img.remove();
            
         }

         cont.append( html );
         $( 'img', cont ).magnify();
         
      });
      
   });
   
   $( 'body' ).on( 'click', '.product-item .navigate a', function( ev ) {

      el = $(this);
      newref = el.attr( 'href' );

      if ( typeof newref !== 'undefined' && newref.length ) {

         $.ajax( newref, {
            success: function() {
               
               ga( 'send', 'pageview', { 'page': newref } );
               
            }
         }).done( function( html ) {
            boxtop = el.parent().parent().parent();
            boxtop.children( 'div.product-item' ).remove();
            boxtop.append( html );
            boxtop.find(' .image img').magnify();
         });
      
      }
      
      ev.preventDefault();
      
   });
   
   $( 'body' ).on( 'click', '.product-item .switchimage a', function( ev ) {

      
      
      ev.preventDefault();
      
   });
   
   $( 'body' ).on( 'live', '.product-item .image img', function() {
   
      $(' .product-item .image img').magnify();
      
   });
  
});
