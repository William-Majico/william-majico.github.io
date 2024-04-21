<?php 

$episode     = new TOROFLIX_Episode;
$term_id     = $args['term_id'];
$term        = $args['term'];
$image       = $args['image'];
$serie_id    = $episode->get_serie_id($term_id);
$title       = $episode->title_term($term, $term_id);
$year        = $episode->year_term($term_id);
$duration    = $episode->duration_term($term_id);
$director    = $episode->director_term($term_id);
$cast        = $episode->casts_term($term_id);
$genre       = $episode->categories_term($term_id);
$description = term_description( $term_id, 'episodes' );

?>
<article class="TPost A">
    <header class="Container">
        <div class="TPMvCn">
            <a href="javascript:void(0)">
                <h1 class="Title"><?php echo get_the_title($serie_id) . ' ' . $title; ?></h1>
            </a>
            <div class="Info">
                <?php echo ($year) ? '<span class="Date">'.$year.'</span>' : ''; ?>
                <?php echo ($duration) ? '<span class="Time">'.$duration.'</span>' : ''; ?>
                <a href="<?php echo get_the_permalink($serie_id); ?>"><?php _e('All Episodes', 'toroflix'); ?></a>
            </div>
            <div class="Description">
                <?php 

                echo ($description) ? $description : '';
                
                echo ($director) ? '<p class="Director"><span>'. __("Director", "toroflix"). ':</span> '. $director .'</p>' : '';
                
                echo ($cast) ? '<p class="Cast"><span>'. __("Cast", "toroflix"). ':</span> '. $cast .'</p>' : '';
                
                echo ($genre) ? '<p class="Genre"><span>'. __("Genre", "toroflix"). ':</span> '. $genre .'</p>' : '';
                
                ?>
            </div>
            <ul class="ShareList">
                <li><a href="javascript:void(0)" onclick="window.open ('https://www.facebook.com/sharer.php?u=<?php echo get_term_link($term); ?>', 'Facebook', 'toolbar=0, status=0, width=650, height=450');" class="fa-facebook"></a></li>
                <li><a href="javascript:void(0)" onclick="javascript:window.open('https://twitter.com/intent/tweet?original_referer=<?php echo get_term_link($term); ?>&amp;text=<?php echo $term->name; ?>&amp;tw_p=tweetbutton&amp;url=<?php echo get_term_link($term); ?>', 'Twitter', 'toolbar=0, status=0, width=650, height=450');" class="fa-twitter"></a></li>
            </ul>
        </div>
        <?php if($image){ ?>
            <div class="Image">
                <figure class="Objf"><?php echo $episode->image_term_episode($term_id, 'full'); ?></figure>
            </div>
        <?php } ?>
    </header>
</article>
