<?php 

$episode        = new TOROFLIX_Episode;
$term_id        = $args['term_id'];
$term           = $args['term'];
$linkDownload   = $args['links'];
$serie_id       = $episode->get_serie_id($term_id);
$season_current = $episode->number_season_term($term_id); 
$listEpisodes   = $episode->get_episodes_by_season($term_id);
$numberEpisodes = $episode->number_episodes_term($term_id);

?>

<section>
    <div class="Top AAIco-insert_link">
        <h2 class="Title"><?php _e('Links for The', 'toroflix'); ?> <?php echo get_the_title($serie_id); ?> - <?php _e('Season', 'toroflix'); ?> <?php echo $season_current; ?> - <?php _e('Episode', 'toroflix'); ?> <?php echo $numberEpisodes; ?></h2>
    </div>
    <ul class="MovieList Rows BX B06 C20 D03 E20">
    	<?php foreach ($linkDownload as $key => $download) {
    		$count = $key + 1; 
            $count = sprintf("%02d", $count); 
            if( $download['server']  ) {
            $server_term = get_term( $download['server'], 'server' ); }
            if( $download['lang'] ){
                $lang_term = get_term( $download['lang'], 'language' ); }
            if($download['quality']){
            $quality_term = get_term( $download['quality'], 'quality' ); }  ?>
            <li>
                <div class="OptionBx on">
                    <div class="Optntl"><?php _e('Option', 'toroflix'); ?> <span><?php echo $count; ?></span></div>
                    <?php if( $download['lang'] ) { ?>
                    <p class="AAIco-language"><?php echo $lang_term->name; ?></p><?php } ?>
                    <p class="AAIco-dns"><?php if(isset($server_term->name)){  echo $server_term->name; } ?></p>
                    <?php if($download['quality']){ ?>
                    <p class="AAIco-equalizer"><?php echo $quality_term->name; ?></p><?php } ?>
                    <a rel="nofollow" target="_blank" href="<?php echo esc_url( home_url( '/?trdownload='.$download['i'].'&t=ser&trid='.$term_id ) );  ?>" class="Button"><?php _e('Download', 'toroflix'); ?></a>
                </div>
            </li>
        <?php } ?>
    </ul>
</section>