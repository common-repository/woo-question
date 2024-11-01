<?php


 include_once( 'credit_pakage_setting.php');


add_action('admin_menu', 'woo_appearance_menu');




add_action('init', 'questions_register');
function questions_register() {
    $args = array(
        'label' => __('Questions'),
        'singular_label' => __('Question'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => true,
		'show_in_menu' => 'edit.php?post_type=woo-questions',
        'supports' => array('title','author','revisions')
       );  

    register_post_type( 'woo-questions' , $args );
}







function woo_appearance_menu(){
    add_menu_page('Woo Questions Setting', 'Woo Questions Setting', 'manage_options', 'woo-questions-setting', 'woo_setting_options'); 
	
	
add_submenu_page( 'woo-questions-setting', 'Questions', 'Questions', 'manage_options','edit.php?post_type=woo-questions' );
	
	
// add_submenu_page('woo-custom-addon-setting', 'Genre', 'Genre', 'manage_options', 'edit.php?post_type=tutorials'); 	
	
	
//add_submenu_page( 'woo-custom-addon-setting', 'Answer', 'Answer', 'manage_options', 'woo-answer','my_plugin_options' );	
	
	
}





function woo_setting_options(){
	 include_once( 'functions/woo-questions-setting.php'  );
	 
	 
	
	 
	
	}
	


add_action( 'add_meta_boxes', 'woo_questions_meta' );
        function woo_questions_meta() {
                add_meta_box( 'woo-questions', 'Answer', 'woo_questions_url_meta', 'woo-questions', 'advanced', 'high' );
                }

            function woo_questions_url_meta( $post ) {
                $questions_answer = get_post_meta( $post->ID, 'questions_answer', true);
				
               
                ?>
     <label style="width:100%">please Enter Your Answer Here</label>
     <textarea  style="width:100%;margin:7px 0 0 7px;height:200px;" name="questions_answer" ><?php echo $questions_answer; ?></textarea> <br />
 
                
       <?php         
        }

add_action( 'save_post', 'woo_questions_save_meta' );
        function woo_questions_save_meta( $post_ID ) {
            global $post;
            if( $post->post_type == "woo-questions" ) {
			
			$_POST['questions_answer'];
			
				
            if (isset( $_POST ) ) {
                update_post_meta( $post_ID, 'questions_answer', $_POST['questions_answer'] );
				
            }
        }
        }
		
















/*
add_action('init', 'tutorials_register1');
function tutorials_register1() {
	
	$args = array(
        'label' => __('Movies'),
        'singular_label' => __('Movie'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => true,
		'show_in_menu' => 'edit.php?post_type=entertainment',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'comments', 'revisions')
       );  
	
	register_post_type( 'movies' , $args );

}

add_action('admin_menu', 'my_admin_menu'); 
function my_admin_menu() { 
    add_submenu_page('edit.php?post_type=entertainment', 'Genre', 'Genre', 'manage_options', 'edit.php?post_type=entertainment'); 
}
*/



	