<?php 
class TOROFLIX_Movie{

	public function rating($id){
		$rating = get_post_meta( $id, 'rating', true );
		if(!$rating) $rating = 0;
		return $rating;
	}

	public function get_excerpt( $count ) {
		global $post;
		$permalink = get_permalink($post->ID);
		$excerpt = get_the_content();
		$excerpt = strip_tags($excerpt);
		$excerpt = substr($excerpt, 0, $count);
		$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = '<p>'.$excerpt.' ... </p>';
		return $excerpt;
	}

	# Get votes 
	public function votes($id){
		$votes = get_post_meta( $id, 'vote', true );
		if(!$votes) $votes = 0;
		return $votes;
	}

	#Is movie or serie
	public function is_serie_movie(){
		global $post;
		if( 'movies' == get_post_type($post->ID) ) {
			$type = __('Movie', 'toroflix');
 		} elseif( 'series' == get_post_type($post->ID) ) {
 			$type = __('Serie', 'toroflix');
 		}
 		return $type;
	}

	#Links Players & Downloads
	public function tr_links_movies($post_id) {

	    $links_total = get_post_meta( $post_id, 'trgrabber_tlinks', true ) == '' ? 0: get_post_meta( $post_id, 'trgrabber_tlinks', true );
	    $links       = array();

	    if( isset( $links_total ) ){
	    	$links_total = $links_total - 1;

	        for ($i = 0; $i <= $links_total; $i++) {
				$link    = unserialize ( get_post_meta( $post_id, 'trglinks_'.$i, true ) );
				$type    = $link['type'] == '' ? 1 : $link['type'];
				$lang    = $link['lang'] == '' ? 0 : $link['lang'];
				$quality = $link['quality'] == '' ? 0 : $link['quality'];
				$server  = $link['server'] == '' ? 0 : $link['server'];
				$linkk   = $link['link'] == '' ? '' : trgrabber_base64de( $link['link'] );
				$date    = $link['date'] == '' ? '' : $link['date'];
	            
				if( $type == 1 and $linkk!='' ) {
	                $links['online'][] = array(
	                    'i'       => $i,
	                    'lang'    => $lang,
	                    'quality' => $quality,
	                    'server'  => $server,
	                    'link'    => $linkk,
	                    'date'    => $date
	                );
	            } elseif( $linkk!='' ){
	                $links['downloads'][] = array(
	                    'i'       => $i,
	                    'lang'    => $lang,
	                    'quality' => $quality,
	                    'server'  => $server,
	                    'link'    => $linkk,
	                    'date'    => $date
	                );
	            }
	        }
	        return $links;
	    }
	}


	# GET Quality by movies
	public function get_quality($post_id){
		global $post;
		$quality_array = array();
		$qual          = false;
	    if ( 'movies' == get_post_type($post_id) ) {
			$links           = self::tr_links_movies($post_id);
			$links['online'] = !empty($links['online']) ? $links['online'] : false;
			if($links['online']) {
				foreach ($links['online'] as $key => $online) { 
					if($online['quality'] && $online['quality']!= '' ){ 
						$quality_term = get_term( $online['quality'], 'quality' ); 
					} 
					if(isset($quality_term )){
						if ( !in_array( $quality_term, $quality_array ) ) {
							$quality_array[] = $quality_term;
						}
					}
				}
			}
		}

		$r = array();
		$rs = false;
		if(count($quality_array) > 0) {
			foreach ($quality_array as $key => $q) {
				if($q != '') $r[] = '<span class="Qlty">'.$q->name.'</span>';
			}
			$rs = implode(' ', $r);
		}
		return $rs;
	}


	#GET Lang by movies
	public function get_lang(){
		global $post;
		$quality_array = array();
		$qual          = array();
	    if ( 'movies' == get_post_type($post->ID) ) {
			$links =  self::tr_links_movies($post->ID);
			$links['online'] = !empty($links['online']) ? $links['online'] : false;
			if($links['online']) {
				foreach ($links['online'] as $key => $online) { 
					$quald = false;
					if( $online['lang'] && $online['lang']!= '' ){ $quality_term = get_term( $online['lang'], 'language' ); }
					if(isset( $quality_term )){
						if ( !in_array( $quality_term, $quality_array ) ) {
							$quality_array[] = $quality_term;
							$tid = $quality_term->term_id;
							$quald = get_term_meta( $tid, 'image', true );
							if($quald){
								$qual[] ='<img src="'.wp_get_attachment_url($quald).'">';
							} else if(get_term_meta( $tid, 'image_hotlink', true )){
								$quald = get_term_meta( $tid, 'image_hotlink', true );
								if($quald){
								$qual[] ='<img src="'.$quald.'">'; }
							} else {
								$qual[] = '<span class="Lng">'.$quality_term->name.'</span>';
							}
							
						}
					}
				}
			}
		}
		$b = implode('', $qual);
		return $b;
	}


