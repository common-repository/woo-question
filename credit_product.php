<?php


//****************************************************** Credit Package page ****************************************

if ( ! isset( $options['pages']['credit-package'] ) || ( isset( $options['pages']['credit-package'] ) && ! get_page( $options['pages']['credit-package'] ) ) ) {





	global $wpdb;
	
	$cat_args = array(
			'name' => 'wdm_credit_product',
			'slug' => 'wdm_credit_product',
			'term_group' => '0',
			);
	$wpdb->insert('wp_terms',$cat_args);
	$termid = $wpdb->insert_id;
	
	$ter_taxonomy = array(
			'term_id' => $termid,
			'taxonomy' => 'product_type',
			'description' => '',
			'parent' => '0',
			'count' => '4',
			);
	
	$wpdb->insert('wp_term_taxonomy',$ter_taxonomy);
	
	
	$term_taxonomyid = $wpdb->insert_id;





		$args = array(
			'post_title' => __( 'Credit Packages', 'dwqa' ),
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_content'  => '[credit_package_list]',
		);
		$credit_package_page = get_page_by_path( sanitize_title( $args['post_title'] ) );

		if ( ! $credit_package_page ) {
			$options['pages']['credit-package'] = wp_insert_post( $args );
		} else {
			// Page exists
			$options['pages']['credit-package'] = $credit_package_page->ID;
		}
	}





// *****************************  Silver Product/ Pacakge *****************************************************

if ( ! isset( $options['product']['silver-product'] ) || ( isset( $options['product']['silver-product'] ) && ! get_page( $options['product']['silver-product'] ) ) ) {
	
	global $wpdb;
	

		$args = array(
			'post_title' => __( 'Silver Package', 'dwqa' ),
			'post_type' => 'product',
			'post_status' => 'publish',
			'post_content'  => '',
		);
		$credit_product = get_page_by_path( sanitize_title( $args['post_title'] ) );
		
		

		if ( ! $credit_product ) {
			$options['product']['silver-product'] = wp_insert_post( $args );
			
			$product_id = $wpdb->insert_id;
			
			
			$term_args = array(
			'object_id' => $product_id,
			'term_taxonomy_id' => $term_taxonomyid,
			'term_order' => '0',
			);
			
			$wpdb->insert('wp_term_relationships',$term_args);
			
		
			update_post_meta( $product_id, '_edit_last', esc_attr('1') );
			update_post_meta( $product_id, '_visibility', esc_attr('visible') );
			update_post_meta( $product_id, '_stock_status', esc_attr('instock') );
			update_post_meta( $product_id, 'total_sales', esc_attr('0') );
			update_post_meta( $product_id, '_downloadable', esc_attr('no') );
			update_post_meta( $product_id, '_virtual', esc_attr('no') );
			update_post_meta( $product_id, '_regular_price', esc_attr('75') );
			update_post_meta( $product_id, '_sale_price', esc_attr('50') );
			update_post_meta( $product_id, '_featured', esc_attr('no') );
			update_post_meta( $product_id, '_price', esc_attr('50') );
			update_post_meta( $product_id, '_sold_individually', esc_attr('') );
			update_post_meta( $product_id, '_manage_stock', esc_attr('no') );
			update_post_meta( $product_id, '_backorders', esc_attr('no') );
			
		  update_post_meta( $product_id, 'wdm_credit_point', esc_attr('50') );	
		   update_post_meta( $product_id, 'wdm_credit_expire', esc_attr('1') );
		   update_post_meta( $product_id, 'wdm_credit_duration', esc_attr('Years') );	
			
		} else {
		
			$options['product']['silver-product'] = $credit_product->ID;
		}
	}





// *****************************  Gold Product/ Pacakge *****************************************************

