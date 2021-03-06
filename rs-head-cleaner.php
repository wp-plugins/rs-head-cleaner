<?php
/*
Plugin Name: RS Head Cleaner Plus
Plugin URI: http://www.redsandmarketing.com/plugins/rs-head-cleaner/
Description: This plugin cleans up a number of issues, doing the work of multiple plugins, improving speed, efficiency, security, SEO, and user experience. It removes junk code from the document HEAD & HTTP headers, hides the WP Version, moves JavaScript from header to footer, Combines/Minifies/Caches CSS and JavaScript files, removes version numbers from CSS and JS links, removes HTML comments, and fixes the "Read more" link so it displays the entire post.
Author: Scott Allen
Version: 1.4.1
Author URI: http://www.redsandmarketing.com/
Text Domain: rs-head-cleaner
License: GPLv2
*/

/*  Copyright 2014    Scott Allen  (email : plugins [at] redsandmarketing [dot] com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// PLUGIN - BEGIN

/* Note to any other PHP developers reading this:
My use of the closing curly braces "}" is a little funky in that I indent them, I know. IMO it's easier to debug. Just know that it's on purpose even though it's not standard. One of my programming quirks, and just how I roll. :)
*/

/* Make sure plugin remains secure if called directly */
if ( !defined( 'ABSPATH' ) ) {
	if ( !headers_sent() ) { header('HTTP/1.1 403 Forbidden'); }
	die( 'ERROR: This plugin requires WordPress and will not function if called directly.' );
	}

/* BENCHMARK - BEGIN */
//$start_time = rshcp_microtime();

define( 'RSHCP_VERSION', '1.4.1' );
define( 'RSHCP_REQUIRED_WP_VERSION', '3.8' );
define( 'RSHCP_REQUIRED_PHP_VERSION', '5.3' );

if ( !defined( 'RSHCP_DEBUG' ) ) 				{ define( 'RSHCP_DEBUG', FALSE ); } // Do not change value unless developer asks you to - for debugging only. Change in wp-config.php.
if ( !defined( 'RSMP_SITE_URL' ) ) 				{ define( 'RSMP_SITE_URL', untrailingslashit( site_url() ) ); }
if ( !defined( 'RSMP_SITE_DOMAIN' ) ) 			{ define( 'RSMP_SITE_DOMAIN', rshcp_get_domain( RSMP_SITE_URL ) ); }
if ( !defined( 'RSHCP_PLUGIN_BASENAME' ) ) 		{ define( 'RSHCP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); }
if ( !defined( 'RSHCP_PLUGIN_FILE_BASENAME' ) ) { define( 'RSHCP_PLUGIN_FILE_BASENAME', trim( basename( __FILE__ ), '/' ) ); }
if ( !defined( 'RSHCP_PLUGIN_NAME' ) ) 			{ define( 'RSHCP_PLUGIN_NAME', trim( dirname( RSHCP_PLUGIN_BASENAME ), '/' ) ); }
if ( !defined( 'RSHCP_PLUGIN_PATH' ) ) 			{ define( 'RSHCP_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/' ); }

if ( !defined( 'RSHC_REMOVE_OPEN_SANS' ) ) 		{ define( 'RSHC_REMOVE_OPEN_SANS', FALSE ); } // Change in wp-config.php
// By default this feature is off, but if you don't need Open Sans and you want a faster site, add a line in your wp-config.php that says: "define( 'RSHC_REMOVE_OPEN_SANS', TRUE );"
// RSHC_REMOVE_OPEN_SANS is a shared constant with RSHCL.
// Constants prefixed with 'RSMP_' are shared with other RSM Plugins for efficiency. Any of these values can be changed in wp-config.php:
if ( !defined( 'RSHCP_CACHE_DIR_NAME' ) ) 		{ define( 'RSHCP_CACHE_DIR_NAME', 'rshcp' ); }
if ( !defined( 'RSHCP_CACHE_PATH' ) ) 			{ define( 'RSHCP_CACHE_PATH', WP_CONTENT_DIR.'/cache/'.RSHCP_CACHE_DIR_NAME.'/' ); }
if ( !defined( 'RSHCP_JS_PATH' ) ) 				{ define( 'RSHCP_JS_PATH', RSHCP_CACHE_PATH.'js/' ); }
if ( !defined( 'RSHCP_CSS_PATH' ) ) 			{ define( 'RSHCP_CSS_PATH', RSHCP_CACHE_PATH.'css/' ); }
if ( !defined( 'RSHCP_CACHE_URL' ) ) 			{ define( 'RSHCP_CACHE_URL', WP_CONTENT_URL.'/cache/'.RSHCP_CACHE_DIR_NAME.'/' ); }
if ( !defined( 'RSHCP_JS_URL' ) ) 				{ define( 'RSHCP_JS_URL', RSHCP_CACHE_URL.'js/' ); }
if ( !defined( 'RSHCP_CSS_URL' ) ) 				{ define( 'RSHCP_CSS_URL', RSHCP_CACHE_URL.'css/' ); }
if ( !defined( 'RSMP_CONTENT_DIR_URL' ) ) 		{ define( 'RSMP_CONTENT_DIR_URL', WP_CONTENT_URL ); }
if ( !defined( 'RSMP_CONTENT_DIR_PATH' ) ) 		{ define( 'RSMP_CONTENT_DIR_PATH', WP_CONTENT_DIR ); }
if ( !defined( 'RSMP_PLUGINS_DIR_URL' ) ) 		{ define( 'RSMP_PLUGINS_DIR_URL', WP_PLUGIN_URL ); }
if ( !defined( 'RSMP_PLUGINS_DIR_PATH' ) ) 		{ define( 'RSMP_PLUGINS_DIR_PATH', WP_PLUGIN_DIR ); }
if ( !defined( 'RSHCP_SERVER_ADDR' ) ) 			{ define( 'RSHCP_SERVER_ADDR', rshcp_get_server_addr() ); }
if ( !defined( 'RSHCP_SERVER_NAME' ) ) 			{ define( 'RSHCP_SERVER_NAME', rshcp_get_server_name() ); }
if ( !defined( 'RSHCP_SERVER_NAME_REV' ) ) 		{ define( 'RSHCP_SERVER_NAME_REV', strrev( RSHCP_SERVER_NAME ) ); }
if ( !defined( 'RSMP_DEBUG_SERVER_NAME' ) ) 	{ define( 'RSMP_DEBUG_SERVER_NAME', '.redsandmarketing.com' ); }
if ( !defined( 'RSMP_DEBUG_SERVER_NAME_REV' ) )	{ define( 'RSMP_DEBUG_SERVER_NAME_REV', strrev( RSMP_DEBUG_SERVER_NAME ) ); }
if ( !defined( 'RSMP_RSM_URL' ) ) 				{ define( 'RSMP_RSM_URL', 'http://www.redsandmarketing.com/' ); }
if ( !defined( 'RSHCP_HOME_URL' ) ) 			{ define( 'RSHCP_HOME_URL', RSMP_RSM_URL.'plugins/rs-head-cleaner/' ); }
if ( !defined( 'RSHCP_WP_URL' ) ) 				{ define( 'RSHCP_WP_URL', 'http://wordpress.org/extend/plugins/rs-head-cleaner/' ); }
if ( !defined( 'RSHCP_PHP_VERSION' ) ) 			{ define( 'RSHCP_PHP_VERSION', PHP_VERSION ); }
if ( !defined( 'RSHCP_WP_VERSION' ) ) 			{ global $wp_version; define( 'RSHCP_WP_VERSION', $wp_version ); }

if ( strpos( RSHCP_SERVER_NAME_REV, RSMP_DEBUG_SERVER_NAME_REV ) !== 0 && RSHCP_SERVER_ADDR != '127.0.0.1' && TRUE !== RSHCP_DEBUG && TRUE !== WP_DEBUG ) {
	error_reporting(0); // Prevents error display on production sites, but testing on 127.0.0.1 will display errors, or if debug mode turned on
	}

/* SET ADVANCED OPTIONS - Change be overridden in wp-config.php. Advanced users only. */
if ( !defined( 'RSHCP_NO_MINIFY_ALL' ) ) 		{ define( 'RSHCP_NO_MINIFY_ALL', FALSE ); }
if ( !defined( 'RSHCP_NO_MINIFY_CSS' ) ) 		{ define( 'RSHCP_NO_MINIFY_CSS', FALSE ); }
if ( !defined( 'RSHCP_NO_MINIFY_JS' ) ) 		{ define( 'RSHCP_NO_MINIFY_JS', FALSE ); }

// Adds features, cleans up WP code, and eliminates need for multiple plugins:
	// - Hide WP Generator 				- Security
	// - Removes CSS/JS Versions 		- Security, Speed, Code Validation - Speed: Allows browser to cache JS and CSS files when they don't have arguments appended to URL
	// - Adds Defer & Async to JS		- For Speed in page loading - Adds defer="defer" and async="async" to all JS except Jquery & Theme JS to speed up page loading
	// - Fixes "More" link				- Fixes "More" link so you see the whole post when you click, not just the part after the "more"
	// - Removes Open Sans				- (Optional) Removes the Open Sans from WordPress to speed up your site by removing the call to Google Fonts Library
	// - Remove CF7 JS/CSS				- Remove Contact Form 7 JS/CSS on pages/post where shortcode isn't used (it only needs to be on pages that actually use it)
	// - Combine, Minify & Cache JS/CSS	- Combine all properly registered/queued JS & CSS into one file, minify, and cache these new single files. Fixes CSS image URL locations too. CSS stays in Header, JS will be moved to footer.
	// - JavaScript to Footer 			- For Speed in page loading - Part of the Combine, Minify, and Cache
	// - Head Cleaner					- Removes the following from the head section for SEO, security, and speed: RSD Link, Windows Live Writer Manifest Link, WordPress Shortlinks, and Adjacent Posts links (Prev/Next), HTML Comments

// CLEANUP HEADER CODE - BEGIN
remove_action ('wp_head', 'rsd_link');
	// Remove RSD Link - If you edit blog through browser, then it is not needed.
	
remove_action( 'wp_head', 'wlwmanifest_link');
	// Remove Windows Live Writer Manifest Link...similar deal
	
remove_action( 'wp_head', 'wp_shortlink_wp_head');
	// Remove WordPress Shortlinks from WP HEAD - WP implements it incorrectly, Bad for SEO, and it adds ugly code
	
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
	// Remove WordPress Shortlinks from HTTP Headers
	
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// Remove REL = PREV/NEXT
	// WP incorrectly implements this - supposed to fix pagination issues but it messes up
	// Use All in One SEO Pack - it handles proper implementation of this well, on paginated pages/posts

remove_action('wp_head', 'wp_generator');
	// Remove WP Generator/Version - for security reasons

// Remove version numbers from CSS and JS in HEAD
function rshcp_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) { $src = remove_query_arg( 'ver', $src ); }
	return $src;
	}
