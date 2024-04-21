<?php 
add_action( 'widgets_init', function(){
    register_widget( 'toroflix_search_movies' );
});
class toroflix_search_movies extends WP_Widget {
    #Sets up the widgets name etc
    public function __construct() {
        $widget_ops = array(
            'classname' => 'toroflix_search_movies',
            'description' => 'Filter for movies and series',
        );
        parent::__construct( 'toroflix_search_movies', 'Toroflix: Filter', $widget_ops );
    }
    # Display frontend
    public function widget( $argus, $instance ) {
        echo $argus['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $argus['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $argus['after_title'];
        } ?>
        <div class="SearchMovies">
            <form>
                <input type="hidden" name="s" value="filter">
    
                <div class="Frm-Slct">
                    <label class="AAIco-date_range"><?php _e('Year', 'toroflix'); ?></label>
                    <div class="Form-Group">
                        <select class="Select-Md" name="years[]" multiple="multiple">
                            <?php $terms = get_terms( 'annee', array(
                                'hide_empty' => false,
                            ) );
                            if($terms){
                                foreach( $terms as $term ) {
                                    $name = $term->name; ?>
                                    <option value="<?php echo $term->name; ?>"><?php echo $name; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="Frm-Slct">
                    <label class="AAIco-movie_creation"><?php _e('Genre', 'toroflix'); ?></label>
                    <div class="Form-Group">
                        <select class="Select-Md" name="genre[]" multiple="multiple">
                            <?php $categories = get_categories( array(
                                'orderby' => 'name',
                                'order'   => 'ASC'
                            ) );
                            if($categories){
                                foreach( $categories as $category ) {
                                    $name = $category->name; ?>
                                    <option value="<?php echo $category->term_id; ?>"><?php echo $name; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <button class="Button" type="submit"><?php _e('SEARCH', 'toroflix'); ?></button>
            </form>
        </div>
        <?php echo $argus['after_widget'];
    }
    #Parameters Form of Widget
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        ?>
        <div class="wdgt-tt">
            <div>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'toroflix' ); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-edit-large"></span>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
        return $updated_instance;
    }
}