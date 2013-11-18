function orderUsers() 
{
	var newOrder = jQuery("#UserOrderList").sortable("toArray");
	console.log( newOrder );
}
function myuserorderaddloadevent()
{
	jQuery("#UserOrderList").sortable({ 
		placeholder: "sortable-placeholder", 
		revert: false,
		tolerance: "pointer" 
	});
};
addLoadEvent( myuserorderaddloadevent );
   
jQuery( document ).ready(function() {
var order_users="";
	jQuery( '#send' ).click(function() {
		jQuery( "#UserOrderList li" ).each(function( index ) {
			order_users = order_users +","+jQuery(this).attr('id'); 
		});
		order_users=order_users.substring(1, order_users.length);
	
		jQuery('input[name=usersid]').val(order_users).val();
	});
});