if ( ! isset( $options['product']['gold-product'] ) || ( isset( $options['product']['gold-product'] ) && ! get_page( $options['product']['gold-product'] ) ) ) {
	
	global $wpdb;
	

		$args = array(
			'post_title' => __( 'Gold Package', 'dwqa' ),
			'post_type' => 'product',
			'post_status' => 'publish',
			'post_content'  => '',
		);
		$credit_product = get_page_by_path( sanitize_title( $args['post_title'] ) );
		
		

		if ( ! $credit_product ) {
			$options['product']['gold-product'] = wp_insert_post( $args );
			
			$product_id = $wpdb->insert_id;
			
			
			$term_args = array(
			'object_id' => $product_id,
			'term_taxonomy_id' => $term_taxonomyid,
			'term_order' => '0',
			);
			
			$wpdb->insert('wp_term_relationships',$term_args);
			
			// meta values **************************
			update_post_meta( $product_id, '_edit_last', esc_attr('1') );
			update_post_meta( $product_id, '_visibility', esc_attr('visible') );
			update_post_meta( $product_id, '_stock_status', esc_attr('instock') );
			update_post_meta( $product_id, 'total_sales', esc_attr('0') );
			update_post_meta( $product_id, '_downloadable', esc_attr('no') );
			update_post_meta( $product_id, '_virtual', esc_attr('no') );
			update_post_meta( $product_id, '_regular_price', esc_attr('125') );
			update_post_meta( $product_id, '_sale_price', esc_attr('100') );
			update_post_meta( $product_id, '_featured', esc_attr('no') );
			update_post_meta( $product_id, '_price', esc_attr('100') );
			update_post_meta( $product_id, '_sold_individually', esc_attr('') );
			update_post_meta( $product_id, '_manage_stock', esc_attr('no') );
			update_post_meta( $product_id, '_backorders', esc_attr('no') );
			
		  update_post_meta( $product_id, 'wdm_credit_point', esc_attr('100') );	
		   update_post_meta( $product_id, 'wdm_credit_expire', esc_attr('1') );
		   update_post_meta( $product_id, 'wdm_credit_duration', esc_attr('Years') );	
			
		} else {
			// Page exists
			$options['product']['gold-product'] = $credit_product->ID;
		}
	}




// *****************************  platinum Product/ Pacakge *****************************************************

if ( ! isset( $options['product']['platinum-product'] ) || ( isset( $options['product']['platinum-product'] ) && ! get_page( $options['product']['platinum-product'] ) ) ) {
	
	global $wpdb;
	

		$args = array(
			'post_title' => __( 'Platinum Package', 'dwqa' ),
			'post_type' => 'product',
			'post_status' => 'publish',
			'post_content'  => '',
		);
		$credit_product = get_page_by_path( sanitize_title( $args['post_title'] ) );
		
		

		if ( ! $credit_product ) {
			$options['product']['platinum-product'] = wp_insert_post( $args );
			
			$product_id = $wpdb->insert_id;
			
			
			$term_args = array(
			'object_id' => $product_id,
			'term_taxonomy_id' => $term_taxonomyid,
			'term_order' => '0',
			);
			
			$wpdb->insert('wp_term_relationships',$term_args);
			
			// meta values **************************
			update_post_meta( $product_id, '_edit_last', esc_attr('1') );
			update_post_meta( $product_id, '_visibility', esc_attr('visible') );
			update_post_meta( $product_id, '_stock_status', esc_attr('instock') );
			update_post_meta( $product_id, 'total_sales', esc_attr('0') );
			update_post_meta( $product_id, '_downloadable', esc_attr('no') );
			update_post_meta( $product_id, '_virtual', esc_attr('no') );
			update_post_meta( $product_id, '_regular_price', esc_attr('225') );
			update_post_meta( $product_id, '_sale_price', esc_attr('200') );
			update_post_meta( $product_id, '_featured', esc_attr('no') );
			update_post_meta( $product_id, '_price', esc_attr('200') );
			update_post_meta( $product_id, '_sold_individually', esc_attr('') );
			update_post_meta( $product_id, '_manage_stock', esc_attr('no') );
			update_post_meta( $product_id, '_backorders', esc_attr('no') );
			
		  update_post_meta( $product_id, 'wdm_credit_point', esc_attr('200') );	
		   update_post_meta( $product_id, 'wdm_credit_expire', esc_attr('1') );
		   update_post_meta( $product_id, 'wdm_credit_duration', esc_attr('Years') );	
			
		} else {
			// Page exists
			$options['product']['platinum-product'] = $credit_product->ID;
		}
	}






?>