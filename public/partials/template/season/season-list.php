<?php 

$season         = new TOROFLIX_Seasons;
$term_id        = $args['term_id'];
$term           = $args['term'];
$serie_id       = $season->get_serie_id($term_id);
$season_current = $season->number_season_term($term_id); 
$listEpisodes   = $season->get_episodes_by_season($term_id);

?>

<section class="SeasonBx">
    <div class="Top AAIco-playlist_play">
        <div class="Title"><?php echo get_the_title($serie_id); ?> - <?php _e('Season', 'toroflix'); ?> <span><?php echo $season_current; ?></span></div>
    </div>
    <div class="TPTblCn">
        <table>
            <tbody>
            	<?php
	            if($listEpisodes){  
	            	foreach ($listEpisodes as $key => $ep) { 
						$link  = get_term_link( $ep );
						$title = $season->title_term($ep, $ep->term_id);
						$date  = $season->date_term($ep->term_id); ?>
                        <tr class="Viewed">
                            <td><span class="Num"><?php echo $season->number_episodes_term($ep->term_id); ?></span></td>
                            <td class="MvTbImg B"><a href="<?php echo $link; ?>" class="MvTbImg"><?php echo $season->image_term_episode($ep->term_id, 'w92'); ?></a></td>
                            <td class="MvTbTtl"><a href="<?php echo $link; ?>"><?php echo $title; ?></a>
                            	<?php if($date){ ?><span><?php echo $date; ?></span><?php } ?></td>
                            <td class="MvTbPly"><a href="<?php echo $link; ?>" class="AAIco-play_circle_outline ClA"></a></td>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>
</section>