add_filter( 'style_loader_src', 'rshcp_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'rshcp_remove_wp_ver_css_js', 9999 );

// Remove HTML Comments
function rshcp_remove_html_comments( $buffer ) {
	$rgx	= '~<!--(.|s)*?-->~';
	$func	= 'rshcp_replace_comments';
    $buffer = preg_replace_callback( $rgx, $func, $buffer );
    $buffer = preg_replace( "~\n\s+\n~", "\n", $buffer );
    $buffer = preg_replace( "~\n{2,}~", "\n", $buffer );
    return $buffer;
	}
function rshcp_replace_comments( $s ) {
	list( $l ) = $s;
	if ( preg_match( "~\!?\[(end)?if~iu", $l ) ) { return $l; }
	return '';
	}
function rshcp_buffer_start() {
    ob_start('rshcp_remove_html_comments');
	}
function rshcp_buffer_end() {
	ob_end_flush();
	}
add_action('get_header', 'rshcp_buffer_start', 9999);
add_action('wp_footer', 'rshcp_buffer_end', 9999);
// CLEANUP HEADER CODE - END

// IMPROVE USER EXPERIENCE - BEGIN
// Change the "Read more" link so it displays the entire post, not just the part after the "#more"
function rshcp_remove_more($content) {
	global $id;
	return str_replace('#more-'.$id.'"', '"', $content);
	}
add_filter('the_content', 'rshcp_remove_more');
// IMPROVE USER EXPERIENCE - END

// SPEED UP WORDPRESS - BEGIN
// Add Defer & Async to Scripts
function rshcp_defer_async_js( $url ) {
	if ( is_admin() ) { return $url; } // Skip if in WP Admin
	$slug			= rshcp_get_slug();
	$min_slug		= 'rsm-min-js-'.$slug;
	$min_file_slug	= $min_slug.'.js';
	$js_url			= RSHCP_JS_URL.$min_file_slug;
    if ( FALSE === strpos( $url, '.js' ) ) { return $url; } // Skip non-JS
    if ( FALSE !== strpos( $url, $js_url ) ) { return $url; }
    if ( strpos( $url, 'jquery.js' ) || strpos( $url, '/jquery' ) || strpos( $url, '/masonry' ) || strpos( $url, '/themes/' ) ) { return $url; } // Skip jquery and theme related JS
	$new_url = "$url' async='async' defer='defer";
    return $new_url;
	}
add_filter( 'clean_url', 'rshcp_defer_async_js', 9999, 1 );
// Remove Open Sans to Speed Page Loading - Only for Admin area, must change wp-config.php setting
function rshcp_remove_opensans() {
	if ( is_admin() && FALSE != RSHC_REMOVE_OPEN_SANS ) {
		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', FALSE );
		wp_enqueue_style( 'open-sans', '' );
		}
	}
add_action( 'admin_init', 'rshcp_remove_opensans', 9999 );
// Remove Contact Form 7 JS/CSS on pages/posts where shortcode isn't used
function rshcp_remove_cf7_css_js() {
	global $post;
	if ( is_object( $post ) ) {
		if ( ! has_shortcode( $post->post_content, 'contact-form-7' ) ) {
			remove_action('wp_enqueue_scripts', 'wpcf7_enqueue_styles');
			remove_action('wp_enqueue_scripts', 'wpcf7_enqueue_scripts');
			}
		}
	}
if ( defined( 'WPCF7_VERSION' ) ) {
	add_action( 'wp', 'rshcp_remove_cf7_css_js');
	}
// Combine all JS and CSS, Minify, Cache and Serve one file. CSS stays in Header, JS will be moved to footer.
if ( ! has_action( 'login_enqueue_scripts', 'wp_print_styles' ) ) {
	add_action( 'login_enqueue_scripts', 'wp_print_styles', 11 );
	}
function rshcp_simple_minifier_css( $css_to_minify, $filter = TRUE ) {
	if( empty( $filter ) ) { return $css_to_minify; }
	$css_buffer 	= $css_to_minify;
	// Replace all newlines with \n
	$css_buffer 	= str_replace( array( "\r\n","\r","\n","\f","\v" ), array( "\n","\n","\n","\n","\n" ), $css_buffer );
	// Remove comments
	$css_buffer 	= preg_replace( "~(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)~", '', $css_buffer );
	$css_buffer 	= preg_replace( "~(?:(?![\/a-zA-Z0-9]+)[\n\t\ ]*\/\/.*\n)~", "\n", $css_buffer );
	$css_buffer 	= preg_replace( "~(?:(?![\/a-zA-Z0-9]+)([;\{\}]*)\/\/.*\n)~", "$1", $css_buffer );
	// Trim lines
	$css_buffer 	= preg_replace( "~(?:\ *\n\ *)~", "\n", $css_buffer );
	// Remove tabs, spaces, etc.
	$css_buffer 	= str_replace( array( "\t",'  ','   ','    ','     ' ), '', $css_buffer );
	// Remove spaces after {},;:
	$css_buffer 	= str_replace( array( '{ ',' }',' {','} ',', ','; ',' : ',': ' ), array( '{','}','{','}',',',';',':',':' ), $css_buffer );
	// Remove tabs, spaces, newlines, etc.
	$css_buffer 	= preg_replace( "~\n{2,}~", "\n", $css_buffer );
	$css_buffer 	= str_replace( array( "{\n","\n}","\n{","}\n",",\n",";\n" ), array( '{','}','{','}',',',';' ), $css_buffer );
	// Add more rules - BEGIN
	$css_buffer 	= preg_replace( "~\s+,~", ",", $css_buffer );

	// Add more rules - END
	$css_minified	= trim( $css_buffer );
	return $css_minified;
    }
function rshcp_simple_minifier_js( $js_to_minify, $filter = TRUE ) {
	if( empty( $filter ) ) { return $js_to_minify; }
	$js_buffer		= $js_to_minify;
	// These aren't all done at once because order of steps is important
	// Replace all newlines with \n
	$js_buffer 		= str_replace( array( "\r\n","\r","\n","\f","\v" ), array( "\n","\n","\n","\n","\n" ), $js_buffer );
	// Remove comments
	$js_buffer 		= preg_replace( "~(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)~", '', $js_buffer );
	$js_buffer 		= preg_replace( "~(?:(?![\/a-zA-Z0-9]+)[\n\t\ ]*\/\/.*\n)~", "\n", $js_buffer );
	$js_buffer 		= preg_replace( "~(?:(?![\/a-zA-Z0-9]+)([;\{\}]*)\/\/.*\n)~", "$1", $js_buffer );
	// Trim lines
	$js_buffer 		= preg_replace( "~(?:\ *\n\ *)~", "\n", $js_buffer );
	$js_buffer 		= str_replace( array( " \\\n", " \\ \n" ), array( '', '' ), $js_buffer );
	// Remove spaces around JS operators: - + * ? % || && = == != < > <= >=
	$js_buffer 		= str_replace( array(' - ',' + ',' * ',' / ',' ? ',' % ',' || ',' && ',' = ',' != ',' == ',' === ',' < ',' > ',' <= ',' >= ' ), array( '-','+','*','/','?','%','||','&&','=','!=','==','===','<','>','<=','>=' ), $js_buffer );
	// Remove tabs, spaces, etc.
	$js_buffer 		= str_replace( array( "\t",'  ','   ','    ','     ' ), '', $js_buffer );
	// Remove spaces after {}[](),;:
	$js_buffer 		= str_replace( array( '{ ',' }',' {','} ','[ ',' ]','( ',' )',' (',') ',', ','; ',' : ',': ' ), array( '{','}','{','}','[',']','(',')','(',')',',',';',':',':' ), $js_buffer );
	// Remove tabs, spaces, newlines, etc.
	$js_buffer 		= str_replace( array( " \\\n", " \\ \n" ), array( '', '' ), $js_buffer );
	$js_buffer 		= preg_replace( "~\n{2,}~", "\n", $js_buffer );
	$js_buffer 		= str_replace( array( "{\n","\n}","[\n","\n]" ), array( '{','}','[',']' ), $js_buffer );
	$js_buffer 		= str_replace( array( ",\n",":\n",";\n","&\n","=\n","+\n","-\n","?\n","}\\\n"," } \\ \n" ), array( ',',':',';','&','=','+','-','?','}','}' ), $js_buffer );
	// Add more rules - BEGIN
	
	// Add more rules - END
	$js_minified	= trim( $js_buffer );
	return $js_minified;
    }
function rshcp_get_slug() {
	$url = rshcp_get_url();
	return rshcp_md5( $url );
	}
function rshcp_strlen( $string ) {
	/***
	* Use this function instead of mb_strlen because some servers (often IIS) have mb_ functions disabled by default
	* BUT mb_strlen is superior to strlen, so use it whenever possible
	***/
	if ( function_exists( 'mb_strlen' ) ) { $num_chars = mb_strlen($string, 'UTF-8'); } else { $num_chars = strlen($string); }
	return $num_chars;
	}
add_action('init', 'rshcp_cache_combine_js_css');
function rshcp_cache_combine_js_css() {
	if ( !is_admin() && !is_user_logged_in() ) {
		foreach ( array( 'wp_enqueue_scripts', 'login_enqueue_scripts' ) as $a ) { foreach ( array( -999 => 'styles', 9999 => 'scripts' ) as $p => $b ) { add_action( $a, 'rshcp_enqueue_'.$b, $p ); } }
		add_action( 'wp_print_styles', 'rshcp_inspect_styles', 9999 );
		foreach ( array( 'wp_print_scripts', 'wp_print_head_scripts' ) as $a ) { add_action( $a, 'rshcp_inspect_scripts', 9999 ); }
		foreach ( array( 'wp_head', 'login_head' ) as $a ) { add_action( $a, 'rshcp_insert_head_js', 10 ); }
		}
	}
function rshcp_enqueue_styles() {
	global $rshcp_css_null,$wp_styles;
	if ( !empty( $rshcp_css_null ) ) { return; }
	$slug			= rshcp_get_slug();
	$min_slug		= 'rsm-min-css-'.$slug;
	$min_file_slug	= $min_slug.'.css';
	$css_url		= RSHCP_CSS_URL.$min_file_slug;
	$deps 			= array();
	if ( is_object( $wp_styles ) ) {
		foreach( $wp_styles->queue as $handle ) {
			$style_deps = (array)$wp_styles->registered[$handle]->deps;
			/* Keep an eye out for potential issues */
			if ( !empty( $style_deps ) ) { $deps = array_merge( $deps, $style_deps ); }
			}
		$deps = rshcp_sort_unique( $deps );
		foreach( $wp_styles->queue as $handle ) {
			if ( in_array( $handle, $deps, TRUE ) ) {
				$key = array_search( $handle, $deps );
				unset( $deps[$key] );
				}
			}
		}
	if ( TRUE === RSHCP_NO_MINIFY_ALL || TRUE === RSHCP_NO_MINIFY_CSS ) { $css_url = str_replace( '-min-', '-raw-', $css_url ); }
	wp_register_style( $min_slug, $css_url, $deps, RSHCP_VERSION );
	wp_enqueue_style( $min_slug );
	}
function rshcp_enqueue_scripts() {
	global $rshcp_js_null,$wp_scripts;
	if ( TRUE === $rshcp_js_null ) { return; }
	$slug			= rshcp_get_slug();
	$min_slug		= 'rsm-min-js-'.$slug;
	$min_file_slug	= $min_slug.'.js';
	$js_url			= RSHCP_JS_URL.$min_file_slug;
	$deps			= array();
	if ( is_object( $wp_scripts ) ) {
		foreach( $wp_scripts->queue as $handle ) {
			$script_deps = (array)$wp_scripts->registered[$handle]->deps;
			/* Keep an eye out for potential issues */
			if ( !empty( $script_deps ) ) { $deps = array_merge( $deps, $script_deps ); }
			}
		$deps = rshcp_sort_unique( $deps );
		foreach( $wp_scripts->queue as $handle ) {
			if ( in_array( $handle, $deps, TRUE ) ) {
				$key = array_search( $handle, $deps );
				unset( $deps[$key] );
				}
			}
		}
	if ( TRUE === RSHCP_NO_MINIFY_ALL || TRUE === RSHCP_NO_MINIFY_JS ) { $js_url = str_replace( '-min-', '-raw-', $js_url ); }
	wp_register_script( $min_slug, $js_url, $deps, RSHCP_VERSION, TRUE );
	wp_enqueue_script( $min_slug );
	}
function rshcp_insert_head_js() {
	global $rshcp_js_h_null;
	if ( TRUE === $rshcp_js_h_null ) { return; }
	if ( !is_admin() && !is_user_logged_in() ) {
		$slug			= rshcp_get_slug();
		$min_slug		= 'rsm-min-js-h'.$slug;
		$min_file_slug	= $min_slug.'.js';
		$js_h_url		= RSHCP_JS_URL.$min_file_slug;
		if ( TRUE === RSHCP_NO_MINIFY_ALL || TRUE === RSHCP_NO_MINIFY_JS ) { $js_h_url = str_replace( '-min-', '-raw-', $js_h_url ); }
		echo "\n"."<script type='text/javascript' src='".$js_h_url."'></script>"."\n";
		}
	}
function rshcp_inspect_scripts( $head_scripts = NULL ) {
	global $rshcp_js_run,$wp_scripts,$rshcp_js_h_null,$rshcp_js_null;
	if ( !empty( $rshcp_js_run ) ) { return; }
	$slug 	= rshcp_get_slug();
	$url 	= rshcp_get_url();
	$domain	= rshcp_get_domain( $url );
	$h		= !empty( $head_scripts ) ? 'h' : '';
	$raw_slug = 'rsm-raw-js-'.$h.$slug;
	$min_slug = 'rsm-min-js-'.$h.$slug;
	$raw_file_slug = $raw_slug.'.js';
	$min_file_slug = $min_slug.'.js';
	$raw_js_file = RSHCP_JS_PATH.$raw_file_slug;
	$min_js_file = RSHCP_JS_PATH.$min_file_slug;
	$script_handles = array();
	$script_srcs 	= array();
	//$deps 		= array(); // TO DO
	$combined_js 	= array();
	$http_pref		= rshcp_is_https() ? 'https://' : 'http://';
	if ( empty( $head_scripts ) && defined( 'WPCF7_VERSION' ) && wp_script_is( 'jquery-form', 'enqueued' ) ) {
		$handle				= 'jquery-form';
		$script_src			= $script_src_path = WPCF7_PLUGIN_URL.'/includes/js/jquery.form.min.js';
		$script_domain		= $domain;
		$script_src_rev		= rshcp_fix_url( $script_src, TRUE, TRUE, TRUE );
		if ( strpos( $script_src_path, '//' ) === 0 ) { $script_src_path = str_replace( '//', $http_pref, $script_src_path ); }
		$script_src_path	= str_replace( RSMP_CONTENT_DIR_URL, RSMP_CONTENT_DIR_PATH, $script_src_path );
		$js_buffer			= file_get_contents( $script_src_path );
		if ( !empty( $js_buffer ) ) {
			$c = '';
			$_wpcf7 = array( 'loaderUrl' => wpcf7_ajax_loader(), 'sending' => __( 'Sending ...', 'contact-form-7' ) ); 
			if ( defined( 'WP_CACHE' ) && WP_CACHE ) { $_wpcf7['cached'] = 1; $c = ',"cached":"1"'; }
			if ( wpcf7_support_html5_fallback() ) { $_wpcf7['jqueryUi'] = 1; }
			$js_buffer			.= "\n".'var _wpcf7 = {"loaderUrl":"'.str_replace( '/', '\/', WPCF7_PLUGIN_URL ).'\/images\/ajax-loader.gif","sending":"'.__( 'Sending ...', 'contact-form-7' ).'"'.$c.'};'."\n";
			$script_handles[]	 = $handle;
			$script_srcs[]		 = $script_src;
			$combined_js[] 		 = $js_buffer;
			}
		unset ( $js_buffer );
		wp_dequeue_script( $handle );
		wp_deregister_script( $handle );
		wp_register_script( $handle, NULL, FALSE, NULL, TRUE);
		wp_enqueue_script( $handle );
		}
	if ( !empty( $head_scripts ) ) {
		foreach( $head_scripts as $handle => $a ) {
			$script_src			= $script_src_path = $a['src'];
			$script_domain		= rshcp_get_domain( $script_src );
			if( empty( $script_src ) || $handle == $min_slug || $script_domain != $domain ) { continue; }
			$script_src_rev		= rshcp_fix_url( $script_src, TRUE, TRUE, TRUE );
			if ( strpos( $script_src_rev, 'sj.' ) !== 0 ) { continue; } // Not JS
			if ( strpos( $script_src_path, '//' ) === 0 ) { $script_src_path = str_replace( '//', $http_pref, $script_src_path ); }
			$script_src_path	= str_replace( RSMP_CONTENT_DIR_URL, RSMP_CONTENT_DIR_PATH, $script_src_path );
			$js_buffer			= file_get_contents( $script_src_path );
			if ( empty( $js_buffer ) ) { continue; }
			$script_handles[] 	= $handle;
			$script_srcs[] 		= $script_src;
			$combined_js[] 		= $js_buffer;
			unset ( $js_buffer );
			wp_dequeue_script( $handle );
			wp_deregister_script( $handle );
			}
		if ( !empty( $combined_js ) ) {
			$rshcp_js_h_null = FALSE;
			unset( $head_scripts );
			remove_action( 'rshcp_inspect_scripts_head', 'rshcp_inspect_scripts' );
			}
		}
	elseif ( !empty( $wp_scripts ) && is_object( $wp_scripts ) ) {
		$rshcp_js_h_null = TRUE;
		$head_scripts = array();
		foreach( $wp_scripts->queue as $handle ) {
			$script_src			= $script_src_path = $wp_scripts->registered[$handle]->src;
			//$script_deps 		= (array)$wp_scripts->registered[$handle]->deps; // TO DO
			$script_domain		= rshcp_get_domain( $script_src );
			if( empty( $script_src ) || $handle == $min_slug || $script_domain != $domain ) { continue; }
			$script_src_rev		= rshcp_fix_url( $script_src, TRUE, TRUE, TRUE );
			if ( strpos( $script_src_rev, 'sj.' ) !== 0 ) { continue; } // Not JS
			if ( strpos( $script_src_path, '//' ) === 0 ) { $script_src_path = str_replace( '//', $http_pref, $script_src_path ); }
			$script_src_path	= str_replace( RSMP_CONTENT_DIR_URL, RSMP_CONTENT_DIR_PATH, $script_src_path );
			$js_buffer			= file_get_contents( $script_src_path );
			if ( empty( $js_buffer ) ) { continue; }
			/***
			* Helps with compatibility when async and defer are being used
			* $js_buffer			= str_replace( array( '(function($)', '( function( $ )', 'jQuery(document).readyjQuery(document).ready(function($)' ), 'jQuery(document).ready(function($)', $js_buffer );
			* $js_buffer			= str_replace( array( '(jQuery)', '( jQuery )', '(jquery)', '( jquery )' ), '', $js_buffer );
			***/
			$script_handles[] 	= $handle;
			$script_srcs[] 		= $script_src;
			$combined_js[] 		= $js_buffer;
			unset ( $js_buffer );
			wp_dequeue_script( $handle );
			wp_deregister_script( $handle );
			}
		if ( !rshcp_is_login_page() && wp_script_is( 'jquery', 'enqueued' ) ) {
			$hs_rev = array_reverse( $head_scripts );
			$hs_rev['jquery-migrate'] = array( 'handle' => 'jquery-migrate', 'src' => RSMP_SITE_URL.'/wp-includes/js/jquery/jquery-migrate.min.js' );
			$hs_rev['jquery-core'] = array( 'handle' => 'jquery-core', 'src' => RSMP_SITE_URL.'/wp-includes/js/jquery/jquery.js' );
			$head_scripts = array_reverse( $hs_rev );
			wp_dequeue_script( 'jquery' );
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', NULL, FALSE, NULL, TRUE);
			wp_enqueue_script( 'jquery' );
			}
		if( !empty( $head_scripts ) ) { add_action( 'rshcp_inspect_scripts_head', 'rshcp_inspect_scripts', 1 ); }
		} else { $rshcp_js_null = TRUE; return; }
	$combined_js_contents_raw	= implode( "\n", $combined_js );
	$combined_js_contents_len	= rshcp_strlen( $combined_js_contents_raw );
	$combined_js_contents		= rshcp_simple_minifier_js( $combined_js_contents_raw );
	$plugin_file_mod_time		= filemtime( __FILE__ );
	if ( file_exists( $raw_js_file ) ) {
		$raw_js_file_mod_time	= filemtime( $raw_js_file );
		$raw_js_file_filesize	= filesize( $raw_js_file );
		}
	else {
		$raw_js_file_mod_time	= FALSE;
		$raw_js_file_filesize	= FALSE;
		}
	$js_cache_time = time() - 86400; // 60 * 60 * 1 - Sec * Min * Hour; 3600 = 1 Hour; 86400 = 24 Hours;
	if ( !empty( $combined_js_contents_len ) ) {
		if ( $raw_js_file_filesize != $combined_js_contents_len || $raw_js_file_mod_time < $plugin_file_mod_time || $raw_js_file_mod_time < $js_cache_time || FALSE === $raw_js_file_mod_time ) {
			rshcp_write_cache_file( $raw_js_file, $combined_js_contents_raw );
			rshcp_write_cache_file( $min_js_file, $combined_js_contents );
			}
		}
	else { $rshcp_js_null = TRUE; }
	if( !empty( $head_scripts ) ) { do_action( 'rshcp_inspect_scripts_head', $head_scripts ); }
	$rshcp_js_run = TRUE;
	}
function rshcp_inspect_styles() {
	global $rshcp_css_run,$wp_styles,$rshcp_css_null;
	if ( !empty( $rshcp_css_run ) ) { return; }
	$slug			= rshcp_get_slug();
	$url			= rshcp_get_url();
	$domain			= rshcp_get_domain( $url );
	$raw_slug		= 'rsm-raw-css-'.$slug;
	$min_slug		= 'rsm-min-css-'.$slug;
	$raw_file_slug	= $raw_slug.'.css';
	$min_file_slug	= $min_slug.'.css';
	$raw_css_file	= RSHCP_CSS_PATH.$raw_file_slug;
	$min_css_file	= RSHCP_CSS_PATH.$min_file_slug;
	$style_handles 	= array();
	$style_srcs 	= array();
	//$deps 		= array(); // TO DO
	$combined_css 	= array();
	$http_pref		= rshcp_is_https() ? 'https://' : 'http://';
	if ( is_object( $wp_styles ) ) {
		foreach( $wp_styles->queue as $handle ) {
			$style_src			= $style_src_path = $wp_styles->registered[$handle]->src;
			//$style_deps 		= (array)$wp_styles->registered[$handle]->deps; // TO DO
			$style_domain		= rshcp_get_domain( $style_src );
			if( empty( $style_src ) || $handle == $min_slug || $style_domain != $domain ) { continue; } // || strpos( $style_src, '/themes/' )
			$style_src_rev		= rshcp_fix_url( $style_src, TRUE, TRUE, TRUE );
			if ( strpos( $style_src_rev, 'ssc.' ) !== 0 ) { continue; } // Not CSS
			$handle_rgx			= preg_quote( $handle );
			if ( strpos( $style_src_path, '//' ) === 0 ) { $style_src_path = str_replace( '//', $http_pref, $style_src_path ); }
			$style_src_path		= str_replace( RSMP_CONTENT_DIR_URL, RSMP_CONTENT_DIR_PATH, $style_src_path );
			// Get the absolute URL to replace relative URLs in CSS since we're moving location of CSS file
			$css_buffer 		= file_get_contents( $style_src_path );
			if ( empty( $css_buffer ) ) { continue; }
			$style_handles[] 	= $handle;
			$style_srcs[] 		= $style_src;
			$style_src_no_http	= preg_replace( "~https?\://~i", '', $style_src );
			$url_buffer 		= explode( '/', $style_src_no_http );
			$url_elements		= count( $url_buffer ) - 1;
			unset( $url_buffer[$url_elements] );
			--$url_elements;
			if( preg_match_all( "~(url\('?(?:\.?/)?([a-z0-9/\-_]+\.[a-z]{2,4}(#[a-z0-9]+)?)'?\))~i", $css_buffer, $matches ) ) {
				$new_url_base = implode( '/', $url_buffer );
				$css_buffer = preg_replace( "~url\('?\.?/?([a-z0-9/\-_]+\.[a-z]{2,4}(#[a-z0-9]+)?)'?\)~i", "url('".'//'.$new_url_base."/$1')", $css_buffer );
				}
			if ( preg_match_all( "~(url\('?(?:\.\./)+(?:[a-z0-9/\-_]+\.[a-z]{2,4}(#[a-z0-9]+)?)'?\))~i", $css_buffer, $matches ) ) {
				$show_matches = array();
				foreach( $matches[1] as $m => $match ) {
					$url_buffer_m = $url_buffer;
					// Number of directories down
					$num_dirs_down	= substr_count( $match, '../' );
					//URL Elements Reduced
					$url_elements_red = $url_elements - $num_dirs_down;
					// Removing last element(s) of array is how we go down one or more directories
					$i = $url_elements;
					while( $i > $url_elements_red ) { unset( $url_buffer_m[$i] ); $i--; }
					$new_url_base 	= implode( '/', $url_buffer_m );
					$m_buffer 		= $match;
					$m_buffer 		= preg_replace( "~url\('?(?:\.\./)+([a-z0-9/\-_]+\.[a-z]{2,4}(#[a-z0-9]+)?)'?\)~i", "url('".'//'.$new_url_base."/$1')", $m_buffer );
					$match_rgx 		= preg_quote( $match );
					$css_buffer 	= preg_replace( "~$match_rgx~i", $m_buffer, $css_buffer, -1, $count );
					}
				}
			$combined_css[] = $css_buffer;
			unset ( $css_buffer );
			wp_dequeue_style( $handle );
			wp_deregister_style( $handle );
			}
		} else { return; }
	$combined_css_contents_raw	= implode( "\n", $combined_css );
	$combined_css_contents_len	= rshcp_strlen( $combined_css_contents_raw );
	$combined_css_contents		= rshcp_simple_minifier_css( $combined_css_contents_raw );
	$plugin_file_mod_time		= filemtime( __FILE__ );
	if ( file_exists( $raw_css_file ) ) {
		$raw_css_file_mod_time	= filemtime( $raw_css_file );
		$raw_css_file_filesize	= filesize( $raw_css_file );
		}
	else {
		$raw_css_file_mod_time	= FALSE;
		$raw_css_file_filesize	= FALSE;
		}
	$css_cache_time = time() - 86400; // 60 * 60 * 1 - Sec * Min * Hour; 3600 = 1 Hour; 86400 = 24 Hours;
	if ( !empty( $combined_css_contents_len ) ) {
		if ( $raw_css_file_filesize != $combined_css_contents_len || $raw_css_file_mod_time < $plugin_file_mod_time || $raw_css_file_mod_time < $css_cache_time || FALSE === $raw_css_file_mod_time ) {
			rshcp_write_cache_file( $raw_css_file, $combined_css_contents_raw );
			rshcp_write_cache_file( $min_css_file, $combined_css_contents );
			}
		}
	else { $rshcp_css_null = TRUE; }
	$rshcp_css_run = TRUE;
	}
// SPEED UP WORDPRESS - END

// Standard Functions - BEGIN

function rshcp_casetrans( $type, $string ) {
	/***
	* Convert case using multibyte version if available, if not, use defaults
	* Added 1.8.4
	***/
	switch ($type) {
		case 'upper':
			if ( function_exists( 'mb_strtoupper' ) ) { return mb_strtoupper($string, 'UTF-8'); } else { return strtoupper($string); }
		case 'lower':
			if ( function_exists( 'mb_strtolower' ) ) { return mb_strtolower($string, 'UTF-8'); } else { return strtolower($string); }
		case 'ucfirst':
			if ( function_exists( 'mb_strtoupper' ) && function_exists( 'mb_substr' ) ) { return mb_strtoupper(mb_substr($string, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($string, 1, NULL, 'UTF-8'); } else { return ucfirst($string); }
		case 'ucwords':
			if ( function_exists( 'mb_convert_case' ) ) { return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8'); } else { return ucwords($string); }
			/***
			* Note differences in results between ucwords() and this. 
			* ucwords() will capitalize first characters without altering other characters, whereas this will lowercase everything, but capitalize the first character of each word.
			* This works better for our purposes, but be aware of differences.
			***/
		default:
			return $string;
		}
	}
function rshcp_get_domain( $url ) {
	// Get domain from URL
	// Filter URLs with nothing after http
	if ( empty( $url ) || preg_match( "~^https?\:*/*$~i", $url ) ) { return ''; }
	// Fix poorly formed URLs so as not to throw errors when parsing
	$url = rshcp_fix_url( $url );
	// NOW start parsing
	$parsed = parse_url($url);
	// Filter URLs with no domain
	if ( empty( $parsed['host'] ) ) { return ''; }
	return rshcp_casetrans( 'lower', $parsed['host'] );
	}
function rshcp_fix_url( $url, $rem_frag = FALSE, $rem_query = FALSE, $rev = FALSE ) {
	// Fix poorly formed URLs so as not to throw errors or cause problems
	// Too many forward slashes or colons after http
	$url = preg_replace( "~^(https?)\:+/+~i", "$1://", $url);
	// Too many dots
	$url = preg_replace( "~\.+~i", ".", $url);
	// Too many slashes after the domain
	$url = preg_replace( "~([a-z0-9]+)/+([a-z0-9]+)~i", "$1/$2", $url);
	// Remove fragments
	if ( !empty( $rem_frag ) && strpos( $url, '#' ) !== FALSE ) { $url_arr = explode( '#', $url ); $url = $url_arr[0]; }
	// Remove query string completely
	if ( !empty( $rem_query ) && strpos( $url, '?' ) !== FALSE ) { $url_arr = explode( '?', $url ); $url = $url_arr[0]; }
	// Reverse
	if ( !empty( $rev ) ) { $url = strrev($url); }
	return $url;
	}
function rshcp_get_url() {
	$url  = rshcp_is_https() ? 'https://' : 'http://';
	$url .= RSHCP_SERVER_NAME.$_SERVER['REQUEST_URI'];
	return $url;
	}
function rshcp_is_https() {
	if ( !empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) { return TRUE; }
	return FALSE;
	}
function rshcp_get_server_addr() {
	if ( !empty( $_SERVER['SERVER_ADDR'] ) ) { $server_addr = $_SERVER['SERVER_ADDR']; } else { $server_addr = getenv('SERVER_ADDR'); }
	if ( empty( $server_addr ) ) { $server_addr = ''; }
	return $server_addr;
	}
function rshcp_get_server_name() {
	$rshcp_site_domain		= $server_name = RSMP_SITE_DOMAIN;
	$rshcp_env_http_host	= getenv('HTTP_HOST');
	$rshcp_env_srvr_name	= getenv('SERVER_NAME');
	if 		( !empty( $_SERVER['HTTP_HOST'] ) 	&& strpos( $rshcp_site_domain, $_SERVER['HTTP_HOST'] )		!== FALSE ) { $server_name = $_SERVER['HTTP_HOST']; }
	elseif 	( !empty( $rshcp_env_http_host ) 	&& strpos( $rshcp_site_domain, $rshcp_env_http_host ) 		!== FALSE ) { $server_name = $rshcp_env_http_host; }
	elseif 	( !empty( $_SERVER['SERVER_NAME'] ) && strpos( $rshcp_site_domain, $_SERVER['SERVER_NAME'] )	!== FALSE ) { $server_name = $_SERVER['SERVER_NAME']; }
	elseif 	( !empty( $rshcp_env_srvr_name ) 	&& strpos( $rshcp_site_domain, $rshcp_env_srvr_name )		!== FALSE ) { $server_name = $rshcp_env_srvr_name; }
	return rshcp_casetrans( 'lower', $server_name );
	}
function rshcp_doc_txt() {
	return __( 'Documentation', RSHCP_PLUGIN_NAME );
	}
function rshcp_scandir( $dir ) {
	clearstatcache();
	$dot_files = array( '..', '.' );
	$dir_contents_raw = scandir( $dir );
	$dir_contents = array_values( array_diff( $dir_contents_raw, $dot_files ) );
	return $dir_contents;
	}
function rshcp_append_log_data( $str = NULL, $rsds_only = FALSE ) {
	// Adds data to the log for debugging - only use when Debugging - Use with WP_DEBUG & RSHCP_DEBUG
	/*
	* Example:
	* rshcp_append_log_data( "\n".'$rshcp_example_variable: "'.$rshcp_example_variable.'" Line: '.__LINE__.' | '.__FUNCTION__.' | MEM USED: ' . rshcp_format_bytes( memory_get_usage() ), TRUE );
	* rshcp_append_log_data( "\n".'$rshcp_example_variable: "'.$rshcp_example_variable.'" Line: '.__LINE__.' | '.__FUNCTION__.' | '.rshcp_get_url().' | MEM USED: ' . rshcp_format_bytes( memory_get_usage() ), TRUE );
	* rshcp_append_log_data( "\n".'[A]$rshcp_example_array_var: "'.serialize($rshcp_example_array_var).'" Line: '.__LINE__.' | '.__FUNCTION__.' | MEM USED: ' . rshcp_format_bytes( memory_get_usage() ), TRUE );
	*/
	if ( TRUE === WP_DEBUG && TRUE === RSHCP_DEBUG ) {
		if ( !empty( $rsds_only ) && strpos( RSHCP_SERVER_NAME_REV, RSMP_DEBUG_SERVER_NAME_REV ) !== 0 ) { return; }
		$rshcp_log_str = 'RSHCP DEBUG: '.str_replace("\n", "", $str);
		error_log( $rshcp_log_str, 0 ); // Logs to debug.log
		}
	}
function rshcp_microtime() {
	return microtime( TRUE );
	}
function rshcp_timer( $start = NULL, $end = NULL, $show_seconds = FALSE, $precision = 8, $no_format = FALSE, $raw = FALSE ) {
	/***
	* $precision will default to 8 but can be set to anything - 1,2,3,4,5,6,etc.
	* Use $no_format when clean numbers are needed for calculations. International formatting throws a wrench into things.
	***/
	if ( empty( $start ) || empty( $end ) ) { $start = $end = 0; }
	$total_time = $end - $start;
	if ( empty( $no_format ) ) {
		$total_time_for = rshcp_number_format( $total_time, $precision );
		if ( !empty( $show_seconds ) ) { $total_time_for .= ' seconds'; }
		}
	elseif ( empty( $raw ) ) {
		$total_time_for = number_format( $total_time, $precision );
		} 
	else { $total_time_for = $total_time; }
	return $total_time_for;
	}
function rshcp_number_format( $number, $precision = NULL ) {
	/* $precision will default to NULL but can be set to anything - 1,2,3,4,5,6,etc. */
	if ( function_exists( 'number_format_i18n' ) ) { $number_for = number_format_i18n( $number, $precision ); }
	else { $number_for = number_format( $number, $precision ); }
	return $number_for;
	}
function rshcp_format_bytes( $size, $precision = 2 ) {
	if ( !is_numeric($size) ) { return $size; }
    $base = log($size) / log(1024);
    $suffixes = array('', 'k', 'M', 'G', 'T');
	$formatted_num = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    return $formatted_num;
	}
function rshcp_sort_unique($arr) {
	$arr_tmp = array_unique($arr); natcasesort($arr_tmp); $new_arr = array_values($arr_tmp);
	return $new_arr;
	}
function rshcp_md5( $string ) {
	/***
	* Use this function instead of hash for compatibility
	* BUT hash is faster than md5, so use it whenever possible
	***/
	if ( function_exists( 'hash' ) ) { $hash = hash( 'md5', $string ); } else { $hash = md5( $string );	}
	return $hash;
	}
function rshcp_is_login_page() {
	global $pagenow;
    if ( $pagenow === 'wp-login.php' || $pagenow === 'wp-register.php' ) { return TRUE; }
    if ( strpos( $_SERVER['PHP_SELF'], '/wp-login.php' ) !== FALSE || strpos( $_SERVER['PHP_SELF'], '/wp-register.php' ) !== FALSE ) { return TRUE; }
    return FALSE;
	}
// Standard Functions - END

// Admin Functions - BEGIN
register_activation_hook( __FILE__, 'rshcp_activation' );
function rshcp_activation() {
	$installed_ver = get_option('rs_head_cleaner_version');
	rshcp_upgrade_check( $installed_ver );
	rshcp_mk_cache_dir();
	}
function rshcp_mk_cache_dir() {
	$rshcp_js_dir			= RSHCP_JS_PATH;
	$rshcp_css_dir			= RSHCP_CSS_PATH;
	$rshcp_index_file		= RSHCP_PLUGIN_PATH.'index.php';
	$rshcp_htaccess_file	= RSHCP_PLUGIN_PATH.'lib/.htaccess';
	if ( !file_exists( $rshcp_js_dir ) ) {
		wp_mkdir_p( $rshcp_js_dir );
		@copy ( $rshcp_index_file, $rshcp_js_dir.'index.php' );
		}
	if ( !file_exists( $rshcp_css_dir ) ) {
		wp_mkdir_p( $rshcp_css_dir );
		@copy ( $rshcp_index_file, $rshcp_css_dir.'index.php' );
		}
	@copy ( $rshcp_index_file, RSHCP_CACHE_PATH.'index.php' );
	@copy ( $rshcp_htaccess_file, RSHCP_CACHE_PATH.'.htaccess' );
	}
function rshcp_write_cache_file( $file, $contents, $i = 0 ) {
	/***
	* This function ensures that the cache file is written.
	* file_put_contents() just throws a PHP Warning if a folder is missing, but this will attempt to create the folder and write the file up to 3 times.
	***/
	$i++; $m = 3;
	if ( $i <= $m && FALSE === file_put_contents( $file, $contents ) ) {
		rshcp_mk_cache_dir();
		rshcp_write_cache_file( $file, $contents, $i );
		}
	}
add_action( 'admin_init', 'rshcp_check_version' );
function rshcp_check_version() {
	if ( current_user_can( 'manage_network' ) ) {
		/* Check for pending admin notices */
		$admin_notices = get_option('rshcp_admin_notices');
		if ( !empty( $admin_notices ) ) { add_action( 'network_admin_notices', 'rshcp_admin_notices' ); }
		/* Make sure not network activated */
		if ( is_plugin_active_for_network( RSHCP_PLUGIN_BASENAME ) ) {
			deactivate_plugins( RSHCP_PLUGIN_BASENAME, TRUE, TRUE );
			$notice_text = __( 'Plugin deactivated. RS Head Cleaner Plus is not available for network activation.', RSHCP_PLUGIN_NAME );
			$new_admin_notice = array( 'style' => 'error', 'notice' => $notice_text );
			update_option( 'rshcp_admin_notices', $new_admin_notice );
			add_action( 'network_admin_notices', 'rshcp_admin_notices' );
			return FALSE;
			}
		}
	if ( current_user_can('manage_options') ) {
		/* Check if plugin has been upgraded */
		rshcp_upgrade_check();
		/* Check for pending admin notices */
		$admin_notices = get_option('rshcp_admin_notices');
		if ( !empty( $admin_notices ) ) { add_action( 'admin_notices', 'rshcp_admin_notices' ); }
		/* Make sure user has minimum required WordPress version, in order to prevent issues */
		$rshcp_wp_version = RSHCP_WP_VERSION;
		if ( version_compare( $rshcp_wp_version, RSHCP_REQUIRED_WP_VERSION, '<' ) ) {
			deactivate_plugins( RSHCP_PLUGIN_BASENAME );
			$notice_text = sprintf( __( 'Plugin deactivated. WordPress Version %s required. Please upgrade WordPress to the latest version.', RSHCP_PLUGIN_NAME ), RSHCP_REQUIRED_WP_VERSION );
			$new_admin_notice = array( 'style' => 'error', 'notice' => $notice_text );
			update_option( 'rshcp_admin_notices', $new_admin_notice );
			add_action( 'admin_notices', 'rshcp_admin_notices' );
			return FALSE;
			}
		/* Make sure user has minimum required PHP version, in order to prevent issues */
		$rshcp_php_version = RSHCP_PHP_VERSION;
		if ( !empty( $rshcp_php_version ) && version_compare( RSHCP_PHP_VERSION, RSHCP_REQUIRED_PHP_VERSION, '<' ) ) {
			deactivate_plugins( RSHCP_PLUGIN_BASENAME );
			$notice_text = sprintf( __( '<p>Plugin deactivated. <strong>Your server is running PHP version %3$s, but RS Head Cleaner Plus requires at least PHP %1$s.</strong> We are no longer supporting PHP 5.2, as it has not been supported by the PHP team <a href=%2$s>since 2011</a>, and there are known security, performance, and compatibility issues.</p><p>The version of PHP running on your server is <em>extremely out of date</em>. You should upgrade your PHP version as soon as possible.</p><p>If you need help with this, please contact your web hosting company and ask them to switch your PHP version to 5.4 or 5.5. Please see the <a href=%4$s>plugin documentation</a> if you have further questions.</p>', RSHCP_PLUGIN_NAME ), RSHCP_REQUIRED_PHP_VERSION, '"http://php.net/archive/2011.php#id2011-08-23-1" target="_blank" rel="external" ', $rshcp_php_version, '"'.RSHCP_HOME_URL.'?src='.RSHCP_VERSION.'-php-notice#rshc_requirements" target="_blank" rel="external" ' ); /* NEEDS TRANSLATION - Added 1.4.0 */
			$new_admin_notice = array( 'style' => 'error', 'notice' => $notice_text );
			update_option( 'rshcp_admin_notices', $new_admin_notice );
			add_action( 'admin_notices', 'rshcp_admin_notices' );
			return FALSE;
			}
		}
	}
function rshcp_admin_notices() {
	$admin_notices = get_option('rshcp_admin_notices');
	if ( !empty( $admin_notices ) ) {
		$style 	= $admin_notices['style']; // 'error'  or 'updated'
		$notice	= $admin_notices['notice'];
		echo '<div class="'.$style.'"><p>'.$notice.'</p></div>';
		}
	delete_option('rshcp_admin_notices');
	}
function rshcp_upgrade_check( $installed_ver = NULL ) {
	if ( empty( $installed_ver ) ) { $installed_ver = get_option('rs_head_cleaner_version'); }
	if ( $installed_ver != RSHCP_VERSION ) { update_option('rs_head_cleaner_version', RSHCP_VERSION); rshcp_mk_cache_dir(); }
	}
add_filter( 'plugin_row_meta', 'rshcp_filter_plugin_meta', 10, 2 ); // Added 1.3.5
function rshcp_filter_plugin_meta( $links, $file ) {
	// Add Links on Dashboard Plugins page, in plugin meta
	if ( $file == RSHCP_PLUGIN_BASENAME ){
		// after other links
		$links[] = '<a href="http://www.redsandmarketing.com/plugins/rs-head-cleaner/" target="_blank" rel="external" >' . rshcp_doc_txt() . '</a>';
		$links[] = '<a href="http://www.redsandmarketing.com/plugins/wordpress-plugin-support/" target="_blank" rel="external" >' . __( 'Support', RSHCP_PLUGIN_NAME ) . '</a>';
		$links[] = '<a href="http://bit.ly/rs-head-cleaner-rate" target="_blank" rel="external" >' . __( 'Rate the Plugin', RSHCP_PLUGIN_NAME ) . '</a>';
		$links[] = '<a href="http://bit.ly/rs-head-cleaner-donate" target="_blank" rel="external" >' . __( 'Donate', RSHCP_PLUGIN_NAME ) . '</a>';
		}
	return $links;
	}
register_deactivation_hook( __FILE__, 'rshcp_deactivation' );
function rshcp_deactivation() {
	$rshcp_css_path_old = str_replace( '/cache/'.RSHCP_CACHE_DIR_NAME.'/', '/rshcp-cache/', RSHCP_CSS_PATH );
	$rshcp_js_path_old = str_replace( '/cache/'.RSHCP_CACHE_DIR_NAME.'/', '/rshcp-cache/', RSHCP_JS_PATH );
	$rshcp_dirs_all = array(
		array( 'css' => RSHCP_CSS_PATH, 'js' => RSHCP_JS_PATH ),
		array( 'css' => $rshcp_css_path_old, 'js' => $rshcp_js_path_old ),
		);
	foreach( $rshcp_dirs_all as $i => $rshcp_dirs ) {
		foreach( $rshcp_dirs as $d => $dir ) {
			if ( is_dir( $rshcp_dirs[$d] ) ) {
				$filelist = rshcp_scandir( $rshcp_dirs[$d] );
				foreach( $filelist as $f => $filename ) {
					$file = $rshcp_dirs[$d].$filename; $filerev = strrev($file); $drev = strrev($d);
					if ( is_file( $file ) ){
						if ( strpos( $filerev, $drev.'.' ) !== 0 ) { continue; }
						@chmod( $file, 0775 ); 
						@unlink( $file );
						if ( file_exists( $file ) ) { @chmod( $file, 0644 ); }
						}
					}
				}
			}
		}
	}
// Admin Functions - END

/* BENCHMARK - END */
/*
$end_time = rshcp_microtime();
$total_time = rshcp_timer( $start_time, $end_time, FALSE, 6, TRUE );
rshcp_append_log_data( "\n".'$start_time: "'.$start_time.'" Line: '.__LINE__.' | '.__FUNCTION__.' | '.rshcp_get_url().' | MEM USED: ' . rshcp_format_bytes( memory_get_usage() ), TRUE );
rshcp_append_log_data( "\n".'$end_time: "'.$end_time.'" Line: '.__LINE__.' | '.__FUNCTION__.' | '.rshcp_get_url().' | MEM USED: ' . rshcp_format_bytes( memory_get_usage() ), TRUE );
rshcp_append_log_data( "\n".'$total_time: "'.$total_time.'" Line: '.__LINE__.' | '.__FUNCTION__.' | '.rshcp_get_url().' | MEM USED: ' . rshcp_format_bytes( memory_get_usage() ), TRUE );
*/

// PLUGIN - END
