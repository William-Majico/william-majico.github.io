<?php
class TOROFLIX_Public {
    private $theme_name;
    private $version;
    //private $normalize;
    private $helpers;
    public function __construct( $theme_name, $version ) {
        $this->theme_name = $theme_name;
        $this->version    = $version;
        //$this->normalize  = new TOROFLIX_Normalize;
    }
    //Style public
    public function enqueue_styles() {
        wp_enqueue_style( $this->theme_name, TOROFLIX_DIR_URI . 'public/css/toroflix-public.css', array(), $this->version, 'all' );
    }
    public function enqueue_styles_footer() {
        wp_enqueue_style( 'font-awesome-public_css', TOROFLIX_DIR_URI . 'public/css/font-awesome.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'material-public-css', TOROFLIX_DIR_URI . 'public/css/material.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'font-source-sans-pro-public-css' . trim( get_option( get_template() . '_license_key' ) ) , 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700', array(), $this->version, 'all' );
    }
    public function enqueue_scripts() {
        wp_enqueue_script( 'funciones_public_jquery', TOROFLIX_DIR_URI . 'public/js/jquery.js',  array(), '3.0.0', true );
        wp_enqueue_script( 'funciones_public_carousel', TOROFLIX_DIR_URI . 'public/js/owl.carousel.min.js',  array(), $this->version, true );
        wp_enqueue_script( 'funciones_public_sol', TOROFLIX_DIR_URI . 'public/js/sol.js',  array(), $this->version, true );
        wp_enqueue_script( 'funciones_public_functions', TOROFLIX_DIR_URI . 'public/js/functions.js',  array(), $this->version, true );
        #Comments
        if( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1) ) {
            wp_enqueue_script( 'comment-reply', 'wp-includes/js/comment-reply', array(), false, true );
        }
        $type = false;

        $trailer = false;
        $id      = false;

        if(is_singular()) {
            global $post;
            $id      = $post->ID;
            
            $trailer = mb_convert_encoding(get_post_meta( $post->ID, 'field_trailer', true ), 'UTF-8', 'HTML-ENTITIES');
        
            $firstCharTrailer = substr($trailer, 0, 1); 
            
            if( $firstCharTrailer == '[' ){
                if ( strpos($trailer, 'youtube.com/embed') !== false ) {
                    preg_match_all('/".*?"|\'.*?\'/', $trailer, $matches);
                    $nm       = $matches[0][0];
                    $remove[] = "'";
                    $remove[] = '"';
                    $id_nm    = str_replace($remove, "", $nm);
                    $trailer = '<iframe width="560" height="315" src="'.$id_nm.'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
                } elseif ( strpos($trailer, 'watch?v=') !== false ) {
                    preg_match_all('/".*?"|\'.*?\'/', $trailer, $matches);
                    $nm       = $matches[0][0];
                    $remove[] = "'";
                    $remove[] = '"';
                    $id_nm    = str_replace($remove, "", $nm);
                    $id_nm    = str_replace('watch?v=', 'embed/', $id_nm);
                    $trailer = '<iframe width="560" height="315" src="'.$id_nm.'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
                } else {
                    preg_match_all('/".*?"|\'.*?\'/', $trailer, $matches);
                    $nm       = $matches[0][0];
                    $remove[] = "'";
                    $remove[] = '"';
                    $id_nm    = str_replace($remove, "", $nm);
                    $trailer = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$id_nm.'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
                }
            }


            $type    = get_post_type($id);
        }

        #player automatic slider home 
        $playerAutomaticSlider  = get_option( 'slider_play', false );

        #Report Text 
        $report_text_reportForm = __('Report Form', 'toroflix');
        $report_text_message    = __('Message', 'toroflix');
        $report_text_send       = __('SEND', 'toroflix');
        $report_text_has_send   = __('the report has been sent', 'toroflix');

        #Localize Script
        $toroflixPublic = [
            'url'                    => admin_url( 'admin-ajax.php' ),
            'nonce'                  => wp_create_nonce( 'toroflix_seg' ),
            'trailer'                => $trailer,
            'noItemsAvailable'       => __('No entries found', 'toroflix'),
            'selectAll'              => __('Select all', 'toroflix'),
            'selectNone'             => __('Select none', 'toroflix'),
            'searchplaceholder'      => __('Click here to search', 'toroflix'),
            'loadingData'            => __('Still loading data...', 'toroflix'),
            'viewmore'               => __('View more', 'toroflix'),
            'id'                     => $id,
            'type'                   => $type,
            'report_text_reportForm' => $report_text_reportForm,
            'report_text_message'    => $report_text_message,
            'report_text_send'       => $report_text_send,
            'report_text_has_send'   => $report_text_has_send,
            'playerAutomaticSlider'  => $playerAutomaticSlider,
        ];
        wp_localize_script( 'funciones_public_functions', 'toroflixPublic', $toroflixPublic );
        wp_localize_script( 'funciones_public_sol', 'toroflixPublic', $toroflixPublic );
    }
}