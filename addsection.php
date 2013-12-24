<?php
function addsection(){ 
	$is_already =0;
	$error_msg='';
	/**** Condition to check for selected Sections ****/
	if(isset($_REQUEST['delete'])){ 
		delete_single_user();
	}
	/**** Condition to delete All Sections ****/
	if(isset($_REQUEST['deleteall'])){
		delete_selected_users();
	}
	/**** Condition to Update List ****/
	if(isset($_REQUEST['usersid'])){
		$usersid = $_REQUEST['usersid'];
		update_option('section_name_'.$_REQUEST['listname'], $usersid ); 
	}
	/**** Condition to update User Role ****/
	if(isset($_REQUEST['usersidrole'])){
		$usersidrole = $_REQUEST['usersidrole'];
		update_option('section_name_roles_'.$_REQUEST['listname'], $usersidrole ); 
	}
	/**** Condition to check duplicate section names ****/
	if($_REQUEST['sname']){
		$list_name = $_REQUEST['sname'];
		$sections_names = explode(",", get_option( 'section_name'));
		$is_already = in_array($list_name, $sections_names);
		$error_msg='Name Already Exits';
	}
	
	/**** Condition to display page1 and page2  ****/
	if ((!($_REQUEST['listing'])) || ($is_already)){	
		echo '<span class="error_msg" style="color:red;">';
		if($is_already){
			echo $error_msg;
		}
		echo '</span>';
		add_listing_form();
		echo lists_table();
	}
	else{
		if($_REQUEST['sname']){
			data_insert();
		}
		echo users_table();
	}
}

/**** Function to display new section Form (Page 1) ****/
function add_listing_form(){ ?>  
	<form action="?page=addsection&listing=user" method="post" enctype="multipart/form-data" class="addform" >
		<h2>Add Section</h2>
		<table class="addformtable">
			<tr>    
				<td class="labelname">Section Name: <span class="alert">*</span></td>
				<td><input type="text" name='sname' id='sname' value='' /></td>
				<td><input type="submit" name='addsection' value="Add section" id='addsection' class="button-primary" /></td>			
			</tr>
		</table><br />
	</form>	<?php
}

/**** Function to display Section Listing (Page 1) ****/
function lists_table(){ 
	$section_listing = '<form name="delete_users" id="delete_users" action="?page=addsection&deleteall=deleteall" method="post"><h2>Section Listing </h2>';
	$section_listing.= '<table width="100%" class="widefat">';
	$section_listing.= '<tr><th><input type="checkbox" name="checkAll" id="checkAll"/>Select to delete</th><th>Section Name</th><th>Edit / Delete</th></tr>';
	$options=get_option( 'section_name');
	if(!$options){
		$section_listing.= '<tr><td>There is No list Available</td></tr>';
	}
	$sections= explode(",", $options);
	for($i=0;$i<count($sections);$i++){
		if($sections[0]!=''){
			$section_listing.="<tr><td valign='top'><input class='checkItem' type='checkbox' name='delete_section[]' value='".$sections[$i]."' /></td>";
			$section_listing.="<td valign='top' id='".$sections[$i]."'>" .$sections[$i]. "</td>";
			$section_listing.="<td valign='top'><a href='?page=addsection&listing=user&listname=".$sections[$i]."'>Edit</a> / <a onclick='return confirmdelete()' href='?page=addsection&delete=".$sections[$i]."'>Delete</a></td></tr>";
		}
	}
	$section_listing.='</table>';
	$section_listing.='<br><input onclick="return confirmdelete();" type="submit" class="button-primary" value="Delete" name="deleteall" id="deleteall"/></form>';	
	return $section_listing;
}

/**** Function to Delete selected Sections (Page 1) *****/
function delete_single_user(){
	$listname = $_REQUEST['delete'];
	delete_option( 'section_name_'.$listname); 
	delete_option( 'section_name_roles_'.$listname); 
	$get_section_names = get_option('section_name');
	$get_section_names = str_replace($listname.',','',$get_section_names.',');
	update_option('section_name',  substr($get_section_names,0, -1));
}

/**** Function to Delete All Sections (Page 1) *****/
function delete_selected_users(){ 
	if(!empty($_POST['delete_section'])) {
		foreach($_POST['delete_section'] as $deletecheck) {
			delete_option( 'section_name_'.$deletecheck); 
			delete_option( 'section_name_roles_'.$deletecheck); 
			$get_section_names = get_option('section_name');
			$get_section_names = str_replace($deletecheck.',','',$get_section_names.',');
			update_option('section_name',  substr($get_section_names,0, -1));
		}
	}
}

