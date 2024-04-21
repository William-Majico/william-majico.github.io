<?php 
/*SLIDER HOME*/
if ( ! function_exists( 'container_home_movielist' ) ) {
    function container_home_movielist($data) {
        $loop = $data['loop'];
        $slider_show   = get_option( 'slider_show', false );
        $slider_number = get_option('slider_number', 5);
        $slider_type   = get_option('slider_type', false);
        $slider_order  = get_option('slider_order', false);
        if($slider_type == 'movies') $type = array('movies'); 
        elseif($slider_type == 'series') $type = array('series'); 
        else { $type = array('series', 'movies');  }
        if($slider_show == 1){ ?>
            <div class="MovieListSldCn" style="height: 589px;">
                <div class="MovieListSld owl-carousel">
                    <?php 
                    if($slider_order == 'sticky') {
                        $args = array(
                            'posts_per_page' => $slider_number,
                            'post_type' => $type,
                            'meta_query'     => [
                                [
                                    'key'   => 'sticky_post_sticky_post',
                                    'value' => 'sticky-post'
                                ]
                            ],
                        ); 
                    } elseif($slider_order == 'popular') {
                        $args = array(
                            'posts_per_page' => $slider_number,
                            'post_type'      => $type,
                            'meta_key'       => 'views', 
                            'orderby'        => 'meta_value_num', 
                            'order'          => 'DESC'
                        ); 
                    } elseif($slider_order == 'random') {
                        $args = array(
                            'posts_per_page' => $slider_number,
                            'post_type'      => $type,
                            'orderby'        => 'rand'
                        ); 
                    } else {
                        $args = array(
                            'posts_per_page' => $slider_number,
                            'post_type'      => $type,
                            'orderby'        => 'date',
                            'order'          => 'DESC'
                        );
                    }
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                        while ( $the_query->have_posts() ) : $the_query->the_post();
                            get_template_part('public/partials/template/loop-slider');
                        endwhile; 
                    endif; wp_reset_query();  ?>
                </div>
            </div>
        <?php }
    }
}
add_action( 'home_movielist', 'container_home_movielist', 10 );

