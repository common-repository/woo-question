jQuery(function() {
    jQuery( "#datepicker" ).datepicker();
  });
  
  jQuery(function() {
    jQuery( "#datepicker_2" ).datepicker();
  });
  
  
  jQuery( document ).ready(function() {
	  
	  
	  
	  
	  

	
	jQuery('.wp-admin #woocommerce-product-data #product-type').on('change', function() {
		
		            var product_type  =  this.value;
		
		 if ( product_type == 'wdm_credit_product' ) {
	 		 
	
	  //jQuery( '.panel woocommerce_options_panel .pricing' ).show();
	jQuery("#woocommerce-product-data #general_product_data .pricing").addClass("credit_price");
	
	
        jQuery( '.credit_option' ).show();
		
		
		
		
		
		
		} else {
		
		
		jQuery('.wdm_credit_point_field #wdm_credit_point').val('');
		jQuery('.wdm_credit_expire_field #wdm_credit_expire').val('');
		
	jQuery("#woocommerce-product-data #general_product_data .pricing").removeClass("credit_price");
        jQuery( '.credit_option' ).hide();
		
		
		}
		
		
	
});
	
	
	});
