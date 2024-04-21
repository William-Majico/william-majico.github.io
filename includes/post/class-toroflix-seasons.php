<?php 
class TOROFLIX_Seasons
{
	public function year_term($term_id){
		$dates = get_term_meta($term_id, 'air_date', true);
		if($dates){ 
			$date_array = explode('-', $dates);
			return $date_array[0];
		} else {
			return false;
		}
	}

	public function number_season_term($term_id){
		$number = get_term_meta($term_id, 'season_number', true);
		if(!$number){ $number = 0; }
		return $number;
	}

	public function director_term($term_id){
		$id        = $term_id;
		$id_serie  = get_term_meta( $id, 'tr_id_post', true );
		$directors = array();
		$terms     = wp_get_post_terms( $id_serie , array( 'directors_tv' ) );
		if($terms){
			$directors = array();
			foreach ( $terms as $term ) {
				if ($term === end($terms)) {
					$directors[] = '<tt class="tt-at"><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></tt>';
				} else {
					$directors[] = '<tt class="tt-at"><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>,</tt>';
				}
			} 
		}
		$dir = implode(' ', $directors);
		return $dir;
	}

	public function casts_term($term_id){
		$id           = $term_id;
		$id_serie     = get_term_meta( $id, 'tr_id_post', true );
		$terms        = wp_get_post_terms( $id_serie , array( 'cast_tv' ) );
		$number_actor = count($terms);
		$cas = false;
		if($terms){
			$casts = array();
			foreach ( $terms as $key => $term ) {
				if ($term === end($terms)) {
					$casts[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
				} else {
					$casts[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
				}
			} 
		}
		if(isset($casts)){
			$cas = implode(', ', $casts); }
		return $cas;
	}

	public function categories_term($term_id){
		$id       = $term_id;
		$id_serie = get_term_meta( $id, 'tr_id_post', true );
		$terms    = wp_get_post_terms( $id_serie , array( 'category' ) );
		if($terms){
			$categories = array();
			foreach ( $terms as $term ) {
				$categories[] ='<a href="'.get_term_link( $term ).'">'.$term->name.'</a>';
			} 
		}
		$cats = implode(', ', $categories);
		return $cats;
	}

	public function get_serie_id($term_id) {
		$serieID = get_term_meta( $term_id, 'tr_id_post', true );
		return $serieID;
	}

	public function get_episodes_by_season($term_id) {
		$episodes = false;
		$serie_id    = get_term_meta( $term_id, 'tr_id_post', true );
		$tempCurrent = get_term_meta($term_id, 'season_number', true);
		$data_key   = 'value';
		$data_value = $tempCurrent;
		if (!$tempCurrent) {
			$data_key   = 'compare';
			$data_value = 'NOT EXISTS';
		}
		$episodes = get_terms( 'episodes', array(
            'orderby'    => 'meta_value_num',
            'order'      => 'ASC',
            'hide_empty' => 0,
            'meta_query' => array(
                'relation' => 'AND',
                array(
					'key'     => 'episode_number',
					'compare' => 'EXISTS',
                ),
                array(
					'key'   => 'tr_id_post',
					'value' => $serie_id 
                ),
                array(
                    'key'     => 'season_number',
                    $data_key => $data_value
                )
            )
        ) );  
		return $episodes;
	}


	public function number_episodes_term($term_id){
		$number = get_term_meta($term_id, 'episode_number', true);
		if(!$number){ $number = 0; }
		return $number;
	}


	public function image_term_episode($term_id, $size){
		$id            = $term_id;
		$image_hotlink = get_term_meta( $id, 'still_path_hotlink', true );
		$image         = get_term_meta( $id, 'still_path', true );
		$id_serie      = get_term_meta( $id, 'tr_id_post', true );
		if($size == 'full')
			$size = 'w1280';
        if( isset($image) and !empty($image) ) {
        	if($size == 'w1280'){
        		$return = '<img src="//image.tmdb.org/t/p/'.$size.$image_hotlink.'" alt="'.sprintf( __('Image %s', 'toroflix'), get_the_title($id_serie)).'">';
        	}else {
        		$return = '<img src="'.wp_get_attachment_url($image).'" alt="'.sprintf( __('Image %s', 'toroflix'), get_the_title($id_serie)).'">';
        	}
        }elseif( isset( $image_hotlink ) and !empty( $image_hotlink ) ) {
            if (filter_var($image_hotlink, FILTER_VALIDATE_URL) === FALSE) {
                $return = '<img src="//image.tmdb.org/t/p/'.$size.$image_hotlink.'" alt="'.sprintf( __('Image %s', 'toroflix'), get_the_title($id_serie)).'">';
            }else{
                $return = '<img src="'.$image_hotlink.'" alt="'.sprintf( __('Image %s', 'toroflix'), get_the_title($id_serie)).'">';
            }
        }else{
        	$return = self::backdrop_movie($id_serie, $size);
        }
        return $return;
	}


	public function backdrop_movie($post_id, $size){

		//Url Image
		$backdrop_url   = get_post_meta($post_id, 'poster_hotlink', true);

		//Load Image
	    $backdrop_field = get_post_meta($post_id, 'field_backdrop', true);

	    if( $backdrop_field ) {
	    	$url_backdrop   = wp_get_attachment_image_src($backdrop_field, 'full');
	    	return '<img class="TPostBg" src="'.$url_backdrop[0].'" alt="'.__('Background', 'toroflix').'">';
	    } elseif ( $backdrop_url ) {
	    	if (filter_var($backdrop_url, FILTER_VALIDATE_URL) === FALSE) {
		        return '<img loading="lazy" class="TPostBg" src="//image.tmdb.org/t/p/'.$size.''.$backdrop_url.'" alt="'.__('Background', 'toroflix').'">'; 
		    } else {
		    	return '<img loading="lazy" class="TPostBg" src="'.$backdrop_url.'" alt="'.__('Background', 'toroflix').'">'; 
		    } 
	    } else {
	    	return false;
	    }
	}

	public function title_term($term, $term_id){
		$name = get_term_meta($term_id, 'name', true);
		if(!$name){ $name = $term->name; }
		return $name;
	} 

	public function duration_term($term_id){
		$id       = $term_id;
		$id_serie = get_term_meta( $id, 'tr_id_post', true );
		$duration = false;
		if(get_post_meta( $id_serie, 'field_runtime', true)){
			$duration = get_post_meta( $id_serie, 'field_runtime', true)[0] . ' min';
		}
		return $duration;
	}

	public function date_term($term_id){
		$newDate = false;
		if(get_term_meta($term_id, 'air_date', true)){
			$dates = get_term_meta($term_id, 'air_date', true);
			$newDate = date("d-m-Y", strtotime($dates));
		}
		return $newDate;
	}


}