<?php
/**
* Plugin Name: Woo Questions
* Plugin URI: http://webgensis.com/
* Description: A Woocommerce Addon For Questions
* Version: 2.0
* Author: Webgensis
* Author URI: http://webgensis.com/
**/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}



define( 'Woo_Custom_Addon_VERSION', '1' );
define( 'Woo_Custom_Addon__MINIMUM_WP_VERSION', '3.2' );
define( 'Woo_Custom_Addon__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'Woo_Custom_Addon__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'Woo_Custom_Addon_DELETE_LIMIT', 100000 );






register_activation_hook(__FILE__, 'mypluginname_activation_logic');

function mypluginname_activation_logic() {
	
	
    //if dependent plugin is not active
    if (!is_plugin_active('woocommerce/woocommerce.php') )
    {

        deactivate_plugins(plugin_basename(__FILE__));
    }
	else
	{
		//Function calling for database table crateing 
	woo_addon_create_db_table();
	
	
	woopage_activate();
	
		
	}
	
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
   
	if ( in_array( 'woo-question/woo-question.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once( 'class-woo-custom.php' );
	
	
	
	
	
	
	
	//require_once( 'woo-question-process.php' );
	
	
	}
}else{
	//deactivate_plugins('/woocustom-addon/woocustom-addon.php', true);
	add_action( 'admin_init', 'deactivate_plugin_conditional' );
	add_action('admin_notices', '_my_plugin_php_warning'); 
	
	
	}
function deactivate_plugin_conditional() {
    
   deactivate_plugins('/woo-question/woo-question.php', true);
    
}


function _my_plugin_php_warning() {
    echo '<div id="message" class="updated notice">';
    echo '  <p>Activate Woocommerce First to use <strong>Woo Question Addon.</strong></p>';
    echo '</div>';
	echo '<style>.is-dismissible{display: none !important;}</style>';
	
}




/********************************************************/
/*               Wooquestions  pages             */
/********************************************************/


function woopage_activate() {

	
	//Auto create question page
	$options = get_option( 'woo_options' );
	
	
//****************************************************** Woo Questions page ****************************************
	

	if ( ! isset( $options['pages']['archive-question'] ) || ( isset( $options['pages']['archive-question'] ) && ! get_page( $options['pages']['archive-question'] ) ) ) {
		$args = array(
			'post_title' => __( 'Woo Questions', 'dwqa' ),
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_content'  => '[woo-list-questions]',
		);
		$question_page = get_page_by_path( sanitize_title( $args['post_title'] ) );
		if ( ! $question_page ) {
			$options['pages']['archive-question'] = wp_insert_post( $args );
		} else {
			// Page exists
			$options['pages']['archive-question'] = $question_page->ID;
		}
	}


//****************************************************** Woo Ask Question page ****************************************


	if ( ! isset( $options['pages']['submit-question'] ) || ( isset( $options['pages']['submit-question'] ) && ! get_page( $options['pages']['submit-question'] ) ) ) {

		$args = array(
			'post_title' => __( 'Woo Ask Question', 'dwqa' ),
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_content'  => '[woo_question_form]',
		);
		$ask_page = get_page_by_path( sanitize_title( $args['post_title'] ) );

		if ( ! $ask_page ) {
			$options['pages']['submit-question'] = wp_insert_post( $args );
		} else {
			// Page exists
			$options['pages']['submit-question'] = $ask_page->ID;
		}
	}





	// Valid page content to ensure shortcode was inserted
	$questions_page_content = get_post_field( 'post_content', $options['pages']['archive-question'] );
	if ( strpos( $questions_page_content, '[woo-list-questions]' ) === false ) {
		$questions_page_content = str_replace( '[woo_question_form]', '', $questions_page_content );
		wp_update_post( array(
			'ID'			=> $options['pages']['archive-question'],
			'post_content'	=> $questions_page_content . '[woo-list-questions]',
		) );
	}

	$submit_question_content = get_post_field( 'post_content', $options['pages']['submit-question'] );
	if ( strpos( $submit_question_content, '[woo_question_form]' ) === false ) {
		$submit_question_content = str_replace( '[woo-list-questions]', '', $submit_question_content );
		wp_update_post( array(
			'ID'			=> $options['pages']['submit-question'],
			'post_content'	=> $submit_question_content . '[woo_question_form]',
		) );
	}
	
	
	

	
	
	
// *******************************************  Defult Credit products/pacakges ****************************
	
	
	 include_once( 'credit_product.php');
	
	

	update_option( 'woo_options', $options );


}




/********************************************************/
/*             Wooquestions  Enqueue Content Scripts                */
/********************************************************/

		add_action('wp_enqueue_scripts', 'woo_question_enqueue_script');
		
		add_action( 'admin_enqueue_scripts', 'woo_question_admin_enqueue_script' );

	function woo_question_enqueue_script() {
		
		wp_enqueue_style('woo-custom-css',Woo_Custom_Addon__PLUGIN_URL."css/woo_custom.css");
		

		wp_enqueue_script('woo-custom-js', Woo_Custom_Addon__PLUGIN_URL . 'js/woo_custom.js', array('jquery'));

		
	}


	function woo_question_admin_enqueue_script() {
		
		wp_enqueue_style('date_pikker_css',Woo_Custom_Addon__PLUGIN_URL."css/date_piker.css");
		wp_enqueue_style('woo-admin-custom-css',Woo_Custom_Addon__PLUGIN_URL."css/woo_admin_custom.css");

		wp_enqueue_script('date_piker_js', Woo_Custom_Addon__PLUGIN_URL . 'js/date_piker.js', array('jquery'));
		wp_enqueue_script('admin_custom_js', Woo_Custom_Addon__PLUGIN_URL . 'js/woo_admin_custom.js', array('jquery'));

		
	}







/********************************************************/
/*           Wooquestions fornt end function          */
/********************************************************/

function woo_question_form() {
	
	global $wpdb;
	$current_user = wp_get_current_user();
	foreach ( $current_user->roles as $roles ) :
	$role = $roles;
	endforeach;
  	$login_id = $current_user->ID;
  
  
	if(isset($_POST['q_submit']))
	{
	
		 $woo_questions = mysql_real_escape_string(implode("#?#?#",$_POST['question']));
		
		$woo_question_array = explode("#?#?#",$woo_questions);
		
		$post_type  =  $_POST['post_type'];
		$credit_id  =  $_POST['credits_id'];
	    $credits_balance  =  $_POST['credits_balance'];
	    $question_balance  =  $_POST['q_balance'];
		
		$Q_count =0;
		
		foreach($woo_question_array as $woo_single_value)
		{
			
			$woo_single_question = $woo_single_value;
			
			$post = array(
		'post_title'	=> $woo_single_question,
		'post_author'   => $login_id,
		'post_status'	=> 'publish',	
		'post_type'	    => $post_type 
			);
			wp_insert_post($post); 
			
			$Q_count++;
			
		}
		
		$credit_info = $wpdb->get_row("select * from `wp_woocustom_creadit` where `id` = $credit_id  AND `user_id` = $login_id ");
		
	$used_points	= $credit_info->used_points;
	$final_use_point = $credit_info->total_used_point;
	$full_question_bal = $credit_info->total_question_bal;
		
		
		$point_charge = get_option('ques_point_charge');
		
		$q_charge = $Q_count*$point_charge;
		
		$use_points = $used_points.$q_charge.'+';
		
		
		$total_used_points = $final_use_point+$q_charge;
		
		 
		//$remaining_credit = $question_balance-$q_charge;
	   
	   
		
		
	$wpdb->query("UPDATE wp_woocustom_creadit SET used_points='$use_points', total_used_point='$total_used_points' WHERE id = $credit_id AND user_id=$login_id");
	
	
	 print("<script>window.location='".home_url()."/woo-ask-question?action=sucsess'</script>");
 
	
	}
	
	
}


add_action('init', 'woo_question_form');




function woo_question_field() {
 
	ob_start();
	global $wpdb;
	$current_user = wp_get_current_user();
	foreach ( $current_user->roles as $roles ) :
	$role = $roles;
	endforeach;
  	$login_id = $current_user->ID;
	
	
	
	
	  $expire_value =  get_option('to_date');  
	 
	  $expire_date =  strtotime($expire_value).'<br>'; 
	 
	 $from_date = strtotime(get_option('form_date'));
	
	 $cuurent_value = date('m/d/Y');
	
	 $cuurent_date = strtotime($cuurent_value); 
	
	
	
	
	
	
	$get_credit = $wpdb->get_row('select * from `wp_woocustom_creadit` where `user_id` = '.$login_id);


     $total_credits = $get_credit->credit_bal;
     $credits_id = $get_credit->id;
   $total_que_bal = $get_credit->total_question_bal;
	
	 $expire_val = $get_credit->expire_point;
	$used_val =  $get_credit->total_used_point;
	 
	 if($expire_val > $used_val)
	 {
	
	$total_question_bal = $total_que_bal-$expire_val;
	 }
	 else
	 {
		 $total_question_bal = $total_que_bal-$used_val;
		 
	 }
	

	

		 ?>
 <div class="woo_container">
 <div class="woo_main">
 
 <?php 
 // If Condition For Check Question Enable Or Disable
 
if (is_user_logged_in() ) {
 
	 if(get_option('ques_enable') == 'true')
 	 {
 
 
		 // IF Condtion For  check expire date 
		 if($from_date <= $cuurent_date && $expire_date >= $cuurent_date)
			{
		 
		 
		  // IF Condtion For check credit balance in Your Account 
		 
				  if($total_question_bal == '0' || $total_question_bal == '' || $total_question_bal == 'null') { 
				  
				  echo '<label>You Have Not Sufficient Credit Balance Please Click here <a href="'.home_url().'/credit-packages/" >BUY CREDIT</a> For Buy Credit Balance Thanks</label>';
				  
				  }
				  else
				  {
				   ?>
                   
				 <label class="frist-lable">Please select how many </label>
				 <label class="select-lable">
					 <select id="ppl">
					
					
					 <?php for($count = 1;$count <= $total_question_bal;$count++)
						   {
						  ?>
							<option value="<?php echo $count;  ?>"><?php echo $count;  ?></option>
						   
							<?php } ?>
						</select>
						</label>
				
						<?php }
						
						
			}
			else
			{
				
				echo '<label>Your Credit point have expired so you have not acces this service at a time Thanks</label>';	
					
			}
 }
 	 else
 	 {
     echo "<label>Sorry you can't acces this service This time  it's temporary disable Thanks</label>";
     }
}
else
{
  echo "<label>Sorry you can't acces this service without login please click here <a href='".home_url()."/wp-login.php/'>Login</a> for login Thanks</label>";	
}

   if($_REQUEST['action'] == 'sucsess')
    {
	 echo "<div class='question_sucess'><label>Your Question Have Been Successfully Submited. </label></div>";
	
	}
   



		
		 ?>

</div>
   
<div class="woo_main">
		<form id="questionform"  class="question_form" action="" method="post">
			<div id="question_holder"></div>
           <input type="hidden" name="post_type" value="woo-questions" />
           
           <input type="hidden" name="credits_id" value="<?php  echo $credits_id;  ?>" />
           <input type="hidden" name="credits_balance" value="<?php  echo $total_credits;  ?>" />
           <input type="hidden" name="q_balance" value="<?php  echo $total_question_bal;  ?>" />
            <input type="submit" value="Submit" name="q_submit" class="question_submit" style="display:none;" />
             
		</form>
        
        
        </div>
        </div>
	<?php
  

	return ob_get_clean();
}



add_shortcode( 'woo_question_form', 'woo_question_field' );



/********************************************************/
/*           Wooquestions Question List Sortcode         */
/********************************************************/


function woo_question_list()
{
	
	
	ob_start();
	global $wpdb;
	$current_user = wp_get_current_user();
	foreach ( $current_user->roles as $roles ) :
	$role = $roles;
	endforeach;
  	$login_id = $current_user->ID;
	
	
	echo '<div class="woo_container status-answered-container"><div class="question_list"><ul class="woo_question">';
	
 $paged = get_query_var('paged') ? get_query_var('paged') : 1;	
 query_posts(array('post_type' => 'woo-questions','author' => $login_id, 'posts_per_page' =>'20', 'paged' => $paged, 'order by ' => 'post date', 'order' => 'DESC')); 

             	if (have_posts()) : while (have_posts()) : the_post();
				
          $woo_answer = get_post_meta( get_the_id(),'questions_answer', true );
			  
			  
			  if(empty($woo_answer))
			  {
				  $ans_status= 'status-open';
				
				$status_text = 'Not Answered';
				$text_status = 'pending';
				 
			  }
			  else
			  {
				  $ans_status= 'status-answered';  
				$status_text = 'Answered';
				$text_status = 'done';
				
				
			  }
			  
			  
			  
			  
			  
 ?>
 
 
 
 <li>

 
 
 <header class="woo-header">
<a rel="bookmark" title="<?php the_title();  ?>" href="<?php  the_permalink();   ?>" class="woo-title"><?php  the_title();  ?></a>
 <div class="woo-meta">
 
 
 
 <span class="woo_status <?php  echo $ans_status;  ?>" ></span>
 <span class="woo_author"><?php echo get_the_author(); ?></span> 
 
 
  <span class="status_answer <?php  echo $text_status;   ?>"><?php echo $status_text; ?></span>
 
 
  </div></header>
 
 
 </li>
 
 
 
	
<?php	
	endwhile; endif;  wp_reset_query();
	
	echo   '</ul></div></div>';
	
	
}

add_shortcode( 'woo-list-questions', 'woo_question_list' );




add_filter( 'single_template', 'change_post_type_template' );

function change_post_type_template($single_template) 
{
     global $post;

     if ($post->post_type == 'woo-questions') 
     {
          $single_template = Woo_Custom_Addon__PLUGIN_DIR . 'Template/single-woo-questions.php';
     }

     return $single_template;
}



/********************************************************/
/*           Wooquestions Credit point process          */
/********************************************************/




add_action( 'woocommerce_order_status_completed', 'check_quantity' );
function check_quantity($order_id) {


global $wpdb;

$order = new WC_Order( $order_id );

  $user_id = $order->user_id;
   $transaction_id =  $order->id;


    $item = $order->get_items();

  


 



if ( count( $order->get_items() ) > 0 ) {
  foreach( $order->get_items() as $item ) {
	  
	 // echo '<pre>';
	 // print_r($item);die;
	  
	  

   $product_id = $item['product_id'];

	  $creditcat_info = $wpdb->get_row("SELECT * FROM `wp_term_relationships` WHERE `object_id` = '$product_id'"); 
	    $termid = $creditcat_info->term_taxonomy_id;
	  
	  $cat_info = $wpdb->get_row("SELECT * FROM `wp_terms` WHERE `term_id` = '$termid'"); 
	  
	  $credit_catname =  $cat_info->name;
	  
	



if($credit_catname == 'wdm_credit_product')
{

$quantity = $item['qty'];

  $exist_point = get_post_meta( $product_id, 'wdm_credit_point', true);
  
  
  $credit_point = $exist_point*$quantity;
  
  
    $question_charge = get_option('ques_point_charge');
	
	if($question_charge == '' || $question_charge == 'null' || $question_charge == '0')
	{
		$point_charge = '1';
	}
	else
	{
	$point_charge = $question_charge;	
	}
	
	
	
	$expire_time = get_post_meta( $product_id, 'wdm_credit_expire', true);	
			$duration = get_post_meta( $product_id, 'wdm_credit_duration', true);		
		
		  if(empty($duration) || $duration == '') {  $expire_duration = 'Years'; }
		  else {  $expire_duration = $duration;  }
	
	
	$current_date = date('d-m-Y');
	
	$expire_date = date('d-m-Y', strtotime('+'.$expire_time.' '.$expire_duration.''));
	
     $question_bal = ($credit_point/$point_charge);



$get_entry = $wpdb->get_results("select * from `wp_woocustom` where `user_id` = '$user_id' AND `order_id` = '$transaction_id'");


$num_rows = count($get_entry);

if($num_rows == '0')
{

 $args = array(
		'user_id' => $user_id,
		'order_id' => $transaction_id,
		'credit_bal' => $credit_point,
		'total_question_bal' => $question_bal,
		'start_date' => $current_date,
		'expir_date' => $expire_date
		);
		
  $wpdb->insert('wp_woocustom',$args);
  $jobid = $wpdb->insert_id;

}
  
   $total_credit = $wpdb->get_results('select * from `wp_woocustom_creadit` where `user_id` = '.$user_id);
   
   $cnt = 0;
   foreach ( $total_credit as $credit_value ){
	   $total = $credit_value->credit_bal;
	   
	    $q_bal = $credit_value->total_question_bal;
	   $s_date = $credit_value->start_date;
	   $e_date = $credit_value->expire_date;
	   
	    $c_points = $credit_value->credit_points;
	  
	    $bal_series = $credit_value->q_bal_series;
	   
	   $order_ids = $credit_value->order_ids;
   $cnt++;
   }
   
    $question_total = $q_bal+$question_bal;
	
  $credit_total = $total+$credit_point;
$date = date('Y-m-d');

   
  
if ($cnt > 0){
	
	 $order_arr = array();
               

 $get_ids  =  explode(",",$order_ids);
 
 foreach($get_ids as $get_id)
 {
	
	 $order_arr[] = $get_id;
	
 }


if (in_array($transaction_id, $order_arr))
  {
 
  }
else
  {
  $orders_ids = $order_ids.$transaction_id.',';
  	
	
	$new_sdate =   $s_date.$current_date.',';
	$new_edate =   $e_date.$expire_date.',';
	
	 $credit_points = $c_points.$credit_point.'+';
	 
	  $q_bal_series = $bal_series.$question_bal.'+';
	 
	  
	
	

 $wpdb->query("UPDATE wp_woocustom_creadit SET order_ids = '$orders_ids', credit_points = '$credit_points' , credit_bal='$credit_total', q_bal_series = '$q_bal_series' , total_question_bal = '$question_total', start_date = '$new_sdate', expire_date = '$new_edate'  WHERE user_id=$user_id");
 
  
  }

 }
 
 else{
	$transaction_ids = $transaction_id.',';
	 
	 $start_dates = $current_date.',';
	 $expire_dates = $expire_date.',';
	  $credit_points = $credit_point.'+';
       $q_bal_series = $question_bal.'+';	 
	 
	 $args_2 = array(
		'user_id' => $user_id,
		'order_ids' => $transaction_ids,
		'credit_points' => $credit_points,
		'credit_bal' => $credit_point,
		'q_bal_series' => $q_bal_series,
		'total_question_bal' => $question_bal,
		'start_date' => $start_dates,
		'expire_date' => $expire_dates,
		
		);
		
  $wpdb->insert('wp_woocustom_creadit',$args_2);
	 
	 }




}
 
	 

      } 
    }

}








/********************************************************/
/*           Wooquestions database table create          */
/********************************************************/



function woo_response_question_function( $post_id ) {
	
	
	global $post;
	if ($post->post_type == 'woo-questions') {

	// If this is just a revision, don't send the email.
	if ( wp_is_post_revision( $post_id ) )
		return;

	 $post_title = get_the_title( $post_id );
	$post_url = get_permalink( $post_id );
	
	$my_post = get_post( $post_id ); 
	 $auther_id = $my_post->post_author;
	
	
	 $user_info = get_userdata($auther_id);
  $user_email = $user_info->user_email;
  
	  $username = $user_info->user_login;
	$admin_email = get_option( 'admin_email' ); 
	  	$woo_answer = get_post_meta( $post_id,'questions_answer', true );            
	         
$site_title = get_bloginfo('name');
			 
	$subject = 'Answerd Your Questions';
	
	
   $headers = "From : ". $site_title. " <.$admin_email.>" . "\r\n";

	$message = "Your Question : ". $post_title ."\n\n";
	$message .= "Your Questions Url : ". $post_url ."\n\n";
	$message .=  "Our Answer : ". $woo_answer;

	
	wp_mail( $user_email, $subject,$message);
	
	
	}
	
	
}
add_action( 'save_post', 'woo_response_question_function' );






/********************************************************/
/*           Wooquestions database table create          */
/********************************************************/

function woo_addon_create_db_table() {

	// Get WPDB Object
	global $wpdb;

	// Table name
	$table_name = $wpdb->prefix . "woocustom";
	$table_name2 = $wpdb->prefix . "woocustom_creadit";
	$table_name3 = $wpdb->prefix . "woocustom_question";

	// Building the query
	$sql = "CREATE TABLE $table_name (
			  id int(10) NOT NULL AUTO_INCREMENT,
			  user_id varchar(255) NOT NULL,
			  order_id varchar(255) NOT NULL,
			  credit_bal varchar(255) NOT NULL,
			  total_question_bal varchar(255) NOT NULL,
			  expired varchar(255) NOT NULL,
			  start_date varchar(255) NOT NULL,
			  expir_date varchar(255) NOT NULL,
			  PRIMARY KEY  (id)
			);";
			
			
	$sql2 = "CREATE TABLE $table_name2 (
			  id int(10) NOT NULL AUTO_INCREMENT,
			  user_id varchar(255) NOT NULL,
			  order_ids longtext NOT NULL,
			  credit_points text NOT NULL,
			  credit_bal varchar(255) NOT NULL,
			  q_bal_series text NOT NULL,
			  total_question_bal varchar(255) NOT NULL,
			  used_points text NOT NULL,
			  total_used_point text NOT NULL,
			  expire_point text NOT NULL,
			  start_date text NOT NULL,
			  expire_date text NOT NULL,
			  PRIMARY KEY  (id)
			);";	
			
			
	$sql3 = "CREATE TABLE $table_name3 (
			  id int(10) NOT NULL AUTO_INCREMENT,
			  user_id varchar(255) NOT NULL,
			  transaction_id varchar(255) NOT NULL,
			  question longtext NOT NULL NOT NULL,
			  answer longtext NOT NULL,
			  PRIMARY KEY  (id)
			);";			
			
			

	// Executing the query
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	// Execute the query
	dbDelta($sql);
	dbDelta($sql2);
	dbDelta($sql3);
}