/**** Function to insert new section (Page 1) ****/
function data_insert(){
	$list_name =$_REQUEST['sname'];
	global $wp_roles;
	$all_user_datas=get_users(); 
	$all_user_ids = "";
	foreach ($all_user_datas as $user) {
		$all_user_ids = $all_user_ids.','.$user->ID;
	}
	$all_user_ids = substr($all_user_ids, 1);
	add_option("section_name_".$list_name, $all_user_ids); 
	add_option("section_name_roles_".$list_name, implode(",", $wp_roles->get_names())); 
	if(get_option("section_name")==""){
		update_option("section_name",$list_name); 
	}
	else{
		update_option("section_name", get_option("section_name").','.$list_name);
	}
}

/**** Function to display all users (Page 2) ****/
function users_table(){ 
	if($_REQUEST["sname"]){
		$current_list =$_REQUEST["sname"];
	}
	else{
		$current_list =$_REQUEST["listname"];
		if(isset($_REQUEST['usersrole'])){
			$check1="";
			foreach($_REQUEST['usersrole'] as $check){
				$check1 =$check1.','.$check;
			}
			$check1 = substr($check1,1);
		}
	}
	$ulist= '<h2>User Listing</h2>';
	$ulist.='<h3>Seciotn Name: '.$current_list.'</h3>';
	global $wp_roles;
	$getroles = get_option( 'section_name_roles_'.$current_list);
	$getroles = explode(",",$getroles);
	$roles = $wp_roles->get_names(); 
	/* Form 1 (check box Form) */
	$ulist.='<form id="form_role" name="form_role" method="" action=""><div class="rolecontainer">';
	foreach($roles as $role){
		if (in_array($role, $getroles)){
			$check="checked";
		}
		else{
			$check="";
		}
		$ulist.='<input '.$check.' class="selectcheck" type="checkbox" name="usersrole[]" value="'.$role.'"/>'.$role;
	}
	$ulist.='<input type="hidden" name="sorted" value="temp" />
	</div></form>';
	if(get_option( 'section_name_roles_temp')){
		$ulist.='<span style="color:red;">Update To Save List</span>';
	}	
	/* Form 2 (Drag And Drop Form) */
	$ulist.='<form name="frmCustomUser" method="post" action="?page=addsection&listing=user&listname='.$current_list.'">
	<ul class="usersheading">';
	$ulist.='<li class="lineitem"><span>Username</span><span>Name</span><span>Email</span><span>Role</span></li>';
	$ulist.='</ul>';
	$ulist.= '<ul id="UserOrderList">';
	$current_list_users=get_option('section_name_'.$current_list);
	$metadetails= explode(",", $current_list_users);
	for($i=0;$i<count($metadetails);$i++){
		if(get_the_author_meta( 'user_login', $metadetails[$i] )){
			$userrole = new WP_User($metadetails[$i]);
			$css ="";
			if (in_array(ucfirst($userrole->roles[0]), $getroles)){
				$css = "style='display:block;'";
			}
			else{
				$css = "style='display:none;'";
			}
			if($metadetails[0]!=''){
				$ulist.= "<li ".$css." value='".$metadetails[$i]."' id='".$metadetails[$i]."' class='lineitem'><span>" .get_the_author_meta( 'display_name', $metadetails[$i] ). "</span><span>".get_the_author_meta( 'first_name', $metadetails[$i] )." ".get_the_author_meta( 'last_name', $metadetails[$i] )."</span><span>".get_the_author_meta( 'user_email', $metadetails[$i] )."</span><span class='userrole'>".$userrole->roles[0]."</span></li>";
			}
		}
		else {				
			$updatestring = get_option( 'usersdetails');
			$string = str_replace($metadetails[$i].',', "", $updatestring.',');
			$string = substr($string,0, -1);
			update_option( 'usersdetails', $string); 
		}
	}
	$ulist.='</ul>
	<input type="hidden" name="usersid" />
	<input type="hidden" name="usersidrole" />
	<input type="submit" name="send" value="Update" id="send" class="button-primary" />
	<a href="?page=addsection" class="button-primary" >Back</a>
	</form>';
	$ulist.="<p><b>Note: </b> Simply drag and drop the users into the desired position and update.</p>";
    $ulist.="<p>Place shortcode <b>[users_order users=2 section=section_name]</b> in wordpress page, post or text widget.</p>";
    $ulist.="<p>Place the code <b><&#63;php do_shortcode('[users_order users=2 section=section_name]'); ?></b> in template files.</p>";
	return $ulist; 
}
?>