<?php
class TOROFLIX_public_ajax {

    /*SEND REPORT*/
    public function send_report() {
          if( isset( $_POST[ 'action' ] ) ) {
            $message  = $_POST['message'];
            $postType = $_POST['postType'];
            $postID   = $_POST['postID'];
            add_post_meta( $postID, 'reporflix', $message );
            $res = [
                'res'      => 'conexion',
                'message'  => $message,
                'postType' => $postType,
                'postID'   => $postID,
            ];
            echo json_encode($res);
            wp_die();
          }
    }

    /*vote*/
    public function toroflix_vote_tax() {
        if( isset( $_POST[ 'action' ] ) ) {
            $id    = $_POST['id'];
            $stars = $_POST['stars'];
            $currentvotes = get_term_meta( $id, 'vote', true );
            $currentvotes = $currentvotes + $stars;
            $numvote = get_term_meta( $id, 'numvote', true );
            $numvote = $numvote + 1;
            update_term_meta($id, 'vote', $currentvotes);
            update_term_meta($id, 'numvote', $numvote);
            $numvote = get_term_meta( $id, 'numvote', true);
            $vote = get_term_meta( $id, 'vote', true);
            if(!$numvote or $numvote == 0){
                $prom = 0;
                $percentage = 0;
                $perc = 0;
                $numvote = 0;
            } else {
                $prom = round($vote / $numvote);
                $percentage = ( ($prom * 100)/(10) );
                $perc       = ( ($prom * 10)/(10) );
            }
            $res = [
                'res'        => 'conexion',
                'id'         => $id,
                'percentage' => $percentage,
                'perc'       => $perc,
                'prom'       => $prom,
                'numvote'    => $numvote
            ];
            echo json_encode($res);
            wp_die();
        }
    }
    public function toroflix_vote_serie() {
        if( isset( $_POST[ 'action' ] ) ) {
            $id    = $_POST['id'];
            $stars = $_POST['stars'];
            $currentvotes = get_post_meta( $id, 'vote', true );
            $currentvotes = $currentvotes + $stars;
            $numvote = get_post_meta( $id, 'numvote', true );
            $numvote = $numvote + 1;
            update_post_meta($id, 'vote', $currentvotes);
            update_post_meta($id, 'numvote', $numvote);
            $numvote = get_post_meta( $id, 'numvote', true);
            $vote = get_post_meta( $id, 'vote', true);
            if(!$numvote or $numvote == 0){
                $prom = 0;
                $percentage = 0;
                $perc = 0;
                $numvote = 0;
            } else {
                $prom = round($vote / $numvote);
                $percentage = ( ($prom * 100)/(10) );
                $perc       = ( ($prom * 10)/(10) );
            }
            $res = [
                'res'        => 'conexion',
                'id'         => $id,
                'percentage' => $percentage,
                'perc'       => $perc,
                'prom'       => $prom,
                'numvote'    => $numvote
            ];
            echo json_encode($res);
            wp_die();
        }
    }
    /*Like*/
    public function toroflix_like_mov() {
        if( isset( $_POST[ 'action' ] ) ) {
            $type = $_POST['like'];
            $id   = $_POST['id'];
            
            if($type == 'like'){
                $currentvotes = get_post_meta($id, 'like_flix', true);
                if(!$currentvotes) $currentvotes = 0;
                $currentvotes = $currentvotes + 1;
                update_post_meta( $id, 'like_flix', $currentvotes);
            } elseif($type == 'unlike'){
                $currentvotes = get_post_meta($id, 'unlike_flix', true);
                if(!$currentvotes) $currentvotes = 0;
                $currentvotes = $currentvotes + 1;
                update_post_meta($id, 'unlike_flix', $currentvotes);
            }
            
            $vote_up   = get_post_meta($id, 'like_flix', true);
            
            if(!$vote_up)
                $vote_up = 0;
            $vote_down = get_post_meta($id, 'unlike_flix', true);
            
            if(!$vote_down)
                $vote_down = 0;
            $res = [
                'res'    => 'conexion',
                'like'   => $vote_up,
                'unlike' => $vote_down
            ];
            echo json_encode($res);
            wp_die();
        }
    }
    /*Search suggest*/
    public function toroflix_search_suggest() {
        if( isset( $_POST[ 'action' ] ) ) { 
           $args = array(
                'post_type'           => array('movies', 'series'),
                'post_status'         => 'publish',
                'order'               => 'DESC',
                'orderby'             => 'date',
                's'                   => $_POST['term'],
                'no_found_rows'       => true,
                'ignore_sticky_posts' => true,
                'posts_per_page'      => 10
            );
           $the_query = new WP_Query( $args );
           if ( $the_query->have_posts() ) : ?>
                <ul class="ResultList">
                    <?php
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        $loop = new TOROFLIX_Movies();
                        $sm = $loop->is_serie_movie();  ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <div class="Title"><?php the_title(); ?> <span class="TpTv BgA"><?php echo $sm; ?></span></div>
                            </a>
                        </li>
                    <?php endwhile; endif; wp_reset_query(); ?>
                </ul>
            <?php exit();
        }
    }
    /*Player Change*/
    public function player_change() {
        if( isset( $_POST[ 'action' ] ) ) { 
            $term_id  = $_POST['id'];
            $typ  = $_POST['typ'];
            $loop = new TOROFLIX_Movies();
            $k = $_POST['key'];
            $tagiframe = 'iframe';
            if($typ == 'episode'){
                $links    = $loop->tr_links_episodes($term_id); 
                foreach ($links['online'] as $key => $online) { 
                    if($key == $k ){ ?>
                        <<?php echo $tagiframe; ?> src="<?php echo esc_url( home_url( '/?trembed='.$online['i'].'&trid='.$term_id ) ).'&trtype=2';  ?>" allowfullscreen frameborder="0"></<?php echo $tagiframe; ?>>
                    <?php } 
                }
            } elseif($typ == 'movie'){
                $links    = $loop->tr_links_movies($term_id); 
                foreach ($links['online'] as $key => $online) { 
                    if($key == $k ){ ?>
                        <<?php echo $tagiframe; ?> src="<?php echo esc_url( home_url( '/?trembed='.$online['i'].'&trid='.$term_id ) ).'&trtype=1';  ?>" allowfullscreen frameborder="0"></<?php echo $tagiframe; ?>>
                    <?php } 
                }
            }
            wp_die();
        }
    }

