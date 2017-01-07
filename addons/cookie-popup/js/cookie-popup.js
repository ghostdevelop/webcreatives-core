(function ( $ ) {
  
    'use strict';
  
    if ( 'set' !== $.cookie( 'cookie-pop' ) ) {
		$('<div class="cookie-popup"><p>' + cookie_pop_text.message + '</p><a id="accept-cookies">' + cookie_pop_text.acceptLabel + '</a><a href="' + cookie_pop_text.moreUrl + '" id="cookies-more-info">' + cookie_pop_text.moreLabel + '</a></div>').appendTo('body').delay(4000).fadeOut();
        $( '#accept-cookies' ).live('click', function () {
            $.cookie( 'cookie-pop', 'set', { expires : 10 });
            $( '.cookie-popup' ).remove();
  
        });
  
    }
  
}( jQuery ) );