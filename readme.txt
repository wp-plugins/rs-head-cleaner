=== RS Head Cleaner Plus ===
Contributors: RedSand
Donate link: http://www.redsandmarketing.com/rs-head-cleaner-donate/
Tags: cache, clean, cleaner, combine, compress, compression, concatenate, css, footer, generator, google, gtmetrix, head, head-cleaner, javascript, more, minify, minification, optimization, optimize, page-speed, pagespeed, performance, security, search engine optimization, seo, speed, yahoo, yslow
Requires at least: 3.8
Tested up to: 4.2
Stable tag: trunk

This plugin cleans up a number of issues, doing the work of multiple plugins, improving speed, efficiency, security, SEO, and user experience. 

== Description == 

This plugin cleans up a number of issues, doing the work of multiple plugins, improving speed, efficiency, security, SEO, and user experience. It removes junk code from the document HEAD & HTTP headers, moves JavaScript from header to footer, combines/minifies/caches CSS & JavaScript files, hides the Generator/WordPress Version number, removes version numbers from CSS and JS links, removes HTML comments, and fixes the "Read more" link so it displays the entire post.

= Documentation / Tech Support =
* Documentation: [Plugin Homepage](http://www.redsandmarketing.com/plugins/rs-head-cleaner/)
* Tech Support: [WordPress Plugin Support](http://www.redsandmarketing.com/plugins/wordpress-plugin-support/)

= Features =

* **Removes the Generator/WordPress Version number** from the HEAD section for security reasons. You don't want your WordPress version being visible because hackers can use it to attack your site. Even if you keep your site up to date, it still could be vulnerable to zero-day exploits.
* **Removes Version numbers from CSS and JS** in the HEAD for the same security reasons you hide WordPress version. Will also improve site loading speed because removing version numbers from the CSS & JS links will allow browsers to properly cache these files, as well as helping your site code to validate. This feature improves your Google PageSpeed score.
* **Removes junk WordPress code** from the HEAD of your site: **RSD link**, **Windows Live Writer Manifest link**, **WordPress Shortlinks** (also removed from HTTP Headers), **Adjacent Posts links (REL = PREV/NEXT)** as all are unnecessary, hurt your SEO and clutter your site code.
* **Moves JavaScripts from the HEAD to the footer** section of your site for major speed improvements in page loading. 
* **Combines, minifies, and caches all of your site's CSS and JavaScript files into a single gzip compressed file** (of each type) for even better speed improvements in page loading.
* **Removes HTML comments** from your site's code. Many plugins and themes add notes in the HTML code of your site using HTML comments. After a while this can add up, slowing down your page and possibly exposing information about plugins you are using. With this plugin, all that junk is removed automatically.
* **Fixes the "Read more"** link so it displays the entire post when you click, not just the part after the "#more".
* **This is one of the fastest and most lightweight** JS/CSS compression & minification plugins you can find. It doesn't contain huge libraries.

Several of these features work together to improve page loading speed and will improve your Google PageSpeed score and Yahoo YSlow score. Do a before & after test with GTMetrix to see what I mean.

The JavaScript & CSS cache files are cleared each time the plugin is deactivated manually through the dashboard (but not on automatic or bulk plugin upgrades). If you would like to manually clear the cache, simply deactivate and reactivate the plugin. Important: If you're using a caching plugin, when you do this, *be sure to clear your caching plugin's file cache as well to prevent issues from a cached page calling on now-missing JS & CSS files*. (For example, with WP Super Cache, go to the settings, and on the Content page, choose "Delete Cache". It will be similar with other caching plugins.)

If you don't want the JavaScript to Footer feature, or you have any compatibility issues with your JavaScript, use [RS Head Cleaner Lite](https://wordpress.org/plugins/rs-head-cleaner-lite/ "RS Head Cleaner Lite") instead. See the FAQ's.

*As with any JS/CSS minification & caching plugin, it's important to test, test, test.* Because of the type of plugin it is, this plugin may not work for every site out there, but that does not mean the plugin is broken. **If you have any issues, please submit a [support request](http://www.redsandmarketing.com/plugins/wordpress-plugin-support/) so we can look into it and make it as compatible as possible for everyone.**

For a more thorough explanation of what the plugin does and why you need it, as well as how to get the best performance results with it, visit the [RS Head Cleaner Plus plugin homepage](http://www.redsandmarketing.com/plugins/rs-head-cleaner/ "RS Head Cleaner Plus Plugin").

= Requirements =

* WordPress 3.8 or higher (Recommended: WordPress 4.0 or higher)
* PHP 5.3 or higher (Recommended: PHP 5.4 or higher)

== Installation ==

= Installation Instructions =

**Option 1:** Install the plugin directly through the WordPress Admin Dashboard (Recommended)

1. Go to *Plugins* -> *Add New*.

2. Type *RS Head Cleaner Plus* into the Search box, and click *Search Plugins*.

3. When the results are displayed, click *Install Now*.

4. When it says the plugin has successfully installed, click **Activate Plugin** to activate the plugin (or you can do this on the Plugins page).

**Option 2:** Install .zip file through WordPress Admin Dashboard

1. Go to *Plugins* -> *Add New* -> *Upload*.

2. Click *Choose File* and find `rs-head-cleaner.zip` on your computer's hard drive.

3. Click *Install Now*.

4. Click **Activate Plugin** to activate the plugin (or you can do this on the Plugins page).

**Option 3:** Install .zip file through an FTP Client (Recommended for Advanced Users Only)

1. After downloading, unzip file and use an FTP client to upload the enclosed `rs-head-cleaner` directory to your WordPress plugins directory (usually `/wp-content/plugins/`) on your web server.

2. Go to your Plugins page in the WordPress Admin Dashboard, and find this plugin in the list.

3. Click **Activate** to activate the plugin.

= Other Notes =

This plugin has not been designed specifically for use with Multisite. It can be used in Multisite if activated *per site*, but *should not* be Network Activated. As with any plugin, test and make sure it works with your particular setup before using on a production site.

= More Info / Documentation =
For more info and full documentation, visit the [RS Head Cleaner Plus homepage](http://www.redsandmarketing.com/plugins/rs-head-cleaner/).

== Frequently Asked Questions ==

= Where are the options? =

This plugin is fast, and lean...there are no options needed. You install it and it just works.

= Does this plugin have any known issues? = 

Just one that we know of.

Moving JavaScript to the footer of your page may create issues with some responsive themes that need the JS libraries to be in the head section of the code. If that's the case then this plugin may not be right for you. Even for me, it's right for 80% of my sites but not all of them. For the rest I put everything but the JavaScript-to-Footer code in the functions.php file of the theme to get similar functionality.

Test this plugin out on your site before deciding if it will be the right solution for you. Normally I would create an options page to let you turn the JS-to-Footer feature off, but this plugin is all about speeding up your site, and that means minimal calls to the database, so unfortunately it would defeat the purpose of this plugin if I added the ability to change that.

If you don't want the JS to Footer feature, use [RS Head Cleaner Lite](https://wordpress.org/plugins/rs-head-cleaner-lite/ "RS Head Cleaner Lite"). It has all the same features except it won't move JavaScript to the footer.

= But I already have a caching Plugin installed...Why do I need CSS and JS caching? =

Caching plugins are awesome...in fact I recommend everyone use caching plugins. But it doesn't help speed up the CSS and JavaScript files downloading. It speeds up the actual PHP and database calls by creating static HTML files. If you have a lot of plugins and have 10 JS and 10 CSS files that have to download on every page, that can still bottleneck and slow your site down. This plugin will reduce those down to 1 JS and 1 CSS that have to be downloaded. Combined with a caching plugin, your site will be even faster.

= What if I Don't Want to Have My Page's CSS Files Cached? =

This plugin is built for speed. That's why it doesn't have an options page, because I didn't want it to have any database calls, which would slow it down. After a certain amount of database calls, you lose any speed improvements. Certain industry leading websites have found that for every 100 milliseconds (1/10th of a second) their site slowed down, they lost 1% in sales. Ouch.

This new feature is integral to the plugin, so the caching isn't a feature you want, then this plugin won't be the right match for you. It's designed for people that are very speed conscious, and want hardcore solutions.

= You do great work...can I hire you? =

Absolutely...go to my [WordPress Consulting](http://www.redsandmarketing.com/web-design/wordpress-consulting/ "WordPress Consulting") page for more information.

== Changelog ==

= 1.4.1 =
*released 07/10/15*

* Improved page load speed, and improved Google PageSpeed, Yahoo YSlow, and GTmetrix scores.
* Improved compatibility with certain themes and scripts.
* Improved handling of jQuery and Contact Form 7 scripts. This is one of the few minification plugins that handles these correctly.
* Added a second concatenated and minified JavaScript in the head to streamline scripts that cannot be moved to the footer without breaking functionality.

= 1.4 =
*released 06/27/15*

* Added a minimum required PHP version of 5.3, as we are no longer supporting PHP 5.2. The PHP team [stopped supporting PHP 5.2 back in 2011](http://php.net/archive/2011.php#id2011-08-23-1), and even PHP 5.3 reached its end of life in August 2014. WordPress has a current minimum requirement of 5.2.4, but PHP 5.4 is recommended - see the [WordPress requirements](https://wordpress.org/about/requirements/). It's extremely important that users stay up to date with the most recent version of WordPress (currently 4.1.1) and a reasonably up-to-date version of PHP for security, functionality, and website performance. (Not only are the newer versions more secure, but they are faster, so its a double win.) We recommend PHP 5.4 or higher, especially if you care about optimizing your site's speed. Also, see [PHP Unsupported Branches](http://php.net/eol.php) for more info.
* Modified the deactivation and uninstall functions to clean up the files in the old folder location as well.
* Fixed a bug where CSS & JS cache files were not being written in certain situations.

= 1.3.9 =
*released 06/26/15*

* Added gzip compression and far future Expires headers to concatenated CSS and JS files.
* Moved the plugin's cache folder into the `/wp-content/cache/` folder. New location is `/wp-content/cache/rshcp/`.
* Changed the cache file naming system to utilize a faster method.
* Fixed a bug with login/registration pages not loading scripts properly.

= 1.3.8 =
*released 06/20/15*

* Fixed a bug with the JavaScript and CSS compression.
* Added a feature to remove HTML comments and blank lines in the HTML code.

= 1.3.7 =
*released 04/22/15*

* Fixed some bugs with the JavaScript and CSS compression.
* Added an `.htaccess` file to the `rs-head-cleaner` directory to control browser access to certain files.
* Increased minimum required WordPress version to 3.8.
* Made various code improvements.

= 1.3.6 =
*released 03/06/15*

* Made various minor code improvements.

= 1.3.5 =
*released 03/03/15*

* Added a function that will clear the JavaScript & CSS cache files each time the plugin is deactivated manually through the dashboard (but not on automatic or bulk plugin upgrades). If you would like to manually clear the cache, simply deactivate and reactivate the plugin. (If you're using a page caching plugin, just be sure to also clear that plugin's cache as well at the same time to prevent related issues.)
* Fixed a minor bug in the uninstall function.

= 1.3.4 =
*released 03/01/15*

* Added an uninstall function that completely uninstalls the plugin and removes all cache files, options, data, and traces of its existence when it is deleted through the dashboard.
* Added a minor JavaScript compatibility fix for Twenty Fourteen and similar themes.

= 1.3.3 =
*released 01/19/15*

* Fixed a minor bug.
* Increased minimum required WordPress version to 3.7.

= 1.3.2 =
*released 12/18/14*

* Added additional security checks.
* Various code improvements.
* Fixed a bug that caused the plugin to attempt to cache web font files.

= 1.3.1 =
*released 07/12/14*

* Added additional security checks.
* Fixed a minor bug.

= 1.3 =
*released 07/03/14*

* Added the Combine/Minify/Cache CSS & JavaScript feature.

= 1.1.1 =
*released 06/17/14*

* Updated some features.

= 1.1.0.3 =
*released 04/28/14*

* Fixed a bug that caused an error message on certain server configurations.

= 1.1.0.2 =
*released 04/13/14*

* Added additional security checks.

= 1.1.0.1 =
*released 04/04/14*

* Minor code improvements.

= 1.1 =
*released 03/26/14*

* Added feature to remove version numbers from CSS and JS links in the HEAD.

= 1.0 =
*released 03/17/14*

* Initial release.

== Upgrade Notice ==
= 1.4.1 =
* Improved page load speed, improved Google PageSpeed, Yahoo YSlow, and GTmetrix scores, improved compatibility, and improved handling of jQuery and Contact Form 7 scripts. Please see Changelog for details.
