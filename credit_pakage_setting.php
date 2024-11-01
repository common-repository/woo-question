<?php


add_filter( 'product_type_selector', 'wdm_add_custom_product_type' );
function wdm_add_custom_product_type( $types ){
    $types[ 'wdm_credit_product' ] = __( 'Credit Package Product' );
    return $types;
}

add_action( 'plugins_loaded', 'wdm_create_custom_product_type' );
function wdm_create_custom_product_type(){
     // declare the product class
     class WC_Product_Wdm extends WC_Product{
        public function __construct( $product ) {
           $this->product_type = 'wdm_credit_product';
           parent::__construct( $product );
           // add additional functions here
        }
    }
}




add_action( 'woocommerce_product_options_general_product_data', 'wdm_add_custom_settings' );
function wdm_add_custom_settings() {
    global $woocommerce, $post;
    echo '<div class="options_group credit_option" style="display:none;">';

    // Create a number field, for example for UPC
  /*  woocommerce_wp_text_input(
      array(
       'id'                => 'wdm_upc_field',
       'label'             => __( 'UPC', 'woocommerce' ),
       'placeholder'       => '',
       'desc_tip'    => 'true',
       'description'       => __( 'Enter Unique Product Code.', 'woocommerce' ),
       'type'              => 'number'
       ));*/
	   
	   
	    woocommerce_wp_text_input(
      array(
       'id'                => 'wdm_credit_point',
       'label'             => __( 'Credit Point', 'woocommerce' ),
       'placeholder'       => '',
       'desc_tip'    => 'true',
       'description'       => __( 'Enter Credit point.', 'woocommerce' ),
       'type'              => 'text'
       ));
	   
	   
	   
	     woocommerce_wp_text_input(
      array(
       'id'                => 'wdm_credit_expire',
       'label'             => __( 'Credit Point Expire Duration', 'woocommerce' ),
       'placeholder'       => '',
       'desc_tip'    => 'true',
       'description'       => __( 'Enter Expire Duration Only In Month Or Year ex. 1,2,3,6.. By Defult is set 1 Year.', 'woocommerce' ),
       'type'              => 'text'
       ));
	   
	   
	   
	   woocommerce_wp_select(
	    array( 'id' => 'wdm_credit_duration',
		 'label' => __('Select Package Duration : ', 'woocommerce'),
		 'desc_tip'    => 'true',
		 'description'       => __( 'please selct expire duration defination By Defult is take Year.', 'woocommerce' ),
		  'options' => array(
		    '' => __('Select Duration', 'woocommerce'),
            'Days' => __('Days', 'woocommerce'),
            'Months' => __('Months', 'woocommerce'),
			'Years' => __('Years', 'woocommerce')
            ) ) );
	   
	 // Create a checkbox for product purchase status
     /* woocommerce_wp_checkbox(
       array(
       'id'            => 'wdm_credit_duration',
       'label'         => __('Is Purchasable', 'woocommerce' )
       ));*/
	  

    echo '</div>';
}


add_action( 'woocommerce_process_product_meta', 'wdm_save_custom_settings' );
function wdm_save_custom_settings( $post_id ){
// save UPC field
$wdm_credit_point = $_POST['wdm_credit_point'];
if( !empty( $wdm_credit_point ) )
update_post_meta( $post_id, 'wdm_credit_point', esc_attr( $wdm_credit_point) );

$wdm_credit_expire = $_POST['wdm_credit_expire'];
if( !empty( $wdm_credit_point ) )
update_post_meta( $post_id, 'wdm_credit_expire', esc_attr( $wdm_credit_expire) );


$wdm_credit_duration = $_POST['wdm_credit_duration'];
if( !empty( $wdm_credit_duration ) )
update_post_meta( $post_id, 'wdm_credit_duration', esc_attr( $wdm_credit_duration) );




// save purchasable option
/*$wdm_purchasable = isset( $_POST['wdm_is_purchasable'] ) ? 'yes' : 'no';
update_post_meta( $post_id, 'wdm_is_purchasable', $wdm_purchasable );*/




}





