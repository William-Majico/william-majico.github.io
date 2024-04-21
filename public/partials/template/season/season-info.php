<?php 

$season      = new TOROFLIX_Seasons;
$term_id     = $args['term_id'];
$term        = $args['term'];
$url         = $args['url'];
$serie_id    = $season->get_serie_id($term_id);
$title       = $season->title_term($term, $term_id);
$director    = $season->director_term($term_id);
$cast        = $season->categories_term($term_id);
$genre       = $season->casts_term($term_id);
$description = term_description( $term_id, 'seasons' );

?>

<article class="TPost A">
    <header class="Top">
        <h1 class="Title"><?php echo get_the_title($serie_id) . ' ' . $title; ?></h1>
    </header>
    <div class="Description">

        <?php 

        echo ($description) ? $description : '';
        
        echo ($director) ? '<p class="Director"><span>'. __("Director", "toroflix"). ':</span> '. $director .'</p>' : '';
        
        echo ($cast) ? '<p class="Cast"><span>'. __("Cast", "toroflix"). ':</span> '. $cast .'</p>' : '';
        
        echo ($genre) ? '<p class="Genre"><span>'. __("Genre", "toroflix"). ':</span> '. $genre .'</p>' : '';
        
        ?>

    </div>
    <footer>
        <ul class="ShareList">
            <li><a ref="javascript:void(0)" onclick="window.open ('https://www.facebook.com/sharer.php?u=<?php echo $url; ?>', 'Facebook', 'toolbar=0, status=0, width=650, height=450');" class="fa-facebook"></a></li>
            <li><a onclick="javascript:window.open('https://twitter.com/intent/tweet?original_referer=<?php echo $url; ?>&amp;text=<?php echo $term->name; ?>&amp;tw_p=tweetbutton&amp;url=<?php echo $url; ?>', 'Twitter', 'toolbar=0, status=0, width=650, height=450');" class="fa-twitter"></a></li>
        </ul>
    </footer>
</article>