/*MOST POPULAR*/
if ( ! function_exists( 'home_after_slider_most_popular' ) ) {
    function home_after_slider_most_popular($data) {
        $loop    = $data['loop']; 
        $blocks  = $data['block'];
        $number_popular = get_option( 'popular_number', 10 );
        if (in_array('popular', $blocks)) { ?>
            <div class="Top AAIco-star_border">
                <h1 class="Title"><?php _e('Most popular', 'toroflix'); ?></h1>
            </div>
            <div class="MovieListTop owl-carousel">
                <?php $type = get_option( 'popular_block_type', false );
                switch ($type) {
                    case 1:
                        $args = array(
                            'posts_per_page' => $number_popular,
                            'post_type'      => array('movies', 'series'),
                            'meta_key'       => 'views', 
                            'orderby'        => 'meta_value_num', 
                            'order'          => 'DESC',
                            'post_status'    => array('publish')
                        ); 
                        break;
                    case 2:
                        $args = array(
                            'posts_per_page' => $number_popular,
                            'post_type'      => array('movies'),
                            'meta_key'       => 'views', 
                            'orderby'        => 'meta_value_num', 
                            'order'          => 'DESC',
                            'post_status'    => array('publish')
                        ); 
                        break;
                    case 3:
                        $args = array(
                            'posts_per_page' => $number_popular,
                            'post_type'      => array('series'),
                            'meta_key'       => 'views', 
                            'orderby'        => 'meta_value_num', 
                            'order'          => 'DESC',
                            'post_status'    => array('publish')
                        ); 
                        break;
                    case false:
                        $args = array(
                            'posts_per_page' => $number_popular,
                            'post_type'      => array('movies', 'series'),
                            'meta_key'       => 'views', 
                            'orderby'        => 'meta_value_num', 
                            'order'          => 'DESC',
                            'post_status'    => array('publish')
                        ); 
                        break;
                }
                $the_query = new WP_Query( $args );
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        get_template_part('public/partials/template/loop', 'secondary');
                    endwhile; 
                endif; wp_reset_query(); ?>
            </div>
        <?php }
    }
}
add_action( 'home_after_slider', 'home_after_slider_most_popular', 10 );
/*LIST OF MOVIES*/
if ( ! function_exists( 'main_post_latest_movies' ) ) {
    function main_post_latest_movies($data) {
        $loop    = $data['loop']; 
        $blocks  = $data['block'];
        $number_movies = get_option( 'movies_number', 10 );
        $title_block = get_option('movies_title', 'Movies');
        if(!$title_block){
            $title_block = __('Movies', 'toroflix');
        }
        $url  = get_option('page_movie', false);

        $ads =  get_option('ads_home_movies', false);
        if (in_array('movies', $blocks)) { ?>
            <section data-id="movies">
                <div class="Top AAIco-movie_filter">
                    <h2 class="Title"><?php echo $title_block; ?></h2>
                    <?php if($ads){ ?>
                        <div class="ads-movies">
                            <?php echo $ads; ?>
                        </div>
                    <?php } ?>
                    <?php if($url){ ?>
                    <a href="<?php echo $url; ?>" class="Button Sm"><?php _e('View more', 'toroflix'); ?></a><?php } ?>
                    <div class="SrtdBy AADrpd">
                        <i class="AALink"></i>
                        <span><?php _e('Sorted by', 'toroflix'); ?>:</span>
                        <ul class="List AACont sorted-list">
                            <li class="on"><a class="fa-check" href="#Latest"><?php _e('Latest', 'toroflix'); ?></a></li>
                            <li><a class="AAIco-check" href="#Views"><?php _e('Views', 'toroflix'); ?></a></li>
                        </ul>
                    </div>
                </div>
                <ul id="home-movies-post" class="MovieList Rows AX A04 B03 C20 D03 E20 Alt">
                    <?php
                    $args = array(
                        'posts_per_page' => $number_movies, 
                        'post_type'      => 'movies',
                        'post_status'    => 'publish',
                    ); 
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                        while ( $the_query->have_posts() ) : $the_query->the_post();
                           get_template_part("public/partials/template/loop-principal"); 
                       endwhile; 
                    endif; wp_reset_query();
                    ?>
                </ul>
            </section>
       <?php } 
    }
}
add_action( 'main_post', 'main_post_latest_movies', 10 );
/*LIST OF SERIES*/
if ( ! function_exists( 'main_post_series' ) ) {
    function main_post_series($data) { 
        $loop   = $data['loop'];
        $blocks = $data['block']; 
        $number_series = get_option( 'series_number', 10 );
        $title_block = get_option('series_title', 'Series');
        if(!$title_block){
            $title_block = __('Series', 'toroflix');
        }
        $url  = get_option('page_serie', false);
        $ads =  get_option('ads_home_series', false);
        if (in_array('series', $blocks)) { ?>
            <section data-id="series">
                <div class="Top AAIco-movie_creation">
                    <h2 class="Title"><?php echo $title_block;  ?></h2>
                    <?php if($ads){ ?>
                        <div class="ads-movies">
                            <?php echo $ads; ?>
                        </div>
                    <?php } ?>
                    <?php if($url){ ?>
                    <a href="<?php echo $url; ?>" class="Button Sm"><?php _e('View more', 'toroflix'); ?></a><?php } ?>
                    <div class="SrtdBy AADrpd">
                        <i class="AALink"></i>
                        <span><?php _e('Sorted by', 'toroflix'); ?>:</span>
                        <ul class="List AACont sorted-list">
                            <li class="on"><a class="fa-check" href="#Latest"><?php _e('Latest', 'toroflix'); ?></a></li>
                            <li><a class="AAIco-check" href="#Views"><?php _e('Views', 'toroflix'); ?></a></li>
                        </ul>
                    </div>
                </div>
                <ul class="MovieList Rows AX A04 B03 C20 D03 E20 Serie">
                    <?php 
                    $args = array(
                        'posts_per_page' => $number_series, 
                        'post_type'=>'series'
                    ); 
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                        while ( $the_query->have_posts() ) : $the_query->the_post();
                           get_template_part("public/partials/template/loop-principal");
                       endwhile;
                    endif; wp_reset_query();
                    ?>
                </ul>
            </section>
       <?php }
    }
}
add_action( 'main_post', 'main_post_series', 20 );


