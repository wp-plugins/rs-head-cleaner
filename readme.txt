=== RS Head Cleaner Plus ===
Contributors: RedSand
Donate link: http://www.redsandmarketing.com/rs-head-cleaner-donate/
Tags: clean, cleaner, css, footer, generator, head, head-cleaner, javascript, more, security, seo
Requires at least: 3.0
Tested up to: 3.9
Stable tag: trunk

This plugin cleans up a number of issues, doing the work of multiple plugins, improving speed, efficiency, security, SEO, and user experience. 

== Description == 

This plugin cleans up a number of issues, doing the work of multiple plugins, improving speed, efficiency, security, SEO, and user experience. It removes junk code from the HEAD & HTTP headers, moves JavaScript from header to footer, hides the Generator/WordPress Version number, removes version numbers from CSS and JS links, and fixes the "Read more" link so it displays the entire post.

= Features =

* **Removes the Generator/WordPress Version number** from the HEAD section for security reasons. You don't want your WordPress version being visible because hackers can use it to attack your site. Even if you keep your site up to date, it still could be vulnerable to zero-day exploits.
* **Removes Version numbers from CSS and JS** in the HEAD for the same security reasons you hide WordPress version. Will also improve site loading speed because removing version numbers from the CSS & JS links will allow browsers to properly cache these files, as well as helping your site code to validate.
* **Removes junk WordPress code** from the HEAD of your site: **RSD link**, **Windows Live Writer Manifest link**, **WordPress Shortlinks** (also removed from HTTP Headers), **Adjacent Posts links (REL = PREV/NEXT)** as all are unnecessary, hurt your SEO and clutter your site code.
* **Moves JavaScripts from the HEAD to the footer** section of your site for major speed improvements in page loading.
* **Fixes the "Read more"** link so it displays the entire post when you click, not just the part after the "#more".

If you don't want the JavaScript to Footer feature, use [RS Head Cleaner Lite](https://wordpress.org/plugins/rs-head-cleaner-lite/ "RS Head Cleaner Lite") instead.

For a more thorough explanation of what the plugin does and why you need it, visit the [RS Head Cleaner Plus plugin homepage](http://www.redsandmarketing.com/plugins/rs-head-cleaner/ "RS Head Cleaner Plus Plugin").

== Installation ==

= Installation Instructions =
1. After downloading, unzip file and upload the enclosed `rs-head-cleaner` directory to your WordPress plugins directory: `/wp-content/plugins/`.
2. As always, **activate** the plugin on your WordPress plugins page.
3. You are good to go...it's that easy.

= More Info / Documentation =
For more info and full documentation, visit the [RS Head Cleaner Plus homepage](http://www.redsandmarketing.com/plugins/rs-head-cleaner/).

== Changelog ==

Version 1.1.1, *released 06/17/14*

* Updated some features.

Version 1.1.0.3, *released 04/28/14*

* Fixed a bug that caused an error message on certain server configurations.

Version 1.1.0.2, *released 04/13/14*

* Added additional security checks.

Version 1.1.0.1, *released 04/04/14*

* Minor code improvements.

Version 1.1.0.0, *released 03/26/14*

* Added feature to remove version numbers from CSS and JS links in the HEAD.

Version 1.0.0.0, *released 03/17/14*

* Initial release.

== Frequently Asked Questions ==

= Where are the options? =

This plugin is fast, and lean...there are no options needed. You install it and it just works.

= Does this plugin have any known issues? = 

Just one that I know of.

Moving JavaScript to the footer of your page may create issues with some responsive themes that need the JS libraries to be in the head section of the code. If that's the case then this plugin may not be right for you. Even for me, it's right for 80% of my sites but not all of them. For the rest I put everything but the JavaScript-to-Footer code in the functions.php file of the theme to get similar functionality.

Test this plugin out on your site before deciding if it will be the right solution for you. Normally I would create an options page to let you turn the JS-to-Footer feature off, but this plugin is all about speeding up your site, and that means minimal calls to the database, so unfortunately it would defeat the purpose of this plugin if I added the ability to change that.

If you don't want the JS to Footer feature, use [RS Head Cleaner Lite](https://wordpress.org/plugins/rs-head-cleaner-lite/ "RS Head Cleaner Lite"). It has all the same features except it won't move JavaScript to the footer.

= You do great work...can I hire you? =

Absolutely...go to my [WordPress Consulting](http://www.redsandmarketing.com/web-design/wordpress-consulting/ "WordPress Consulting") page for more information.
