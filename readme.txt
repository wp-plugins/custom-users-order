=== Custom Users Order  ===
Contributors: nidhiparikh,hiren1612
Donate link: http://www.betterinfo.in/hiren-patel/
Tags: order, reorder, ordering, orderby, manage, manually, display, displaying, profile, profiles, user, users, member, members, author, authors, contributor, contributors, custom, customize, listing, list, drag, drop, easy, simple, widget, page, post, shorcode, sortable
Requires at least: 3.0.1
Tested up to: 3.7.1
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin which allows you to order the users with simple Drag and Drop Sortable capability.

== Description ==
Custom Users Order plugin will order users(admin, editor, author, subscriber, contributor) with simple Drag and Drop Sortable capability. Place a shortcode in page, post,text widget or template files to display in frontend. It's that simple. 

1. Quick and easy drag and drop for rearranging of users.
2. Set the number of users to display in frontend.

= Usage =

Place this shortcode in page, post or text widget where you'd like to display users.

`
[users_order]
`
= Parameters =

Custom Users Order plugin supports the "users" parameter where you can pass the number of users you want to display in frontend. For example if you want to display 3 users at a time then place the following code:

`
[users_order users=3]
`
By default it displays 5 users.


= Templates =

Place this shortcode in any template parts of your theme.

`
<?php echo do_shortcode('[users_order users=3]'); ?>
`

== Installation ==
= Installation =
1. Upload "custom_users_order" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.

= How to Use =
1. Place shortcode [users_order users=2] in wordpress page, post or text widget, where in the users parameter you can pass the number of users you want to display in frontend. 5 users will be displayed by default .
2. Place the code `<?php echo do_shortcode('[users_order users=2]'); ?>` in template files, where in the users parameter you pass the number of users you want to display in frontend. 5 users will be displayed by default .

== Frequently Asked Questions ==

= Having problems, questions, bugs & suggestions =
Contact us at http://www.betterinfo.in/hiren-patel/

== Screenshots ==
1. After activating the plugin it will be hooked in Users Menu.
2. Users Listing. Here you can order users by simple drag and drop functionality.
3. Frontend display.

== Changelog ==
= v1.0 =
* Initial release version.