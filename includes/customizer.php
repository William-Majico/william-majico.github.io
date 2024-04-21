<?php
require_once TOROFLIX_DIR_PATH . 'admin/customizer/class-toroflix-multiple-checkbox.php';
function my_customize_register( $wp_customize ) {
    function theme_slug_sanitize_select( $input, $setting ){
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control( $setting->id )->choices;
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                   
    }
    function sanitize_multiple_checkbox( $values ) {
        $multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;
        return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
    }
    function theme_slug_sanitize_checkbox( $input ){
        return ( ( isset( $input ) && true == $input ) ? true : false );
    }
    function theme_slug_sanitize_radio( $input, $setting ){
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control( $setting->id )->choices;
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
    }
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('header_image');
    /*Generate Menu Toroflix*/
    $wp_customize->add_panel( 'toroflix_options', array(
        'title' => 'Toroflix',
        'priority' => 30,
        'capability' => 'edit_theme_options',
    ));
        $wp_customize->add_section( 'header_option' , array(
            'title'      => __( 'Header Option' ),
            'panel'      => 'toroflix_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));
            #Slider Checkbox
            $wp_customize->add_setting( 'header_type', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('header_type', array(
                'label'    => __( 'Enabled Gradient Header'),
                'section'  => 'header_option',
                'priority' => 2,
                'type'     => 'checkbox'
            ));
        #Slider Home
        $wp_customize->add_section( 'slider_section' , array(
            'title'      => __( 'Slider Home' ),
            'panel'      => 'toroflix_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));
            #Slider Checkbox
            $wp_customize->add_setting( 'slider_show', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('slider_show', array(
                'label'    => __( 'Enabled Slider' ),
                'section'  => 'slider_section',
                'priority' => 2,
                'type'     => 'checkbox'
            ));

            $wp_customize->add_setting( 'slider_play', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('slider_play', array(
                'label'    => __( 'Enabled automatic play' ),
                'section'  => 'slider_section',
                'priority' => 2,
                'type'     => 'checkbox'
            ));

            #Slider Number
            $wp_customize->add_setting( 'slider_number', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('slider_number', array(
                'label'    => __( 'Slider: Number of items', 'toroflix' ),
                'section'  => 'slider_section',
                'priority' => 2,
                'type'     => 'number',
            ));
            #Slider Type
            $wp_customize->add_setting( 'slider_type', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_select'
            ));
            $wp_customize->add_control('slider_type', array(
                'label'    => __( 'Slider: Show type post', 'toroflix' ),
                'section'  => 'slider_section',
                'priority' => 2,
                'type'     => 'select',
                'choices'  => array(
                    'movies'        => 'Movies',
                    'series'        => 'Series',
                    'movies_series' => 'Movies and Series',
                )
            ));
            #Slider order
            $wp_customize->add_setting( 'slider_order', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_select'
            ));
            $wp_customize->add_control('slider_order', array(
                'label'    => __( 'Slider: Order by', 'toroflix' ),
                'section'  => 'slider_section',
                'priority' => 2,
                'type'     => 'select',
                'choices'  => array(
                    'last'    => 'Last',
                    'popular' => 'Popular (Required WP-PostViews Plugin)',
                    'random'  => 'Random',
                    'sticky'  => 'Sticky'
                )
            ));
        #ADS
        $wp_customize->add_section( 'ads_toroflix' , array(
            'title' => __( 'ADS Home Toroflix', 'toroflix' ),
            'panel' => 'toroflix_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            #ads top letter
            $wp_customize->add_setting( 'ads_top_letter', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                
            ));
            $wp_customize->add_control('ads_top_letter', array(
                'label'    => __( 'ADS top letter', 'toroflix' ),
                'section'  => 'ads_toroflix',
                'priority' => 2,
                'type'     => 'textarea',
            ));

            #ads button letter
            $wp_customize->add_setting( 'ads_button_letter', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                
            ));
            $wp_customize->add_control('ads_button_letter', array(
                'label'    => __( 'ADS bottom letter', 'toroflix' ),
                'section'  => 'ads_toroflix',
                'priority' => 2,
                'type'     => 'textarea',
            ));



            $wp_customize->add_setting( 'ads_home_movies', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                
            ));
            $wp_customize->add_control('ads_home_movies', array(
                'label'    => __( 'ADS Block Movies', 'toroflix' ),
                'section'  => 'ads_toroflix',
                'priority' => 2,
                'type'     => 'textarea',
            ));


            $wp_customize->add_setting( 'ads_home_series', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                
            ));
            $wp_customize->add_control('ads_home_series', array(
                'label'    => __( 'ADS Block Series', 'toroflix' ),
                'section'  => 'ads_toroflix',
                'priority' => 2,
                'type'     => 'textarea',
            ));


            $wp_customize->add_setting( 'ads_home_season', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                
            ));
            $wp_customize->add_control('ads_home_season', array(
                'label'    => __( 'ADS Block Season', 'toroflix' ),
                'section'  => 'ads_toroflix',
                'priority' => 2,
                'type'     => 'textarea',
            ));


            

        #ADS SINGLE TOROFLIX
        $wp_customize->add_section( 'ads_single_toroflix' , array(
            'title' => __( 'ADS Single Toroflix', 'toroflix' ),
            'panel' => 'toroflix_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            #ads button player
            $wp_customize->add_setting( 'ads_button_player', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                
            ));
            $wp_customize->add_control('ads_button_player', array(
                'label'    => __( 'ADS bottom player', 'toroflix' ),
                'section'  => 'ads_single_toroflix',
                'priority' => 2,
                'type'     => 'textarea',
            ));
            
            #ads button title
            $wp_customize->add_setting( 'ads_button_title', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                
            ));
            $wp_customize->add_control('ads_button_title', array(
                'label'    => __( 'ADS bottom title', 'toroflix' ),
                'section'  => 'ads_single_toroflix',
                'priority' => 2,
                'type'     => 'textarea',
            ));


        #Pages Toroflix
        $wp_customize->add_section( 'pages_toroflix' , array(
            'title' => __( 'Pages Toroflix', 'toroflix' ),
            'panel' => 'toroflix_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            #Page Movies
            $wp_customize->add_setting( 'page_movie', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('page_movie', array(
                'label'    => __( 'URL Movies Page', 'toroflix' ),
                'section'  => 'pages_toroflix',
                'priority' => 2,
                'type'     => 'text',
            ));
            #Page Movies
            $wp_customize->add_setting( 'page_serie', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('page_serie', array(
                'label'    => __( 'URL Series Page', 'toroflix' ),
                'section'  => 'pages_toroflix',
                'priority' => 2,
                'type'     => 'text',
            ));
        
        #Report
        $wp_customize->add_section( 'report_toroflix' , array(
            'title' => __( 'Report Form', 'toroflix' ),
            'panel' => 'toroflix_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            #enabled Report 
            $wp_customize->add_setting( 'report_show', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('report_show', array(
                'label'    => __( 'Enabled Report' ),
                'section'  => 'report_toroflix',
                'priority' => 2,
                'type'     => 'checkbox'
            ));


        #Block Home
        $wp_customize->add_section( 'block_home' , array(
            'title' => __( 'Block Home', 'toroflix' ),
            'panel' => 'toroflix_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            #Slider Checkbox
            $wp_customize->add_setting( 'alphabet_show', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('alphabet_show', array(
                'label'    => __( 'Enabled Alphabet' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'checkbox'
            ));
            $wp_customize->add_setting( 'lazy_show', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('lazy_show', array(
                'label'    => __( 'Enabled Lazy Load Images' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'checkbox'
            ));
            #Views block
            $wp_customize->add_setting( 'block_home_views', array(
                'type'              => 'option',
                'default'           => array('popular', 'movies', 'series', 'season', 'episode'),
                'sanitize_callback' => 'sanitize_multiple_checkbox',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( new TOROFLIX_multiple_checbox( $wp_customize, 'block_home_views', array(
                'label'       => __( 'Blocks Home', 'toroflix' ),
                'description' => __( 'Select blocks to show in home', 'toroflix' ),
                'section'     => 'block_home',
                'choices'     => array(
                    'popular' => __( 'Most Popular', 'toroflix' ),
                    'movies'  => __( 'Movies', 'toroflix' ),
                    'series'  => __( 'Series', 'toroflix' ),
                    'season'  => __( 'Seasons', 'toroflix' ),
                    'episode' => __( 'Episodes', 'toroflix' ),
                    ),
                'priority' => 2,
            ) ) );
            #Popular Views
            $wp_customize->add_setting( 'popular_block_type', array(
                'type'              => 'option',
                'default'           => '1',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_select',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('popular_block_type', array(
                'label'    => 'Popular Block Type Post',
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'select',
                'choices'  => array(
                    '1' => 'All',
                    '2' => 'Movies',
                    '3' => 'Series',
                )
            ));
            $wp_customize->add_setting( 'popular_number', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('popular_number', array(
                'label'    => __( 'Popular Block: Number of items', 'toroflix' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'number',
            ));
            $wp_customize->add_setting( 'movies_title', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('movies_title', array(
                'label'    => __( 'Movies Title Block', 'toroflix' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'text',
            ));
            $wp_customize->add_setting( 'movies_number', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'absint'
            ));

            $wp_customize->add_control('movies_number', array(
                'label'    => __( 'Movies Block: Number of items', 'toroflix' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'number',
            ));
            $wp_customize->add_setting( 'series_title', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('series_title', array(
                'label'    => __( 'Series Title Block', 'toroflix' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'text',
            ));
            $wp_customize->add_setting( 'series_number', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('series_number', array(
                'label'    => __( 'Series Block: Number of items', 'toroflix' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'number',
            ));
            $wp_customize->add_setting( 'episodes_title', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('episodes_title', array(
                'label'    => __( 'Episodes Title Block', 'toroflix' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'text',
            ));
            $wp_customize->add_setting( 'episodes_number', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('episodes_number', array(
                'label'    => __( 'Episodes Block: Number of items', 'toroflix' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'number',
            ));
            $wp_customize->add_setting( 'seasons_title', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('seasons_title', array(
                'label'    => __( 'Seasons Title Block', 'toroflix' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'text',
            ));
            $wp_customize->add_setting( 'seasons_number', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control('seasons_number', array(
                'label'    => __( 'Seasons Block: Number of items', 'toroflix' ),
                'section'  => 'block_home',
                'priority' => 2,
                'type'     => 'number',
            ));
        #Sidebar
        $wp_customize->add_section( 'sidebar_toroflix' , array(
            'title' => 'Sidebar',
            'panel' => 'toroflix_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            #Slider Type
            $wp_customize->add_setting( 'sidebar_type', array(
                'type'              => 'option',
                'default'           => 'right',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_select',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('sidebar_type', array(
                'label'    => 'Sidebar Home',
                'section'  => 'sidebar_toroflix',
                'priority' => 2,
                'type'     => 'select',
                'choices'  => array(
                    'right' => 'Right',
                    'left'  => 'Left',
                    'none'  => 'Hide',
                )
            ));
            $wp_customize->add_setting( 'sidebar_type_movies_series', array(
                'type'              => 'option',
                'default'           => 'right',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_select',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('sidebar_type_movies_series', array(
                'label'    => 'Sidebar Movies and Series',
                'section'  => 'sidebar_toroflix',
                'priority' => 2,
                'type'     => 'select',
                'choices'  => array(
                    'right' => 'Right',
                    'left'  => 'Left',
                    'none'  => 'Hide',
                )
            ));
            $wp_customize->add_setting( 'sidebar_type_category', array(
                'type'              => 'option',
                'default'           => 'right',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_select',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('sidebar_type_category', array(
                'label'    => 'Sidebar Category',
                'section'  => 'sidebar_toroflix',
                'priority' => 2,
                'type'     => 'select',
                'choices'  => array(
                    'right' => 'Right',
                    'left'  => 'Left',
                    'none'  => 'Hide',
                )
            ));
        
        $wp_customize->add_section( 'player_option' , array(
            'title'      => __( 'Player Option', 'toroflix' ),
            'panel'      => 'toroflix_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));
            $wp_customize->add_setting( 'enable_tab_lang', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('enable_tab_lang', array(
                'label'    => __( 'Enable tabs by language' ),
                'section'  => 'player_option',
                'priority' => 2,
                'type'     => 'checkbox'
            ));
            
            
        $wp_customize->add_section( 'poster_option' , array(
            'title'      => __( 'Poster Option', 'toroflix' ),
            'panel'      => 'toroflix_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));
            $wp_customize->add_setting( 'poster_option_views', array(
                'type'              => 'option',
                'default'           => array('popular', 'movies', 'series', 'season', 'episode'),
                'sanitize_callback' => 'sanitize_multiple_checkbox',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( new TOROFLIX_multiple_checbox( $wp_customize, 'poster_option_views', array(
                'label'       => __( 'Poster Option View', 'toroflix' ),
                'description' => __( 'Select options to show in poster of series and movies', 'toroflix' ),
                'section'     => 'poster_option',
                'choices'     => array(
                    'year' => 'Year',
                    'lang' => 'Language',
                    'qual' => 'Quality',
                ),
                'priority' => 2,
            ) ) );
        #Lazy Images
        /*$wp_customize->add_section( 'lazy_section' , array(
            'title'      => __( 'Lazy Images', 'toroflix' ),
            'panel'      => 'toroflix_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));
            #Slider Checkbox
            $wp_customize->add_setting( 'lazy_show', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('slider_show', array(
                'label'    => __( 'Enabled Lazy Images', 'toroflix' ),
                'section'  => 'lazy_section',
                'priority' => 2,
                'type'     => 'checkbox'
            ));*/
        #Footer
        $wp_customize->add_section( 'footer_section' , array(
            'title'      => __( 'Footer', 'toroflix' ),
            'panel'      => 'toroflix_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));
            #Footer Text
            $wp_customize->add_setting( 'text_footer', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('text_footer', array(
                'label'    => __( 'Text', 'toroflix' ),
                'section'  => 'footer_section',
                'priority' => 2,
                'type'     => 'text',
            ));


        #Analityc Section 
        $wp_customize->add_section( 'section_analityc' , array(
            'title'      => __( 'Analityc', 'toroflix' ),
            'panel'      => 'toroflix_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));
            $wp_customize->add_setting( 'analityc_code', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                
            ));
            $wp_customize->add_control('analityc_code', array(
                'label'    => __( 'Analityc code', 'toroflix' ),
                'section'  => 'section_analityc',
                'priority' => 2,
                'type'     => 'textarea',
            ));

            $wp_customize->add_setting( 'analityc_position', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_select'
            ));
            $wp_customize->add_control('analityc_position', array(
                'label'       => __( 'Analityc position', 'toroflix' ),
                'section'     => 'section_analityc',
                'priority'    => 2,
                'type'        => 'select',
                'description' => 'By default is header',
                'choices'     => array(
                    'header' => 'Header',
                    'footer' => 'Footer',
                )
            ));

        $wp_customize->add_section( 'section_language' , array(
            'title' => __( 'Language', 'toroflix' ),
            'panel' => 'toroflix_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));

            $wp_customize->add_setting( 'lang_watch_trailer', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('lang_watch_trailer', array(
                'label'    => __( 'Watch Trailer', 'toroflix' ),
                'section'  => 'section_language',
                'priority' => 2,
                'type'     => 'text'
            ));
            $wp_customize->add_setting( 'lang_watch_now', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('lang_watch_now', array(
                'label'    => __( 'Watch Now', 'toroflix' ),
                'section'  => 'section_language',
                'priority' => 2,
                'type'     => 'text'
            ));


}
add_action( 'customize_register', 'my_customize_register' );
