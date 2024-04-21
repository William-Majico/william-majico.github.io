<?php get_header(); 
	if(have_posts()) : while(have_posts()) : the_post(); 
		$loop     = new TOROFLIX_Movies();
		$data     = array( 
			'episodes'   => $loop->number_episodes_serie(), 
			'seasons'    => $loop->number_seasons_serie(),
			'year'       => $loop->year(),
			'duration'   => $loop->duration(),
			'views'      => $loop->views(),
			'director'   => $loop->director(),
			'categories' => $loop->get_categories(),
			'tags'       => $loop->get_tags_sin(),
			'cast'       => $loop->casts(),
			'rating'     => $loop->rating(get_the_ID()),
		); ?> 
		<div class="Body">
			<div class="MovieListSldCn">
				<article class="TPost A">
				    <header class="Container">
				        <div class="TPMvCn">
				        	<?php do_action( 'series_info', $data );
				        			#10: title
				        			#20: Subtitle
				        			#30: Info
				        			#40: Description
				        			#50: Sharelist ?>
				        </div>
				        <div class="Image">
				            <figure class="Objf"><?php echo $loop->backdrop_tmdb(get_the_ID(), 'original'); ?></figure>
				        </div>
				    </header>
				</article>
			</div>
			<div class="Main Container">
				<?php do_action( 'series_extra', $data );
						#10: Carousel letter
						#20: Content Serie
						#30: Related ?>
			</div>
		</div>
	<?php endwhile; endif;
get_footer();
global $post;
$loop    = new TOROFLIX_Movies();
$trailer = $loop->trailer($post->ID); 
if($trailer){ ?>
	<div class="Modal-Box Ttrailer">
	    <div class="Modal-Content">
	        <span class="Modal-Close Button AAIco-clear"></span>
	    </div>
	    <i class="AAOverlay"></i>
	</div>
<?php } ?>