=== Plugin Name ===
Contributors: mc2w
Donate link: http://wiflba.com/super-search
Tags: categories, search, advanced, super
Requires at least: 2.5
Tested up to: 2.6.2
Stable tag: 0.3

Generates a drop-down list and a text box to allow your visitors to search for posts within specific categories.

== Description ==

This plugin creates a form with a drop down list that allows your users to search through specific categories. It comes with the option of including or excluding child categories.

== Installation ==

1. Upload the super-search directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php supersearch(); ?>` in your templates

== Frequently Asked Questions ==

= I have deactivated the plugin, now my site gets a php error =

You have to remove the `<?php supersearch(); ?>`

== Screenshots ==

1. This is an example of how the plugin may appear, depending on the css styling of your site.
2. This is the admin page. Very simple, isn't it?


== Changelog ==
**0.3**
* Created Admin Page
* Added Option of whether or not to show child categories
Would have added the javascript as well, but I *think* I should learn ajax before I do that.

== Things To Do ==
* Make a super search widget
* If child categories are being shown, allow option to display child categories in a ajax generated 2nd drop down list
* Create a templating system
* Make the plugin call upon a css folders, so users can design the plugin through css