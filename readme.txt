=== Custom Users Order  ===
Contributors: hiren1612,nidhiparikh
Donate link: http://www.satvikinfotech.com
Tags: order, reorder, ordering, orderby, manage, manually, display, displaying, profile, profiles, user, users, member, members, author, authors, contributor, contributors, custom, customize, listing, list, drag, drop, easy, simple, widget, page, post, shorcode, sortable
Requires at least: 3.0.1
Tested up to: 4.3
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin which allows you to order the users with simple Drag and Drop Sortable capability.

== Description ==
Custom Users Order plugin will order users(admin, editor, author, subscriber, contributor) with simple Drag and Drop Sortable capability. Place a shortcode in page, post,text widget or template files to display in front-end. It's that simple. 

1. Quick and easy drag and drop for rearranging of users.
2. Set the number of users to display in front-end.
3. Choose the users of specific roles to be displayed.
3. User can add different list of users.

= Usage =

Place this shortcode in page, post or text widget where you'd like to display users.

`
[users_order users=2 section=section_name]
`
= Parameters =

Custom Users Order plugin supports the "users" parameter where you can pass the number of users you want to display in frontend and "section" parameter where you can pass the name of the section to be displayed in frontend. For example if you want to display 3 users from Section1 at a time then place the following code:

`
[users_order users=3 section=Section1]
`
By default it displays 5 users.


= Templates =

Place this shortcode in any template parts of your theme.

`
<?php echo do_shortcode('[users_order users=3 section=Section1]'); ?>
`

== Installation ==
= Installation =
1. Upload "custom_users_order" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.

= How to Use =
1. Place shortcode [users_order users=3 section=section_name] in wordpress page, post or text widget, where in the "users" parameter you can pass the number of users and name of the section in "section" parameter you want to display in frontend. 5 users will be displayed by default .
2. Place the code `<?php echo do_shortcode('[users_order users=3 section=section_name]'); ?>` in template files, where in the "users" parameter you pass the number of users and name of the section in "section" parameter you want to display in frontend. 5 users will be displayed by default .

== Frequently Asked Questions ==

= Having problems, questions, bugs & suggestions =
Contact us at http://www.satvikinfotech.com

== Screenshots ==
1. After activating the plugin it will be hooked in Users Menu.
2. Section Listing. Here you can Add/Edit and Delete the sections.
3. Users Listing. Here you can order users by simple drag and drop functionality. Also feature has been provided to choose the users of a specific roles to be displayed.
4. Frontend display.

== Changelog ==
= v1.0 =
* Initial release version.

= v1.1 =
* User can add different list of users.
* User can select different users from specific roles.