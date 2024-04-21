<?php
class TOROFLIX_Master {
    protected $cargador;
    protected $theme_name;
    protected $version;
    public function __construct() {
        $this->theme_name = 'TOROFLIX_Theme';
        $this->version = TOROFLIX_VERSION;
        $this->cargar_dependencias();
        $this->cargar_instancias();
        $this->definir_admin_hooks();
        $this->definir_public_hooks();
    }
    private function cargar_dependencias() {
        require_once TOROFLIX_DIR_PATH . 'includes/class-toroflix-cargador.php';        
        require_once TOROFLIX_DIR_PATH . 'admin/class-toroflix-admin.php';
        require_once TOROFLIX_DIR_PATH . 'public/class-toroflix-public.php';
        require_once TOROFLIX_DIR_PATH . 'includes/class-toroflix-build-menupage.php';
        require_once TOROFLIX_DIR_PATH . 'public/partials/do_action/do_action_single.php';
        require_once TOROFLIX_DIR_PATH . 'public/partials/do_action/do_action_series.php';
        require_once TOROFLIX_DIR_PATH . 'public/partials/do_action/do_action_page.php';
        require_once TOROFLIX_DIR_PATH . 'public/partials/do_action/do_action_footer.php';
        require_once TOROFLIX_DIR_PATH . 'public/partials/do_action/do_action_header.php';
        require_once TOROFLIX_DIR_PATH . 'public/partials/do_action/do_action_home.php';
        require_once TOROFLIX_DIR_PATH . 'public/partials/do_action/do_action_episode.php';
        require_once TOROFLIX_DIR_PATH . 'public/partials/do_action/do_action_season.php';
        require_once TOROFLIX_DIR_PATH . 'public/partials/template/header_single.php';
        require_once TOROFLIX_DIR_PATH . 'includes/class-toroflix-ajax-pubic.php';
        require_once TOROFLIX_DIR_PATH . 'includes/class-toroflix-ajax-admin.php';
        require_once TOROFLIX_DIR_PATH . 'includes/class-toroflix-add-theme-support.php';
        require_once TOROFLIX_DIR_PATH . 'includes/class-toroflix-sidebar.php';
        /*Movies, Series*/
        require_once TOROFLIX_DIR_PATH . 'includes/class-toroflix-movies.php';
        require_once TOROFLIX_DIR_PATH . 'includes/post/class-toroflix-movie.php';
        require_once TOROFLIX_DIR_PATH . 'includes/post/class-toroflix-seasons.php';
        require_once TOROFLIX_DIR_PATH . 'includes/post/class-toroflix-episode.php';
        require_once TOROFLIX_DIR_PATH . 'includes/post/class-toroflix-theme.php';
        #widgets
        require_once TOROFLIX_DIR_PATH . 'includes/widgets/widget-toroflix-search-movies.php';
        require_once TOROFLIX_DIR_PATH . 'includes/widgets/widget-toroflix-genres.php';
        require_once TOROFLIX_DIR_PATH . 'includes/widgets/widget-toroflix-letters.php';
        require_once TOROFLIX_DIR_PATH . 'includes/widgets/widget-toroflix-top-series.php';
        require_once TOROFLIX_DIR_PATH . 'includes/widgets/widget-toroflix-navigation.php';
        require_once TOROFLIX_DIR_PATH . 'includes/widgets/widget-toroflix-footer-info.php';
        #Customizer
        require_once TOROFLIX_DIR_PATH . 'includes/customizer.php';
        require_once TOROFLIX_DIR_PATH . 'admin/customizer/class-toroflix-color.php';
        require_once TOROFLIX_DIR_PATH . 'includes/functions.php';
    }
    private function cargar_instancias() {
        $this->cargador                   = new TOROFLIX_Cargador;
        $this->toroflix_admin             = new TOROFLIX_Admin( $this->get_theme_name(), $this->get_version() );
        $this->toroflix_public            = new TOROFLIX_Public( $this->get_theme_name(), $this->get_version() );
        $this->toroflix_public_ajax       = new TOROFLIX_public_ajax;
        $this->toroflix_admin_ajax        = new TOROFLIX_admin_ajax;
        $this->toroflix_add_theme_support = new TOROFLIX_Add_Theme_Support;       
        $this->toroflix_sidebar           = new TOROFLIX_Sidebar;
    }
    private function definir_admin_hooks() {
        $this->cargador->add_action( 'admin_enqueue_scripts', $this->toroflix_admin, 'enqueue_styles' );
        $this->cargador->add_action( 'admin_enqueue_scripts', $this->toroflix_admin, 'enqueue_scripts' );
        $this->cargador->add_action( 'init', $this->toroflix_admin, 'toroflix_register_menus' );
        $this->cargador->add_action( 'init', $this->toroflix_sidebar, 'create_sidebar_principal' );

        #Report 
        if(get_option( 'report_show' )){
            $this->cargador->add_action( 'admin_menu', $this->toroflix_admin, 'add_menu' );
        }

        /*FUNCIONES INICIALES*/
        $this->cargador->add_action( 'after_setup_theme', $this->toroflix_add_theme_support, 'toroflix_add_support' );
        $this->cargador->add_action( 'after_setup_theme', $this->toroflix_add_theme_support, 'toroflix_remove_elements_wordpress' );
        $this->cargador->add_action( 'after_setup_theme', $this->toroflix_add_theme_support, 'pine_content_width' );
        $this->cargador->add_action( 'wp_enqueue_scripts', $this->toroflix_add_theme_support, 'toroflix_remove_gutemberg' );
        $this->cargador->add_action( 'after_setup_theme', $this->toroflix_add_theme_support, 'toroflix_pagination' );
        $this->cargador->add_action( 'after_setup_theme', $this->toroflix_add_theme_support, 'wpse_theme_setup' );
        $this->cargador->add_filter( 'excerpt_length', $this->toroflix_add_theme_support, 'tn_custom_excerpt_length' );
        $this->cargador->add_filter( 'excerpt_more', $this->toroflix_add_theme_support, 'new_excerpt_more' );
        $this->cargador->add_filter( 'comment_form_defaults', $this->toroflix_add_theme_support, 'wpse33039_form_defaults' );
        $this->cargador->add_filter( 'comment_form_field_comment', $this->toroflix_add_theme_support, 'my_update_comment_field' );

        $positionAnalityc = get_option( 'analityc_position', false );
        if(!$positionAnalityc) $positionAnalityc = 'header';

        if($positionAnalityc == 'header') {
            $this->cargador->add_action('wp_head', $this->toroflix_add_theme_support, 'code_analityc');
        } else {
            $this->cargador->add_action('wp_footer', $this->toroflix_add_theme_support, 'code_analityc');
        }
        
        if(get_option( 'report_show' )){
            $this->cargador->add_action( 'wp_ajax_action_delete_message', $this->toroflix_admin_ajax , 'delete_message' );
        }
        
    }
    private function definir_public_hooks() {
        /*Load Styles*/
        $this->cargador->add_action( 'wp_enqueue_scripts', $this->toroflix_public, 'enqueue_styles' );
        $this->cargador->add_action( 'get_footer', $this->toroflix_public, 'enqueue_styles_footer' );
        $this->cargador->add_action( 'wp_footer', $this->toroflix_public, 'enqueue_scripts' );
        /*AJAX CHANGUE POST BY*/
        $this->cargador->add_action( 'wp_ajax_action_changue_post_by', $this->toroflix_public_ajax , 'changue_post_by' );
        $this->cargador->add_action( 'wp_ajax_nopriv_action_changue_post_by', $this->toroflix_public_ajax , 'changue_post_by' );
        /*AJAX EPISODES SHOW*/
        $this->cargador->add_action( 'wp_ajax_action_episode_view', $this->toroflix_public_ajax , 'episode_view' );
        $this->cargador->add_action( 'wp_ajax_nopriv_action_episode_view', $this->toroflix_public_ajax , 'episode_view' );
        /*AJAX PLAYER CHANGUE*/
        $this->cargador->add_action( 'wp_ajax_action_player_change', $this->toroflix_public_ajax , 'player_change' );
        $this->cargador->add_action( 'wp_ajax_nopriv_action_player_change', $this->toroflix_public_ajax , 'player_change' );

        $this->cargador->add_action( 'wp_ajax_action_player_change_new', $this->toroflix_public_ajax , 'player_change_new' );
        $this->cargador->add_action( 'wp_ajax_nopriv_action_player_change_new', $this->toroflix_public_ajax , 'player_change_new' );
        /*Search suggest*/
        $this->cargador->add_action( 'wp_ajax_action_search_suggest', $this->toroflix_public_ajax , 'toroflix_search_suggest' );
        $this->cargador->add_action( 'wp_ajax_nopriv_action_search_suggest', $this->toroflix_public_ajax , 'toroflix_search_suggest' );
        /*Like*/
        $this->cargador->add_action( 'wp_ajax_action_like_mov', $this->toroflix_public_ajax , 'toroflix_like_mov' );
        $this->cargador->add_action( 'wp_ajax_nopriv_action_like_mov', $this->toroflix_public_ajax , 'toroflix_like_mov' );
        $this->cargador->add_action( 'wp_ajax_action_vote_serie', $this->toroflix_public_ajax , 'toroflix_vote_serie' );
        $this->cargador->add_action( 'wp_ajax_nopriv_action_vote_serie', $this->toroflix_public_ajax , 'toroflix_vote_serie' );
        $this->cargador->add_action( 'wp_ajax_action_vote_tax', $this->toroflix_public_ajax , 'toroflix_vote_tax' );
        $this->cargador->add_action( 'wp_ajax_nopriv_action_vote_tax', $this->toroflix_public_ajax , 'toroflix_vote_tax' );

        $this->cargador->add_action( 'wp_ajax_action_send_report', $this->toroflix_public_ajax , 'send_report' );
        $this->cargador->add_action( 'wp_ajax_nopriv_action_send_report', $this->toroflix_public_ajax , 'send_report' );
    }
    public function run() {
        $this->cargador->run();
    }
    public function get_theme_name() {
        return $this->theme_name;
    }
    public function get_cargador() {
        return $this->cargador;
    }
    public function get_version() {
        return $this->version;
    }
}