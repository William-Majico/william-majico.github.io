<?php
Class TOROFLIX_Add_Theme_Support {
	public static function get_position_sidebar(){
		$sidebar = get_option( 'sidebar_type' );
		if($sidebar == 'right'){
			$sid = '';
		} elseif($sidebar == 'left'){
			$sid = 'TpLCol';
		} elseif($sidebar == 'none'){
			$sid = 'NoSdbr';
		} else {
			$sid = '';
		}
		return $sid;
	}
	public function toroflix_add_support(){
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background');
		add_editor_style(array('assets/css/editor-style.css'));
	}
	public function toroflix_remove_elements_wordpress(){
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action('wp_head', 'feed_links_extra', 3 ); 
		remove_filter('the_content', 'wptexturize');
		remove_filter('the_title', 'wptexturize');
		remove_filter('single_post_title', 'wptexturize');
		remove_filter('comment_text', 'wptexturize');
		remove_filter('the_excerpt', 'wptexturize');
		remove_filter('content_save_pre', 'wp_filter_post_kses');
		remove_filter('content_filtered_save_pre', 'wp_filter_post_kses'); 
		add_filter( 'emoji_svg_url', '__return_false' );
		remove_action( 'wp_head', 'wp_resource_hints' );
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'start_post_rel_link');
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'adjacent_posts_rel_link');
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script');
		add_filter('the_generator', '__return_false');
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
		remove_action('wp_head', 'wp_shortlink_wp_head');
		remove_action( 'wp_head', 'dns-prefetch' );
		remove_action( 'wp_head', 'rest_output_link_wp_head' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		// all actions related to emojis
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_action('wp_head', 'wp_oembed_add_host_js');
	}
	public function toroflix_remove_gutemberg(){
		wp_dequeue_style( 'wp-block-library' );
	}
	public static function toroflix_pagination(){
		if( is_singular() )
	    return;
	    global $wp_query;
	    if( $wp_query->max_num_pages <= 1 )
	    return;
	    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	    $max   = intval( $wp_query->max_num_pages );
	    if ( $paged >= 1 )
	        $links[] = $paged;
	    if ( $paged >= 3 ) {
	        $links[] = $paged - 1;
	        $links[] = $paged - 2;
	    }
	    if ( ( $paged + 2 ) <= $max ) {
	        $links[] = $paged + 2;
	        $links[] = $paged + 1;
	    }
	    echo '<div class="nav-links">' . "\n";
	    if ( get_previous_posts_link() )
	        printf( '%s' . "\n", get_previous_posts_link( __('<i class="fa-arrow-left"></i>', 'toroflix') ) );
	    if ( ! in_array( 1, $links ) ) {
	        $class = 1 == $paged ? ' class="page-item active"' : '';
	        printf( '<a class="page-link" href="'.get_pagenum_link( 1 ).'">1</a>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
	        if ( ! in_array( 2, $links ) )
	            echo '<a>...</a>';
	    }
	    sort( $links );
	    foreach ( (array) $links as $link ) {
	        $class = $paged == $link ? ' class="page-link current"' : '';
	        printf( '<a%s class="page-link" href="'.get_pagenum_link( $link ).'">'.$link.'</a>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	    }
	    if ( ! in_array( $max, $links ) ) {
	        if ( ! in_array( $max - 1, $links ) )
	            echo '<a href="javascript:void(0)" class="extend">...</a>' . "\n";
	        $class = $paged == $max ? ' class="page-item active"' : '';
	        printf( '<a class="page-link" href="'.get_pagenum_link( $max ).'">'.$max.'</a>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	    }
	    if ( get_next_posts_link() )
	        printf( '%s' . "\n", get_next_posts_link( __('<i class="fa-arrow-right"></i>', 'toroflix') ) );
	        echo '</div>' . "\n";
	}
	public function tn_custom_excerpt_length($length){
		return 15;
	}
	public function new_excerpt_more( $more ) {
	    return '';
	}
	public function wpse33039_form_defaults( $defaults ){
	    $defaults['title_reply'] = '';
	    return $defaults;
	}
	public function my_update_comment_field( $comment_field ) {
	  $comment_field =
	    '<p class="comment-form-comment">
	            <textarea required id="comment" name="comment" placeholder="' . esc_attr__( "Comment...", "toroflix" ) . '" cols="45" rows="8" aria-required="true"></textarea>
	        </p>';
	  return $comment_field;
	}
	public function wpse_theme_setup() {
    	add_theme_support( 'title-tag' );
	}
	public function pine_content_width() {
	    $GLOBALS['content_width'] = apply_filters( 'pine_content_width', 1200 );
	}

	public function code_analityc(){
		$code     = get_option( 'analityc_code', false );
        echo $code;
	}
}