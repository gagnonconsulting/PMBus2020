jQuery(document).ready( function() {
    jQuery('#categoryListBox a').click ( function () {
      //console.log ("categoryListBox a clicked");
      var term_id_clicked = jQuery(this).attr('id');
      var term_name_clicked = jQuery(this).attr('class');
      var parent_name_clicked = jQuery(this).parent().parent().attr('class');
    jQuery.post  ( {
          url: ajax.url,
          data : {
             action : 'show_products',
             term_id : term_id_clicked,
             listing_type : 'product'
         },
          success: function ( data ) {
            jQuery('#productBox').html("<h3>in <strong>"+parent_name_clicked+" / "+term_name_clicked+"</strong></h3></br>")
            jQuery('#productBox').append(data)
          },
          error: function (errorThrown) {
            console.log ("errorThrown"),
            console.log (errorThrown)
          }
        }
    );  // end jQuery.ajax
  }); // end jQuery click
});
jQuery(document).ready( function() {
    jQuery('#companyListBox a').click ( function () {
      //console.log ("companyListBox a clicked");
      var term_id_clicked = jQuery(this).attr('id');
      var term_name_clicked = jQuery(this).attr('class');
    jQuery.post  ( {
          url: ajax.url,
          data : {
             action : 'show_products',
             term_id : term_id_clicked,
             listing_type: 'company'
         },
          success: function ( data ) {
            jQuery('#productBox').html("<h3>by <strong>"+term_name_clicked+"</strong></h3></br>")
            jQuery('#productBox').append(data)
          },
          error: function (errorThrown) {
            console.log ("errorThrown"),
            console.log (errorThrown)
          }
        }
    );  // end jQuery.ajax
  }); // end jQuery click
});


//jQuery( document ).ajaxError(function( event, data, settings, exception ) {
//    alert( "Triggered ajaxError handler." +event+" "+data+" "+settings+" "+exception);
//});
