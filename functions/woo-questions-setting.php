<?php
		 $woo_options = array();

		

			if (isset($_POST['woo_custom_save'])) {
				
			
				$form_date = $_POST['form_date'];
				$to_date = $_POST['to_date'];
				
				
				$ques_point_charge = $_POST['ques_point_charge'];
				
				
				if(isset($_POST['ques_enable']) && $_POST['ques_enable'] === 'on')
				{
					$ques_enable = 'true';
				}
				else
				{
				$ques_enable = 'false';	
				}
				
				
		
                    update_option( 'ques_enable', $ques_enable );
					update_option( 'form_date', $form_date );
					update_option( 'to_date', $to_date );
					update_option( 'ques_point_charge', $ques_point_charge );


				echo '<div class="updated"><p>' . __('Success! Your changes were successfully saved!', 'woo-question') . '</p></div>';
			}
?>

<div class='wrap'>
<div class='icon32' id='icon-options-general'><br/></div>
<h2>Woo Question <span style='font-size:60%;'></span></h2>
<form method='post' id='simplemodal_login_options'>

	<table class='form-table'>
		<tr valign="top">
			<th scope="row"><?php _e('Enable Questions:', 'woo-question'); ?></th>
			<td><label for="reset">
				<input type="checkbox" id="ques_enable" name="ques_enable" <?php echo (get_option('ques_enable') == 'true') ? "checked='checked'" : ""; ?> /> <?php _e('Enable', 'woo-question'); ?></label><br/>
				<span class='description'><?php _e('Select this option to enable the question reset feature in Woo Question.', 'woo-question'); ?></span>
				</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Credit Point Valid:', 'woo-question'); ?></th>
			<td><label for="registration"><?php _e('From', 'woo-question'); ?></label>
				<input type="text" id="datepicker" name="form_date" value="<?php  echo get_option('form_date');  ?>" /> <br/>
				<span class='description'><?php _e('Select this option to enable the start date for credit.', 'woo-question'); ?></span>
				</td>
                <td><label for="registration"><?php _e('To', 'woo-question'); ?></label>
				<input type="text" id="datepicker_2" name="to_date"  value="<?php  echo  get_option('to_date');  ?>"  /> <br/>
				<span class='description'><?php _e('Select this option to enable the expire date for credit.', 'woo-question'); ?></span>
				</td>
		</tr>
		
		
        
        <tr valign="top">
			<th scope="row"><?php _e('How Many point You Want On 1 Question:', 'woo-question'); ?></th>
			<td>
				<input type="text" id="ques_point_charge" name="ques_point_charge"  <?php if(get_option('ques_point_charge') == '' || get_option('ques_point_charge') == 'null') {  ?>   value="1" <?php } else { ?> value="<?php echo get_option('ques_point_charge');  ?>" <?php }  ?>  /><label for="reset">&nbsp;Points&nbsp;(Defult Is 1.) </label> <br/>
				<span class='description'><?php _e('Please Put The Value How Many Point You Want To On One Question.', 'woo-question'); ?></span>
				</td>
		</tr>
        
        
        
        
	</table>
	<p class='submit'>
		<input type='submit' value='Save Changes' name='woo_custom_save' class='button-primary' />
	</p>
</form>

<?php

		
	
	

