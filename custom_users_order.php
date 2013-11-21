<?php
/* Plugin Name: Custom Users Order 
Plugin URI: http://wordpress.org/plugins/custom-users-order/
Description: Orders all the users with simple Drag and Drop Sortable capability.
Version: 1.0
Author: Nidhi Parikh, Hiren Patel
Author URI: http://www.betterinfo.in/hiren-patel
License: GPLv2 or later
*/

register_activation_hook(__FILE__,'user_order');
function user_order(){
	/* Function to add option name in wp_options table */
	$all_user_datas=get_users(); 
	$all_user_ids = "";
	foreach ($all_user_datas as $user) {
		$all_user_ids = $all_user_ids.','.$user->ID;
	}
	$all_user_ids = substr($all_user_ids, 1);
	add_option("usersdetails", $all_user_ids); 
}
add_action('user_register', 'update_user_details');

function update_user_details($user_id){
	$users = get_option('usersdetails');
	update_option("usersdetails", $users.','.$user_id);
}
add_action( 'delete_user', 'delete_user' );
function delete_user($user_id){
	$updatestring = get_option( 'usersdetails');
	$string = str_replace($user_id.',', "", $updatestring.',');
	$string = substr($string,0, -1);
	update_option( 'usersdetails', $string); 
}
register_uninstall_hook(__FILE__,'user_uninstall');

function user_uninstall(){
	delete_option('usersdetails');
}
add_action('admin_menu', 'manageuser');

function manageuser(){	
	add_submenu_page( 'users.php', 'Custom Users Order Page', 'Custom Users Order', 'manage_options', 'customuserorder', 'customuserorder' ); 
}

/**  Proper way to enqueue scripts and styles  */
function custom_order_scripts() {
	wp_enqueue_style( 'customstyle', plugin_dir_url(__FILE__). 'css/style.css' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'orderusers', plugin_dir_url(__FILE__). 'js/orderusers.js', array(), true );
}
add_action( 'admin_enqueue_scripts', 'custom_order_scripts' );

function custom_display_style() {
	wp_enqueue_style( 'customstyle', plugin_dir_url(__FILE__). 'css/customdisplay.css' );
}
add_action( 'wp_enqueue_scripts', 'custom_display_style' );
add_filter('widget_text', 'do_shortcode');

function users_listing($atts){
	$options=get_option('usersdetails');
	$user_id = explode(",", $options);
	if($atts[users]==""){$atts['users']=5;}  
	$wp_total_users_array= count_users();
	$wp_total_users=  $wp_total_users_array['total_users'];
	$plugin_content = '<div class="usersinfo">';
	for($i=0;$i<$atts['users'];$i++){
		$user_info = get_userdata($user_id[$i] );
		$plugin_content = $plugin_content.'<div class="userlist">';
		$plugin_content = $plugin_content. '<div class="useravtar">'.get_avatar($user_id[$i], 50 ).'</div>';
		$plugin_content = $plugin_content. '<div class="usersnicename">';
		$plugin_content = $plugin_content.$user_info->user_nicename;
		$plugin_content = $plugin_content. '</div>';
		$plugin_content = $plugin_content. '<div class="useremail">';
		$plugin_content = $plugin_content.'<a href="mailto:'.$user_info->user_email.'">'.$user_info->user_email.'</a>';
		$plugin_content = $plugin_content. '</div>';
		$plugin_content = $plugin_content. "</div>";
		if($i==($wp_total_users-1))
		break;
	}
	$plugin_content = $plugin_content. '</div>'; /*User info ends */
	return "{$plugin_content}";
}
add_shortcode('users_order','users_listing');

function customuserorder(){
	global $wpdb;
	if($_REQUEST['usersid']!=""){	
		$usersid = $_REQUEST['usersid'];
		update_option( 'usersdetails', $usersid ); 
	}?>
    <div class='wrap'>
        <form name="frmCustomUser" method="post" action="?page=customuserorder">
			<h2><?php _e('Custom Users Order', 'customuserorder') ?></h2>  
            <div class="customusercontainer"> 
				<ul class="usersheading">
					<li class="lineitem"><span class=''>Username</span><span>Name</span><span>Email</span><span>Role</span></li>
				</ul>
				<ul id="UserOrderList">
					<?php 
					$options=get_option( 'usersdetails');
					$metadetails= explode(",", $options);
					for($i=0;$i<count($metadetails);$i++){
						if(get_the_author_meta( 'user_login', $metadetails[$i] )){
							$userrole = new WP_User($metadetails[$i]);
							if($metadetails[0]!=''){
								echo "<li id='".$metadetails[$i]."' class='lineitem'><span>" .get_the_author_meta( 'display_name', $metadetails[$i] ). "</span><span>".get_the_author_meta( 'first_name', $metadetails[$i] )." ".get_the_author_meta( 'last_name', $metadetails[$i] )."</span><span>".get_the_author_meta( 'user_email', $metadetails[$i] )."</span><span class='userrole'>".$userrole->roles[0]."</span></li>";
							}
						}
						else{					
								$updatestring = get_option( 'usersdetails');
								$string = str_replace($metadetails[$i].',', "", $updatestring.',');
								$string = substr($string,0, -1);
								update_option( 'usersdetails', $string); 
							
						}
					}
					$results = get_users();
					foreach( $results as $user )
					if (!(in_array($user->data->ID , $metadetails))){
						$userrole = new WP_User($user->data->ID);
						echo "<li id='{$user->data->ID}' class='lineitem'><span>" .get_the_author_meta( 'display_name', $user->data->ID ). "</span><span>".get_the_author_meta( 'first_name', $user->data->ID )." ".get_the_author_meta( 'last_name', $user->data->ID )."</span><span>".get_the_author_meta( 'user_email',$user->data->ID )."</span><span class='userrole'>".$userrole->roles[0]."</span></li>";
					}?>
				</ul>
            </div> <!-- customusercontainer -->
            <input type="hidden" name="usersid" />
            <input type="submit" name='send' value="Update" id='send' class="button-primary" />
        </form>
       	<p><b>Note: </b> Simply drag and drop the users into the desired position and update.</p>
        <p>Place shortcode <b>[users_order users=2]</b> in wordpress page, post or text widget.</p>
        <p>Place the code <b><&#63;php echo do_shortcode('[users_order users=2]'); ?></b> in template files.</p>
    </div>
<?php
}
?>