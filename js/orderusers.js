/**** Function to check blank field when creating a new section  ****/
jQuery( document ).ready(function() {
	jQuery( "#addsection.button-primary" ).click(function() {
		if(jQuery("#sname").val()=='')
		{
			jQuery(".error_msg").text('List name must not be blank.');
			return false;
		}
		return true;
	});
});
 
/**** Function for User Sorting - Drag and Drop ****/
function orderUsers() {
	var newOrder = jQuery("#UserOrderList").sortable("toArray");
	console.log( newOrder );
}

function myuserorderaddloadevent(){
	jQuery("#UserOrderList").sortable({ 
		placeholder: "sortable-placeholder", 
		revert: false,
		tolerance: "pointer" 
	});
};
addLoadEvent( myuserorderaddloadevent );

/**** Function for save User Order on update - Page 2 ****/   
jQuery( document ).ready(function() {
	var order_users="";
	var order_users_roles="";
	jQuery( '#send' ).click(function() {
		/* Get User IDs and Insert in Hidden Fiels */
		jQuery( "#UserOrderList li" ).each(function( index ) {
			order_users = order_users +","+jQuery(this).attr('id'); 
		});
		order_users=order_users.substring(1, order_users.length);
		jQuery('input[name=usersid]').val(order_users).val();
		/* Get User Roles and Insert in Hidden Fiels */
		jQuery('input[name="usersrole[]"]:checked').each(function() {
		   order_users_roles = order_users_roles +","+ this.value; 
		});
		order_users_roles=order_users_roles.substring(1, order_users_roles.length);
		jQuery('input[name=usersidrole]').val(order_users_roles).val();
	});
});
/**** Function for section delete confirmation ****/
function confirmdelete(){
	var x;
	var r=confirm("Are you sure you want to delete");
	if (r==true){ 
		return true;
	}
	else{
		return false;
	}
}
/**** Function for checkAll and UncheckAll Sections ****/
jQuery(function () {
    jQuery("#checkAll").click(function () {
        if (jQuery("#checkAll").is(':checked')) {
            jQuery(".checkItem").prop("checked", true);
        } else {
            jQuery(".checkItem").prop("checked", false);
        }
    });
});

jQuery(function(){
    jQuery('.selectcheck').on('change', function() {  
	var w;
        if(jQuery(this).is(':checked')) 
        {	 var checkboxvalues=jQuery(this).val();
			jQuery("#UserOrderList li").each(function( index ) {
				var getroles = jQuery( this ).find('.userrole').text();
				//alert(getroles.substr(0,1).toUpperCase()+getroles.substr(1));
				w= getroles.substr(0,1).toUpperCase()+getroles.substr(1);
				//alert("checkbox"+checkboxvalues); alert("w"+w);
				if(checkboxvalues==w)
				{
					
					jQuery(this).css('display','block');
				}
			});
		}
		else{ 
			 var checkboxvalues=jQuery(this).val();
			jQuery("#UserOrderList li").each(function( index ) {
				var getroles = jQuery( this ).find('.userrole').text();
				//alert(getroles.substr(0,1).toUpperCase()+getroles.substr(1));
				w= getroles.substr(0,1).toUpperCase()+getroles.substr(1);
				//alert("checkbox"+checkboxvalues); alert("w"+w);
				if(checkboxvalues==w)
				{
					
					jQuery(this).css('display','none');
				}
			});
		} 
		
    });
});

function test()
{
	alert("test");
}