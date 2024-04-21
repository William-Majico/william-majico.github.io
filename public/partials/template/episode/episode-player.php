<?php 

$term_id     = $args['term_id'];
$linksOnline = $args['links']; 
$enable_tab_lang = get_option('enable_tab_lang', false);



$loop = new TOROFLIX_Episode;
$season_number = $loop->number_season_term($term_id);
$seasons = $season_number== 0 ? 'special' : $season_number;

$episode_number = $loop->number_episodes_term($term_id);
$episodes = $episode_number== 0 ? 0 : $episode_number;


?>

<div id="VideoOption01" class="Video on">
    <?php $tagiframe = 'iframe'; ?>
    <<?php echo $tagiframe; ?> src="<?php echo esc_url( home_url( '/?trembed='.$linksOnline[0]['i'].'&trid='.$term_id ) ).'&trtype=2';  ?>" allowfullscreen frameborder="0"></<?php echo $tagiframe; ?>>
</div>

<section id="VidOpt" class="VideoOptions">
    <div class="Top AAIco-list">
        <div class="Title"><?php _e('Options', 'toroflix'); ?></div>
    </div>

  
        <ul class="ListOptions">
            <?php foreach ($linksOnline as $key => $online) { 
                $count = $key + 1; 
                $count = sprintf("%02d", $count);
                //Server
                if($online['server']){
                    $server_term = get_term( $online['server'], 'server' ); } 
                // lang
                if($online['lang'] && $online['lang'] != ''){
                $lang_term = get_term( $online['lang'], 'language' ); }
                // quality
                if( $online['quality'] && $online['quality'] != ''){
                    $quality_term = get_term( $online['quality'], 'quality' ); }   ?>
                <li data-typ="episode" data-key="<?php echo $key; ?>" data-id="<?php echo $term_id; ?>" class="OptionBx <?php if($key == 0){ echo 'on'; } ?>" data-VidOpt="VideoOption<?php echo $count; ?>">
                    <div class="Optntl"><?php _e('Option', 'toroflix'); ?> <span><?php echo $count; ?></span></div>
                    
                    <?php if(isset($lang_term )){ ?>
                    <p class="AAIco-language"><?php echo $lang_term->name; ?></p><?php } ?>

                    <p class="AAIco-dns"><?php if(isset($server_term->name)){ echo $server_term->name; } else {echo 'Server';} ?></p>

                    <?php if(isset($quality_term)){ ?>
                    <p class="AAIco-equalizer"><?php  echo $quality_term->name; ?></p><?php } ?>

                    <span class="Button"><?php _e('WATCH ONLINE', 'toroflix'); ?></span>
                </li>
            <?php } ?>
        </ul>
 
</section>


<?php if(!$enable_tab_lang){ ?>
    <span class="BtnOptions AAIco-list AATggl" data-tggl="VidOpt"><i class="AAIco-clear"></i></span>
<?php } ?>
<span class="BtnLight AAIco-lightbulb_outline lgtbx-lnk"></span>
<span class="lgtbx"></span>


<?php
if ($seasons == 'special') {
    $args = array(
        array(
            'relation' => 'AND',
            'episode_number' => array(
                'key' => 'episode_number',
                'compare' => '=',
                'value' => ($episodes - 1)
            ),
            'season_number' => array(
                'key' => 'season_special',
                'compare' => '=',
                'value' => 1
            )
        )
    );
} else {
    $args = array(
        array(
            'relation' => 'AND',
            'episode_number' => array(
                'key' => 'episode_number',
                'compare' => '=',
                'value' => ($episodes - 1)
            ),
            'season_number' => array(
                'key' => 'season_number',
                'compare' => '=',
                'value' => $seasons
            )
        )
    );
}
$previous = wp_get_post_terms($post->ID, 'episodes', [
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'fields' => 'all',
    'meta_query' => $args
]);


if ($seasons == 'special') {
    $args = array(
        array(
            'relation' => 'AND',
            'episode_number' => array(
                'key' => 'episode_number',
                'compare' => '=',
                'value' => ($episodes + 1)
            ),
            'season_number' => array(
                'key' => 'season_special',
                'compare' => '=',
                'value' => 1
            )
        )
    );
} else {
    $args = array(
        array(
            'relation' => 'AND',
            'episode_number' => array(
                'key' => 'episode_number',
                'compare' => '=',
                'value' => ($episodes + 1)
            ),
            'season_number' => array(
                'key' => 'season_number',
                'compare' => '=',
                'value' => $seasons
            )
        )
    );
}

$next = wp_get_post_terms($post->ID, 'episodes', [
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'fields' => 'all',

    'meta_query' => $args
]);

?>

<div class="navepi tagcloud">
    <?php 
    if ($previous && $episodes > 1) {
            foreach ($previous as $k => $episode) {
                $slug = esc_url(get_term_link($episode));
                if ($k == 0) {
                    printf('<a href="%1$s" class="prev"> <i class="fa-arrow-left"></i> <span> %2$s </span> </a>', $slug, __('Previous', 'torovid'));
                }
            }
        } else {
            printf('<a href="javascript:void(0)" class="prev off"> <i class="fa-arrow-left"></i> <span> %1$s </span> </a>', __('Previous', 'torovid'));
    } ?>
    
    <a href="<?php the_permalink(); ?>" class="list prev"><i class="fa-list"></i> <span><?php _e('Episodes', 'toroflix'); ?></span></a>

    <?php  if ($next) {
        foreach ($next as $k => $episode) {
            $slug = esc_url(get_term_link($episode));

            if ($k == 0) {
                printf('<a href="%1$s" class="next"> <span> %2$s </span> <i class="fa-arrow-right"></i> </a>', $slug, __('Next', 'torofilm'));
            }
        }
    } else {
        printf('<a href="javascript:void(0)" class="next off"> <span> %1$s </span> <i class="fa-arrow-right"></i> </a>', __('Next', 'torofilm'));
    } ?>
    
</div>