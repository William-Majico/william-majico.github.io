<?php 
add_action( 'widgets_init', function(){
    register_widget( 'widget_post_toroflix' );
});
class widget_post_toroflix extends WP_Widget {
    #Sets up the widgets name etc
    public function __construct() {
        $widget_ops = array(
            'classname'   => 'widget_postlist',
            'description' => 'Show list of movies or series',
        );
        parent::__construct( 'widget_post_toroflix', 'Toroflix: List Post', $widget_ops );
    }
    # Display frontend
    public function widget( $argus, $instance ) {
        echo $argus['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $argus['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $argus['after_title'];
        } ?>
        <?php 
        $design = isset( $instance['design'] ) ? $instance['design'] : 1;
        $type = isset( $instance['type'] ) ? $instance['type'] : 3;
        if($type == 2) {
            $t = array('movies');
        } elseif($type == 1) {
            $t = array('series');
        } else {
            $t = array('series', 'movies');
        }
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 1; 
        $order = isset( $instance['order'] ) ? $instance['order'] : 1;

        if($order == 4){
            $category       = ( ! empty( $instance['categories'] ) ) ?  $instance['categories']  : 1;
            $category_array = explode(',', $category);
        }
            
         ?>
        <ul class="MovieList <?php if($design == 2){echo 'MovieList Rows AF A04';} ?>">
            <?php 
            if($order == 1){
                $args = array(
                    'posts_per_page' => $number,
                    'post_type'      => $t,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'order' => 'DESC',
                    'orderby' => 'date',
                ); 
            } elseif($order == 2) {
                $args = array(
                    'posts_per_page' => $number,
                    'post_type'      => $t,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'meta_key'       => 'views', 
                    'orderby'        => 'meta_value_num', 
                    'order'          => 'DESC',
                    'post_status'    => 'publish', 
                ); 
            } elseif($order == 3) {
                $args = array(
                    'posts_per_page' => $number,
                    'post_type'      => $t,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'rand',
                ); 
            } elseif($order == 4) {
                $args = array(
                    'posts_per_page'      => $number,
                    'post_type'           => $t,
                    'no_found_rows'       => true,
                    'post_status'         => 'publish',
                    'ignore_sticky_posts' => true,
                    'order'               => 'DESC',
                    'orderby'             => 'date',
                    'category__in'        => $category_array
                ); 
            } else {
                $args = array(
                    'posts_per_page' => $number,
                    'post_type'      => $t,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'order' => 'DESC',
                    'orderby' => 'date',
                ); 
            }
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) :
                $count = 1;
                while ( $the_query->have_posts() ) : $the_query->the_post(); 
                    $loop     = new TOROFLIX_Movies();
                    $option     = get_option( 'poster_option_views', array() );
                    $quality  = $loop->get_quality(); 
                    $year     = $loop->year();
                    $duration = $loop->duration();
                    $views    = $loop->views(); 
                    $like_vote   = get_post_meta(get_the_ID(), 'like_flix', true);
                    if(!$like_vote)
                        $like_vote = 0;
                    $unlike_vote = get_post_meta(get_the_ID(), 'unlike_flix', true);
                    if(!$unlike_vote)
                        $unlike_vote = 0;
                    $sum = $like_vote + $unlike_vote;
                    if($sum == 0) {
                        $prom = 0;
                    } else {
                        $prom = round( ($like_vote / $sum), 1 ) * 5;
                    }     ?>
                    <?php if($design == 3){ ?>
                        <li>
                            <div class="TPost B">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="Image">
                                        <figure class="Objf TpMvPlay AAIco-play_arrow"><?php echo $loop->image(get_the_ID(), 'medium') ?></figure>
                                        <span class="TpTv BgA"><?php if( 'movies' == get_post_type(get_the_ID()) ) { echo 'Movie'; } elseif( 'series' == get_post_type(get_the_ID()) ) { echo 'Serie'; } ?></span>
                                    </div>
                                    <div class="Title"><?php the_title(); ?>
                                    </div>
                                </a>
                            </div>
                        </li>
                    <?php } elseif($design == 1){ ?>
                        <li>
                            <div class="TPost C">
                                <a href="<?php the_permalink(); ?>">
                                    <span class="Top"><?php echo $count; ?></span>
                                    <div class="Image"><figure class="Objf TpMvPlay AAIco-play_arrow"><?php echo $loop->image(get_the_ID(), 'thumbnail') ?></figure></div>
                                    <div class="Title">
                                        <?php the_title(); ?>
                                        <span class="TpTv BgA"><?php if( 'movies' == get_post_type(get_the_ID()) ) { _e('Movie', 'toroflix'); } elseif( 'series' == get_post_type(get_the_ID()) ) { _e('Serie', 'toroflix'); } ?></span>
                                    </div>
                                </a>
                                <div class="Info">
                                    <div class="Vote">
                                        <div class="post-ratings">
                                            <img loading="lazy" src="<?php echo TOROFLIX_DIR_URI; ?>public/img/cnt/rating_on.gif" alt="img"><span style="font-size: 12px;"><?php echo $prom; ?></span>
                                        </div>
                                    </div>
                                    <?php if($year){ ?><span class="Date"><?php echo $loop->year(); ?></span><?php } ?>
                                    <?php if (in_array('qual', $option)) {  if ( 'movies' == get_post_type(get_the_ID()) && $quality ) { echo $quality; } } ?>
                                    <?php if($duration){ ?><span class="Time"><?php echo $duration ?></span><?php } ?>
                                    <?php if($views){ ?><span class="Views AAIco-remove_red_eye"><?php echo $views; ?></span><?php } ?>
                                </div>
                            </div>
                        </li>
                    <?php } elseif($design == 2){ ?>
                        <li>
                            <div class="TPost B">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="Image"><figure class="Objf TpMvPlay AAIco-play_arrow"><?php echo $loop->image(get_the_ID(), 'thumbnail') ?></figure><span class="TpTv BgA"><?php if( 'movies' == get_post_type(get_the_ID()) ) { _e('Movie', 'toroflix'); } elseif( 'series' == get_post_type(get_the_ID()) ) { _e('Serie', 'toroflix'); } ?></span></div>
                                    <div class="Title"><?php the_title(); ?></div>
                                </a>
                            </div>
                        </li>
                    <?php } ?>
                <?php $count++; endwhile; 
            endif; wp_reset_query(); ?>
        </ul>
        <?php echo $argus['after_widget'];
    }
    #Parameters Form of Widget
    public function form( $instance ) {
        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $design     = isset( $instance['design'] ) ? (int) $instance['design'] : false;
        $type       = isset( $instance['type'] ) ? (int) $instance['type'] : 2;
        $number     = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
        $order      = isset( $instance['order'] ) ? (int) $instance['order'] : false; 
        $categories = isset($instance['categories']) ? $instance['categories'] :false;
        ?>
        
        <div class="wdgt-tt">
            <div>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'toroflix' ); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-edit-large"></span>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
                </div>
                    
            </div>
            <div>
                <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type', 'toroflix'); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-video-alt2"></span>
                    <select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
                        <option<?php selected($type, 1 ); ?> value="1">Series</option>
                        <option<?php selected($type, 2 ); ?> value="2">Movies</option>
                        <option<?php selected($type, 3 ); ?> value="3">Series and Movies</option>
                    </select>      
                </div>          
            </div>
            <div>
                <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'toroflix' ); ?></label>
                 <div class="fr-input">
                    <span class="dashicons dashicons-shortcode"></span>
                    <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
                </div>
            </div>
            <div>
                <label for="<?php echo $this->get_field_id('design'); ?>"><?php _e('Design', 'toroflix'); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-schedule"></span>
                    <select id="<?php echo $this->get_field_id('design'); ?>" name="<?php echo $this->get_field_name('design'); ?>">
                        <option<?php selected($design, 1 ); ?> value="1">List</option>
                        <option<?php selected($design, 2 ); ?> value="2">Grid</option>
                        <option<?php selected($design, 3 ); ?> value="3">Big</option>
                    </select>
                </div>          
            </div>
            <div>
                <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'toroflix'); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-sort"></span>
                    <select id="<?php echo $this->get_field_id('order'); ?>" class="sel-filter" name="<?php echo $this->get_field_name('order'); ?>">
                        <option<?php selected($order, 1 ); ?> value="1"><?php _e('Latest', 'toroflix'); ?></option>
                        <option<?php selected($order, 2 ); ?> value="2"><?php _e('Views (Require WP-PostViews)', 'toroflix'); ?></option>
                        <option<?php selected($order, 3 ); ?> value="3"><?php _e('Random', 'toroflix'); ?></option>
                        <option<?php selected($order, 4 ); ?> value="4"><?php _e('Category', 'toroflix'); ?></option>
                    </select>
                </div>         
            </div>

            <div class="select-cats">
                <label class="show-hide-cat" for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Category', 'toroflix'); ?> <span class="dashicons dashicons-sort"></span></label>
                <div class="fr-input-cat hide">
                    <ul class="s-cat">
                        <?php 
                        $ar = '';
                        $ar = explode(',', $categories);
                        foreach ($ar as &$value) { $lst[$value] = $value; }
                        $categories = get_categories('hide_empty=1');
                        foreach ($categories as $category) { ?>
                            <li>
                                <label>
                                <input <?php if(isset($lst[$category->term_id])){checked( $lst[$category->term_id], $category->term_id); } ?> type="checkbox" class="checkbox" name="<?php echo $this->get_field_name('categories'); ?>[]" value="<?php echo $category->term_id; ?>"  />
                                <?php echo $category->cat_name ?></label><br />
                            </li>
                        <?php } ?>
                    </ul>
                </div>          
            </div>

        </div>


        <?php
    }
    #Save Data
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        foreach( $new_instance as $key => $value )
        {
            $updated_instance[$key] = sanitize_text_field($value);
        }
        if(isset($new_instance['categories'])){
            $updated_instance['categories'] = strip_tags(implode(',', $new_instance['categories']));
        }
        return $updated_instance;
    }
}