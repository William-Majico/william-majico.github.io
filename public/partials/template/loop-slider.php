<?php 

$id         = get_The_ID();
$loop       = new TOROFLIX_Movie(); 
$year       = $loop->year();
$serieMovie = $loop->is_serie_movie();
$duration   = $loop->duration();
$views      = $loop->views();
$votes      = $loop->votes($id);
$excerpt    = $loop->get_excerpt(220);
$dirUnique  = $loop->director_unique();
$genres     = $loop->get_categories();
$castBy2    = $loop->get_cast_by_2();

$imgRating  = TOROFLIX_DIR_URI . 'public/img/cnt/rating_on.gif';

?>
<div class="TPostMv">
    <article class="TPost A">
        <header class="Container">
            <div class="TPMvCn">
                <a href="<?php the_permalink(); ?>"><div class="Title"><?php the_title(); ?></div></a>
                <div class="Info">
                    <div class="Vote">
                        <div class="post-ratings">
                            <img src="<?php echo $imgRating; ?>">
                            <span class="st-vote"><?php echo $votes; ?></span>
                        </div>
                    </div>
                    <?php echo ($year) ? '<span class="Date">'.$year.'</span>' : ''; ?>
                    <span class="Qlty"><?php echo $serieMovie; ?></span>
                    <?php echo ($duration) ? '<span class="Time">'.$duration.'</span>' : ''; ?>
                    <span class="Views AAIco-remove_red_eye"><?php echo $views; ?></span>
                </div>
                <div class="Description">
                    <?php echo $excerpt;

                    echo ($dirUnique) ? '<p class="Director"><span>' .__('Director', 'toroflix').':</span> ' . $dirUnique . '</p>' : ''; 

                    echo ($genres) ? '<p class="Genre"><span>' .__('Genre', 'toroflix').':</span> ' . $genres . '</p>' : '';

                    echo ($castBy2) ? '<p class="Cast"><span>' .__('Cast', 'toroflix').':</span> ' . $castBy2 . '</p>' : '';

                    ?>
                </div>
                <a href="<?php the_permalink(); ?>" class="Button TPlay AAIco-play_circle_outline"><strong><?php echo toroflix_lang('Watch Now', 'lang_watch_now' ) ?></strong></a>
            </div>
            <div class="Image">
                <figure class="Objf"><?php echo $loop->backdrop_movie(get_the_ID(), 'original'); ?></figure>
            </div>
        </header>
    </article>
</div>