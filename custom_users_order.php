<?php
/* Plugin Name: Custom Users Order 
Plugin URI: 
Description: Orders all the users with simple Drag and Drop Sortable capability.
Version: Version 1.0
Author: Nidhi Parikh, Hiren Patel
Author URI: 
License: GPLv2 or later
*/

register_activation_hook(__FILE__,'author_order');
function author_order()
{
	 /* Function to add option name in wp_options table */
	 $all_user_datas=get_users(); 
	 $all_user_ids = "";
	 foreach ($all_user_datas as $user) {
	  $all_user_ids = $all_user_ids.','.$user->ID;
		}
	 $all_user_ids = substr($all_user_ids, 1);
	 add_option("authordetails", $all_user_ids); 
	
}
register_uninstall_hook(__FILE__,'author_uninstall');
function author_uninstall()
{
	delete_option('authordetails');
}

add_action('admin_menu', 'manageuser');

function manageuser(){
	
	add_submenu_page( 'users.php', 'Custom Users Order Page', 'Custom Users Order', 'manage_options', 'customuserorder', 'customuserorder' ); 
	
	}


/**
 * Proper way to enqueue scripts and styles
 */
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
function author_listing($atts)
{

 $options=get_option('authordetails');
 $user_id = explode(",", $options);
 if($atts[users]==""){$atts['users']=5;}  
 $wp_total_users_array= count_users();
 $wp_total_users=  $wp_total_users_array['total_users'];
 $plugin_content = '<div class="usersinfo">';
  for($i=0;$i<$atts['users'];$i++)
  {
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
add_shortcode('author_listing','author_listing');

function customuserorder()
{
	global $wpdb;
	if($_REQUEST['usersid']!="")
	{	
		$usersid = $_REQUEST['usersid'];
		update_option( 'authordetails', $usersid ); 
	}
	
?>
    
    <div class='wrap'>
        <form name="frmCustomUser" method="post" action="?page=customuserorder">
            <h2><?php _e('Custom Users Order', 'customuserorder') ?></h2>   
            <ul id="UserOrderList">
			<?php 
			$options=get_option( 'authordetails');
			$metadetails= explode(",", $options);
			
			for($i=0;$i<count($metadetails);$i++)
			{
				if($metadetails[0]!='')
				{
					echo "<li id='".$metadetails[$i]."' class='lineitem'>" .get_the_author_meta( 'display_name', $metadetails[$i] ). "</li>";
				}
			}
			
            $results = get_users();
            foreach( $results as $user )
				if (!(in_array($user->data->ID , $metadetails)))
				{
					echo "<li id='{$user->data->ID}' class='lineitem'>" . $user->data->display_name . "</li>";
				}
            ?>
            
            </ul>
            <input type="hidden" name="usersid" />
            <input type="submit" name='send' value="Update" id='send' class="button-primary" />
        </form>
       	<p><b>Note: </b> Simply drag and drop the users into the desired position and update.</p>
        <p>Place shortcode <b>[author_listing users=2]</b> in wordpress page, post or text widget.</p>
        <p>Place the code <b><?php do_shortcode('[author_listing users=2]'); ?></b> in template files.</p>
    </div>
<?php
}

?>