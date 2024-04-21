<?php 

$episode         = new TOROFLIX_Episode;
$term_id         = $args['term_id'];
$term            = $args['term'];
$links           = $episode->tr_links_episodes($term_id);
$links['online'] = !empty($links['online']) ? $links['online'] : '';
$enable_tab_lang = get_option('enable_tab_lang', false);
?>

<div class="TPost A D">
    <div class="Container">

    <?php if($enable_tab_lang){ 

        $players_enable = $links['online']; 
        $lang_pl = array();

        foreach($players_enable as $k => $player) {
            if( $player['lang'] && $player['lang']!= '' ){
                $lng = $player['lang'];
            
            } else { $lng = 'Undefined';  }
            
            if ( !in_array($lng, $lang_pl) ) {
                $lang_pl[] = $lng;
            }
        } 

        if( count($lang_pl) > 0 ){ 
            ?>
            <div class="optns-bx">
                <?php foreach($lang_pl as $k => $lpl){

                    if($lpl == 'Undefined'){
                        $lng_term_name = 'Undefined';
                        $lnt = 0;
                    } else {
                        $lng_term = get_term( $lpl, 'language' ); 
                        $lng_term_name = $lng_term->name;
                        $lnt = $lpl;
                    } ?>

                    <div class="drpdn">
                        <button class="bstd Button">
                            <span><?php echo $lng_term_name; ?> <span><?php _e('Language', 'toroflix'); ?></span></span>
                            <i class="fa-chevron-down"></i>
                        </button>
                        <ul class="optnslst trsrcbx">
                            <?php $kk = 0; 
                            foreach ($links['online'] as $key => $online) { 
                                
                                if($online['lang'] == $lnt) { 
                                    $count = $kk + 1;
                                    
                                    $count = sprintf("%02d", $count);
                                
                                    if( $online['server'] && $online['server']!= '' ){
                                        $server_term = get_term( $online['server'], 'server' ); 
                                        $server_term_name = strtoupper($server_term->name);
                                    } else {
                                        $server_term_name = '';
                                    }
                                
                                    if( $online['lang'] && $online['lang']!= '' ){
                                        $lang_term = get_term( $online['lang'], 'language' );
                                        $lang_term_name = $lang_term->name;
                                    } else {
                                        $lang_term_name = '';
                                    }
                                
                                    if( $online['quality'] && $online['quality']!= '' ){
                                        $quality_term = get_term( $online['quality'], 'quality' );
                                        $quality_term_name = strtoupper($quality_term->name);
                                    } else {
                                        $quality_term_name = '';
                                    } 
                                    
                                    ?>
                                    <li>
                                        <button  data-typ="episode" data-key="<?php echo $online['i']; ?>" data-id="<?php echo $term_id; ?>" class="Button sgty <?php if($kk == 0 && $k == 0){ echo 'on'; } ?>">
                                            <span class="nmopt"><?php echo $count; ?></span>
                                            <span><?php echo strtoupper($lng_term_name); ?> <span><?php echo $quality_term_name; ?> <?php if( $quality_term_name != '') { echo '• '; } ?><?php if( $online['server'] && $online['server']!= '' ) { echo $server_term_name; } ?></span></span>
                                        </button>
                                    </li>

                                <?php $kk++; } ?>
                        
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        <?php 
        }
    } ?>


        <div class="VideoPlayer">
            <?php get_template_part( 'public/partials/template/episode/episode', 'player', array( 'term_id' => $term_id, 'links' => $links['online'] ) ); ?>
        </div>
        <div class="Image">
            <figure class="Objf"><?php echo $episode->image_term_episode($term_id, 'full'); ?></figure>
        </div>
    </div>
</div>