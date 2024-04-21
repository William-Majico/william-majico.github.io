<?php 
function tr_check_type($id, $display=NULL) {
    $return = '';
    $type = get_post_meta($id, 'tr_post_type', true);
    if($type==2){ $return = 2; }else{ $return = 1; }
    if($display==NULL){ return $return; }else{ echo $return; }
}
add_action('pre_get_posts', function($query) {
    if ( ! is_admin() && $query->is_main_query() ) {
        if ( is_category() or is_tag()) {
            $query->set( 'post_type', array( 'movies', 'series' ) );
        }
        if ( $query->is_search() ) {
            $query->set( 'post_type', array( 'movies', 'series' ) );
        }
    }
});
if ( ! function_exists( 'tr_get_the_comments_navigation' ) ) :
    /**
     * Remove H2 from comments pagination
     */
    function tr_get_the_comments_navigation( $args = array() ) {
        $navigation = '';
        $navigation = preg_replace('#<h([1-6]).*?class="(.*?)".*?>(.*?)<\/h[1-6]>#si', '', get_the_comments_navigation($args));
        echo $navigation;
    }
endif;