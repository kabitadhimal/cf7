/*
 * Scroll to wpcf7-response-output in the top after the form is submitted
 */
  jQuery(function ($) {
    $(document).ready(function ()
    {
      var wpcf7Elm = document.querySelector( '.wpcf7' );
      wpcf7Elm.addEventListener( 'wpcf7submit', function( event ) {
        setTimeout(function() {
          $([document.documentElement, document.body]).animate({
            scrollTop: $(".wpcf7-response-output").offset().top - 200
          }, 500);
        }, 500);
       // console.log("Submited");
      }, false );
    });
  });