	#Backdrop Movies
	public function backdrop_movie($post_id, $size){

		//Url Image
		$backdrop_url   = get_post_meta($post_id, 'backdrop_hotlink', true);

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


	#Trailer 
	public function trailer($post_id){
		$trailer = get_post_meta( $post_id, 'field_trailer', true );
		if(!$trailer)
			$trailer = false;
		return $trailer;
	}

	//Year
	public function year(){
		global $post;
		if ( 'movies' == get_post_type($post->ID) ) {
			$fecha = get_post_meta( $post->ID, 'field_release_year', true );
		} elseif( 'series' == get_post_type($post->ID) ){
			$fecha = get_post_meta( $post->ID, 'field_date', true );
		}
		if($fecha){ 
			$fechas = explode('-', $fecha);
			return $fechas[0];
		} else { return false; }
	}


	//Duration 
	public function duration(){
		global $post;
		$duration = false;
		if ( 'movies' == get_post_type($post->ID) ) {
			if(get_post_meta( $post->ID, 'field_runtime', true))
				$duration = get_post_meta( $post->ID, 'field_runtime', true);
		} elseif( 'series' == get_post_type($post->ID) ){
			$dur = get_post_meta( $post->ID, 'field_runtime', true)[0];
			if($dur){
				$dur = str_replace(',', '-', $dur);
				$duration = $dur . ' min';
			}
		}
		return $duration;
	}

	//Views 

	public function views(){
		global $post;
		$views = false;
		$views = get_post_meta( $post->ID, 'views', true );
		if(!$views){ $views = 0; }
		return $views;
	}


	public function get_tags_sin(){
		global $post;
		$cas = false;
		$terms = wp_get_post_terms( $post->ID , array( 'post_tag' ) );
		if(! empty($terms) ){
			$number_actor = count($terms);
			$casts = array();
			foreach ( $terms as $key => $term ) {
				if($key < 12){
					if ($term === end($terms)) {
						$casts[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
					} else {
						$casts[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
					}
				}
			} 
		}
		if(isset($casts))
			$cas = implode('<span class="dot-sh">,</span> ', $casts);
		return $cas;
	}

	#Actor Series and Movies
	public function casts(){
		global $post;
		$cas = false;
		if ( 'movies' == get_post_type($post->ID) ) {
			$terms = wp_get_post_terms( $post->ID , array( 'cast' ) );
		} elseif( 'series' == get_post_type($post->ID) ){
			$terms = wp_get_post_terms( $post->ID , array( 'cast_tv' ) );
		}
		if(! empty($terms) ){
			$number_actor = count($terms);
			$casts = array();
			foreach ( $terms as $key => $term ) {
				if($key < 12){
					if ($term === end($terms)) {
						$casts[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
					} else {
						$casts[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
					}
				}
			} 
		}
		if(isset($casts))
			$cas = implode('<span class="dot-sh">,</span> ', $casts);
		return $cas;
	}

	#Director Movies and Series
	public function director(){
		global $post;
		$directors = array();
		if ( 'movies' == get_post_type($post->ID) ) {
			$terms = wp_get_post_terms( $post->ID , array( 'directors' ) );
		} elseif( 'series' == get_post_type($post->ID) ){
			$terms = wp_get_post_terms( $post->ID , array( 'directors_tv' ) );
		}
		if($terms){
			$directors = array();
			foreach ( $terms as $term ) {
				if ($term === end($terms)) {
					$directors[] = '<span class="tt-at"><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></span>';
				} else {
					$directors[] = '<span class="tt-at"><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>,</span>';
				}
			} 
		}
		$dir = implode(' ', $directors);
		return $dir;
	}

	#Director unique - Movies and Series
	public function director_unique(){
		global $post;
		$director = false;
		if ( 'movies' == get_post_type($post->ID) ) {
			$directors = wp_get_post_terms( $post->ID , array( 'directors' ) );
		} elseif( 'series' == get_post_type($post->ID) ){
			$directors = wp_get_post_terms( $post->ID , array( 'directors_tv' ) );
		}
		if($directors){
			$director = '<a href="'. esc_url( get_term_link( $directors[0] ) ) .'">'. $directors[0]->name .'</a>';
		}
		return $director;
	}


	/**
	 * MOVIES and SERIES
	 * 	L Get categories
	 */
	public function get_categories(){
		global $post;
		$cats = false;
		$terms = get_the_category($post->ID);
		if(!empty( $terms ) ){
			$categories = array();
			foreach ( $terms as $term ) {
				$categories[] ='<a href="'.get_category_link( $term ).'">'.$term->name.'</a>';
			} 
			$cats = implode(', ', $categories);
		}
		return $cats;
	}
	
	public function get_tags(){
		global $post;
		return get_the_tags( $post->ID );
	}

	public function get_cast_by_2(){
		global $post;
		$cas = false;
		if ( 'movies' == get_post_type($post->ID) ) {
			$terms = wp_get_post_terms( $post->ID , array( 'cast' ) );
		} elseif( 'series' == get_post_type($post->ID) ){
			$terms = wp_get_post_terms( $post->ID , array( 'cast_tv' ) );
		}
		if($terms){
			$number_actor = count($terms);
			$casts = array();
			foreach ( $terms as $key => $term ) {
				if($key < 2){
					if ($term === end($terms)) {
						$casts[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
					} else {
						$casts[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
					}
				}
			} 
			$cas = implode(', ', $casts);
		}
		if(isset($number_actor)){
			if($number_actor > 2) {
				$cas = $cas . ' ...';
			}
		}
		return $cas;
	}

	#List categories Series and Movies
	public function categories(){
		global $post;
		$terms = wp_get_post_terms( $post->ID , array( 'category' ) );
		if($terms){
			$categories = array();
			foreach ( $terms as $term ) {
				$categories[] ='<a href="'.get_term_link( $term ).'">'.$term->name.'</a>';
			} 
		}
		$cats = implode(', ', $categories);
		return $cats;
	}


}
