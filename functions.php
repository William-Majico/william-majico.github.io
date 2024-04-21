<?php
global $wpdb;

$_details = wp_get_theme('toroflix');

#Version
define( 'TOROFLIX_VERSION',  $_details['Version']);
$dir_path = ( substr( get_template_directory(),     -1 ) === '/' ) ? get_template_directory()     : get_template_directory()     . '/';
$dir_uri  = ( substr( get_template_directory_uri(), -1 ) === '/' ) ? get_template_directory_uri() : get_template_directory_uri() . '/';
define( 'TOROFLIX_DIR_PATH', $dir_path );
define( 'TOROFLIX_DIR_URI',  $dir_uri  );
#Toroplay Origin
define( 'TR_GRABBER_MOVIES', 1 ); // Activate module movies
define( 'TR_GRABBER_SERIES', 1 ); // Activate module series
define( 'TR_MINIFY', true );

/** licence */

function _licence_app()
{
    if (!class_exists('WC_AM_Client_2_8_1')) {
        require TOROFLIX_DIR_PATH . 'helpers/theme-updater/wc-am-client.php';
    }

    $wc = new WC_AM_Client_2_8_1(__FILE__, '', TOROFLIX_VERSION, 'theme', 'https://torothemes.com', 'Toroflix');

    if (!is_object($wc) && !$wc->get_api_key_status()) {
        //
    }
}
_licence_app();

#Clase General
require_once TOROFLIX_DIR_PATH . 'includes/class-toroflix-master.php';
function run_toroflix_master() {
    $bcpg_master = new TOROFLIX_Master;
    $bcpg_master->run();
}
run_toroflix_master();
function activate_toroflix(){
	require_once TOROFLIX_DIR_PATH . 'includes/class-toroflix-activator.php';
	TOROFLIX_Activator::activate();
}
add_action('after_switch_theme', 'activate_toroflix');

function prefix_change_cpt_archive_per_page( $query ) {
    //* for cpt or any post type main archive
    if ( $query->is_main_query() && ! is_admin() && is_page_template( 'pages/page-movies.php' ) ) {
        $query->set( 'posts_per_page', '2' );
    }
}
add_action( 'pre_get_posts', 'prefix_change_cpt_archive_per_page' );
load_theme_textdomain( 'toroflix', get_template_directory() . '/languages' );
require_once TOROFLIX_DIR_PATH . 'includes/sticky_post.php';


function toroflix_lang($text, $id_text){
    $text_database = get_option($id_text);
    if($text_database){
        $text = $text_database;
    } else {
        $text = __($text, 'toroflix');
    }
    return $text;
}