function credit_product_list()
{
	
	
	ob_start();
	global $wpdb;
	$current_user = wp_get_current_user();
	foreach ( $current_user->roles as $roles ) :
	$role = $roles;
	endforeach;
  	$login_id = $current_user->ID;
	
	

	
			$args = array(
		'post_type' => 'product',
		'tax_query' => array(
			array(
			'taxonomy' => 'product_type',
			'field' => 'name',
			'terms' => 'wdm_credit_product'
			 )
		  )
		);
     $loop = new WP_Query( $args );
	

    while ( $loop->have_posts() ) : $loop->the_post(); 
    global $product; 

               $product_id  =  get_the_ID();
    	$credit_image =  wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '' ); 

                $credit_image = $credit_image[0]; 
			
			$credit_point = get_post_meta( get_the_ID(), 'wdm_credit_point', true);
			$expire_time = get_post_meta( get_the_ID(), 'wdm_credit_expire', true);	
			$duration = get_post_meta( get_the_ID(), 'wdm_credit_duration', true);		
		
		  if(empty($duration) || $duration == '') {  $expire_duration = 'Years'; }
		  else {  $expire_duration = $duration;  }
		
		$current_date = date('d-M-Y');
         
		 $expire_date = date('d-M-Y', strtotime('+'.$expire_time.' '.$expire_duration.''));


		echo '<ul class="products creditpackage">

<li class="first post-'.$product_id.' product type-product status-publish has-post-thumbnail sale shipping-taxable purchasable product-type-simple">

     <a href="'.get_permalink().'">
     <img width="300" height="300"  class="attachment-shop_catalog wp-post-image" src="'.$credit_image.'"><h3>'.get_the_title().'</h3></a>';

// **************************** Product Price ***********************


 if ( $price_html = $product->get_price_html() ) : ?>


 
 
	<span class="price"><?php echo $price_html; ?> <samp></samp></span>
<?php endif; 





// **************************** Credit Details ***********************

echo '<span class="credit_detail">Credit Points Get: '.$credit_point.'</span><hr>

     <span class="credit_detail">Expire Duration: '.$expire_time.'&nbsp;'.$expire_duration.'</span><hr>
	 <span class="credit_detail">This Package Valid From:-</span>
	 <span class="credit_detail expire_time">(&nbsp;'.$current_date.'&nbsp;&nbsp;To&nbsp;&nbsp;'.$expire_date.'&nbsp;)</span>';

  



// **************************** add to cart button ***********************
echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( $product->id ),
		esc_attr( $product->get_sku() ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
		esc_attr( $product->product_type ),
		esc_html( $product->add_to_cart_text() )
	),
$product );


  	echo	'</li>
		</ul>';




    endwhile;  wp_reset_query(); 
	
	
}

add_shortcode( 'credit_package_list', 'credit_product_list' );





// **************************** Hide Credit Products From Shop Page ***********************

add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

function custom_pre_get_posts_query( $q ) {

	if ( ! $q->is_main_query() ) return;
	if ( ! $q->is_post_type_archive() ) return;

	if ( ! is_admin() && is_shop() ) {

		$q->set( 'tax_query', array(array(
			'taxonomy' => 'product_type',
			'field' => 'slug',
			'terms' => array( 'wdm_credit_product' ), 
			'operator' => 'NOT IN'
		)));

	}

	remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

}




function credit_expire() {
	global $wpdb;
$expire_info = $wpdb->get_results("select * from `wp_woocustom` where `expired` = 'null' OR `expired` = ''");
 
	 $date = date('d-m-Y');
	
	 $current_date = strtotime($date).'<br>';
	//echo $current = strtotime("24-12-2016").'<br>';
	
//echo '<pre>';
 //print_r($expire_info);	
 
 foreach($expire_info as $expire_data)
 {
	 
	 $user_id = $expire_data->user_id;
	 $order_id = $expire_data->order_id;
	 $credit_bal = $expire_data->credit_bal;
	$package_q_bal = $expire_data->total_question_bal;
	 $start_date = $expire_data->start_date;
	 $expir_date = $expire_data->expir_date;
	 
 	 $expired =  strtotime($expir_date);
	
	
	
	
	if($current_date > $expired)
	{
	 $wpdb->query("UPDATE wp_woocustom SET expired = 'Yes' WHERE user_id=$user_id AND order_id ='$order_id' ");
		
			$get_history = $wpdb->get_row("select * from `wp_woocustom_creadit` where `user_id` = '$user_id'");
	
	   $current_q_bal = $get_history->total_question_bal;
	
	    $current_used_bal = $get_history->total_used_point;
	
	   $current_expire_point = $get_history->expire_point;
	   
	   
	   
	   
			$new_q_bal = $current_q_bal-$reduse_bal;
			
			
			$reduse_bal = $package_q_bal+$current_expire_point;
			
			
			$wpdb->query("UPDATE wp_woocustom_creadit SET expire_point = '$reduse_bal' WHERE user_id=$user_id  ");
		
	
	
		
	}
	 
 }
 
	
}

credit_expire();



?>