    public function player_change_new() {
        if( isset( $_POST[ 'action' ] ) ) { 
            $term_id   = $_POST['id'];
            $typ       = $_POST['typ'];
            $key       = $_POST['key'];
            $tagiframe = 'iframe';

            if($typ == 'episode'){

                $links_total = get_term_meta( $term_id, 'trgrabber_tlinks', true ) == '' ? 0: get_term_meta( $term_id, 'trgrabber_tlinks', true );
                $links       = array();
        
                if( isset( $links_total ) ){
                    $links_total = $links_total - 1;
        
                    for ($i = 0; $i <= $links_total; $i++) {

                        if($i == $key){
                            
                            $type    = $link['type'] == '' ? 1 : $link['type'];
                            $lang    = $link['lang'] == '' ? 0 : $link['lang'];
                            $quality = $link['quality'] == '' ? 0 : $link['quality'];
                            $server  = $link['server'] == '' ? 0 : $link['server'];
                            $linkk   = $link['link'] == '' ? '' : trgrabber_base64de( $link['link'] );
                            $date    = $link['date'] == '' ? '' : $link['date'];

                            ?>

                            <<?php echo $tagiframe; ?> src="<?php echo esc_url( home_url( '/?trembed='.$i.'&trid='.$term_id ) ).'&trtype=2';  ?>" allowfullscreen frameborder="0"></<?php echo $tagiframe; ?>>

                            <?php

                        }
                    }
                }
               
            } elseif($typ == 'movie'){

                $links_total = get_post_meta( $term_id, 'trgrabber_tlinks', true ) == '' ? 0: get_post_meta( $term_id, 'trgrabber_tlinks', true );
                $links       = array();
        
                if( isset( $links_total ) ){
                    $links_total = $links_total - 1;
        
                    for ($i = 0; $i <= $links_total; $i++) {

                        if($i == $key){
                            $link    = unserialize ( get_post_meta( $post_id, 'trglinks_'.$i, true ) );
                            $type    = $link['type'] == '' ? 1 : $link['type'];
                            $lang    = $link['lang'] == '' ? 0 : $link['lang'];
                            $quality = $link['quality'] == '' ? 0 : $link['quality'];
                            $server  = $link['server'] == '' ? 0 : $link['server'];
                            $linkk   = $link['link'] == '' ? '' : trgrabber_base64de( $link['link'] );
                            $date    = $link['date'] == '' ? '' : $link['date'];

                            ?>

                            <<?php echo $tagiframe; ?> src="<?php echo esc_url( home_url( '/?trembed='.$i.'&trid='.$term_id ) ).'&trtype=1';  ?>" allowfullscreen frameborder="0"></<?php echo $tagiframe; ?>>

                            <?php

                        }
                    }
                }
               
            }
            wp_die();
        }
    }
    /*Show Episodes*/
    public function episode_view() {
        if( isset( $_POST[ 'action' ] ) ) { 
            $post = $_POST['post'];
            $season   = $_POST['season'];
            $episodes = get_terms( 'episodes', array(
                'orderby'    => 'meta_value_num',
                'order'      => 'ASC',
                'hide_empty' => 0,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'episode_number',
                        'type' => 'NUMERIC',
                    ),
                    array(
                        'key' => 'tr_id_post',
                        'value' => $post
                    ),
                    array(
                        'key' => 'season_number',
                        'value' =>  (int) $season,
                    )
                )
            ) ); 
            if($episodes){ ?>
                <table>
                    <tbody>
                        <?php foreach ($episodes as $key => $episode) {
                            $link = get_term_link( $episode ); ?>
                            <tr class="Viewed">
                                <td><span class="Num"><?php echo TOROFLIX_Movies::number_episodes_term($episode); ?></span></td>
                                <td class="MvTbImg B"><a href="<?php echo $link; ?>" class="MvTbImg"><?php echo TOROFLIX_Movies::image_term_episode($episode, 'w92'); ?></a></td>
                                <td class="MvTbTtl"><a href="<?php echo $link; ?>"><?php echo TOROFLIX_Movies::title_term($episode); ?></a> <span><?php echo TOROFLIX_Movies::date_term($episode); ?></span></td>
                                <td class="MvTbPly"><a href="<?php echo $link; ?>" class="AAIco-play_circle_outline ClA"></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php }
            wp_die();
        }
    }
   /*Sorted by*/
   public function changue_post_by() {
        if( isset( $_POST[ 'action' ] ) ) {
            $type = $_POST['type'];
            $posttype = $_POST['posttype'];
            if($type == "#Latest"){
                $args = array(
                    'posts_per_page' => 15, 
                    'post_type'      => $posttype,
                    'post_status'    => 'publish',
                ); 
            } elseif($type == "#Views"){
                $args = array(
                    'posts_per_page' => 15, 
                    'post_type'      => $posttype,
                    'post_status'    => 'publish',
                    'meta_key'       => 'views', 
                    'orderby'        => 'meta_value_num', 
                    'order'          => 'DESC',
                ); 
            }
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ) : $the_query->the_post();
                   get_template_part("public/partials/template/loop-principal"); 
               endwhile; 
            endif; wp_reset_query();
            wp_die();
        }
   }
}