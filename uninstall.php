<?php
/*
RS Head Cleaner - uninstall.php
Version: 1.3.5

This script uninstalls RS Head Cleaner and removes all cache files, options, data, and traces of its existence.
*/

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 	{ exit(); }

if ( !defined( 'RSHCP_CACHE_DIR_NAME' ) ) 	{ define( 'RSHCP_CACHE_DIR_NAME', 'rshcp-cache' ); }
if ( !defined( 'RSHCP_CACHE_PATH' ) ) 		{ define( 'RSHCP_CACHE_PATH', WP_CONTENT_DIR.'/'.RSHCP_CACHE_DIR_NAME.'/' ); }
if ( !defined( 'RSHCP_JS_PATH' ) ) 			{ define( 'RSHCP_JS_PATH', RSHCP_CACHE_PATH.'/js/' ); }
if ( !defined( 'RSHCP_CSS_PATH' ) ) 		{ define( 'RSHCP_CSS_PATH', RSHCP_CACHE_PATH.'/css/' ); }

function rshcp_uninstall_plugin() {
	// Options to Delete
	$rshcp_option_names = array( 'rs_head_cleaner_version', 'rshcp_admin_notices' );
	foreach( $rshcp_option_names as $i => $rshcp_option ) {
		delete_option( $rshcp_option );
		}

	$rshcp_dirs = array( 'css' => RSHCP_CSS_PATH, 'js' => RSHCP_JS_PATH, 'cache' => RSHCP_CACHE_PATH );
	foreach( $rshcp_dirs as $d => $dir ) {
		if ( is_dir( $rshcp_dirs[$d] ) ) {
			$filelist = rshcp_scandir( $rshcp_dirs[$d] );
			foreach( $filelist as $f => $filename ) {
				$file = $rshcp_dirs[$d].$filename;
				if ( is_file( $file ) ){
					@chmod( $file, 0775 );
					@unlink( $file );
					if ( file_exists( $file ) ) { @chmod( $file, 0644 ); }
					}
				}
			@chmod( $rshcp_dirs[$d], 0775 );
			@rmdir( $rshcp_dirs[$d] );
			if ( file_exists( $rshcp_dirs[$d] ) ) { @chmod( $rshcp_dirs[$d], 0755 ); }
			}
		}
	
	}

function rshcp_scandir( $dir ) {
	clearstatcache();
	$dot_files = array( '..', '.' );
	$dir_contents_raw = scandir( $dir );
	$dir_contents = array_values( array_diff( $dir_contents_raw, $dot_files ) );
	return $dir_contents;
	}

rshcp_uninstall_plugin();

?>