/*SEASONS*/
if ( ! function_exists( 'main_post__seasons' ) ) {
    function main_post_seasons($data) { 
        $loop   = $data['loop'];
        $blocks = $data['block']; 
        $ads =  get_option('ads_home_season', false);
        $number_seasons = get_option( 'seasons_number', 10 );
        $title_block = get_option('seasons_title', 'Seasons');
        if(!$title_block){
            $title_block = __('Seasons', 'toroflix');
        }
        
        $seasons = get_terms( 'seasons', array(
            'orderby'       => 'id',
            'order'         => 'DESC',
            'hide_empty'    => 0,
            'number'        => $number_seasons,
        ) );
        $lazyload  = get_option('lazy_show', false);
        if (in_array('season', $blocks)) { ?>
            <section>
                <div class="Top AAIco-movie_creation">
                    <div class="Title"><?php echo $title_block;  ?></div>
                    <?php if($ads){ ?>
                        <div class="ads-movies">
                            <?php echo $ads; ?>
                        </div>
                    <?php } ?>
                </div>
                <ul class="MovieList Rows AX A04 B03 C20 D03 E20 Seasons">
                    <?php
                    if($seasons){
                        foreach ( $seasons as $season ) {  
                            $serie_id = get_term_meta($season->term_id, 'tr_id_post', true);
                            if($lazyload) {
                                $imt = TOROFLIX_Movies::image_term_season_lazy($season, 'thumbnail');
                            } else {
                                $imt = TOROFLIX_Movies::image_term_season($season, 'thumbnail');
                            } ?>
                            <li class="TPostMv">
                                <article class="TPost B">
                                    <a href="<?php echo get_term_link( $season ); ?>">
                                        <div class="Image">
                                            <figure class="Objf TpMvPlay AAIco-play_arrow"><?php echo $imt; ?></figure>
                                            <span class="Qlty"><?php echo $loop->number_episodes_season($season); ?> - <?php _e('Episodes', 'toroflix'); ?></span>
                                        </div>
                                        <h2 class="Title" data-subtitle="Season <?php echo $loop->number_season_term($season); ?> - <?php echo $loop->year_term($season); ?>"><?php echo get_the_title($serie_id); ?></h2>
                                    </a>
                                </article>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </section>
            <?php
        }
    }
}
add_action( 'main_post', 'main_post_seasons', 30 );


/*LIST OF EPISODES*/
if ( ! function_exists( 'main_post_episodes' ) ) {
    function main_post_episodes($data) { 
        $loop = $data['loop'];
        $blocks = $data['block']; 
        $number_episodes = get_option( 'episodes_number', 10 );
        $title_block = get_option('episodes_title', 'Episodes');
        if(!$title_block){
            $title_block = __('Episodes', 'toroflix');
        }
        $lazyload  = get_option('lazy_show', false);
        if (in_array('episode', $blocks)) { ?>
            <section>
                <div class="Top AAIco-movie_creation">
                    <div class="Title"><?php echo $title_block; ?></div>
                </div>
                <ul class="MovieList Rows BX B06 C04 E03 Episodes">
                    <?php
                    $episodes = get_terms( 'episodes', array(
                        'orderby'       => 'id',
                        'order'         => 'DESC',
                        'hide_empty'    => 0,
                        'number'        => $number_episodes,
                    ) );
                    if($episodes){
                        foreach ( $episodes as $episode ) { 
                            $serie_id = get_term_meta($episode->term_id, 'tr_id_post', true);
                            if($lazyload) {
                                $imt = $loop->image_term_episode_lazy($episode, 'w300');
                            } else {
                                $imt = $loop->image_term_episode($episode, 'w300');
                            } ?>
                            <li class="TPostMv">
                                <article class="TPost B">
                                    <a href="<?php echo get_term_link( $episode ); ?>">
                                        <div class="Image">
                                            <figure class="Objf TpMvPlay AAIco-play_arrow"> <?php echo $imt; ?></figure>
                                            <span class="Qlty"><?php echo TOROFLIX_Movies::date_term($episode); ?></span>
                                        </div>
                                        <h2 class="Title" data-subtitle="<?php echo $loop->title_term($episode); ?>"><?php echo get_the_title($serie_id); ?></h2>
                                    </a>
                                </article>
                            </li>
                        <?php }
                    } ?>
                </ul>       
            </section>
           <?php 
        }
    }
}
add_action( 'main_post', 'main_post_episodes', 40 );