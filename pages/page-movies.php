<?php /*template name: Page Movies*/get_header();$loop             = new TOROFLIX_Movies();$sidebar_position = $loop->sidebar_position('sidebar_type_category'); ?><div class="Body">	<?php if(is_front_page()){ ?>		<?php 		$loop      = new TOROFLIX_Movies();		$blocks    = get_option( 'block_home_views', false );		$serialize = get_option('serialize_toroflix');		$alphabet  = get_option('alphabet_show');		$data      = array( 			'loop'      => $loop, 			'block'     => $blocks, 			'serialize' => $serialize 	    );	    $sidebar_position = TOROFLIX_Add_Theme_Support::get_position_sidebar();	    do_action( 'home_movielist', $data );	    	#10: Slider home ?>	<?php } ?>    <div class="Main Container">       <?php $alphabet = get_option('alphabet_show');        if($alphabet){	        	get_template_part('public/partials/template/letters');	        } ?>        <div class="TpRwCont <?php echo $sidebar_position; ?>">            <main>		        <section>		            <div class="Top AAIco-movie_filter">		                <h2 class="Title"><?php the_title(); ?></h2>		            </div>		            <?php 		            if(is_front_page()) {		            	$paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;		            } else {		            	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;		            }	            	$args = array(						'post_type'      => 'movies',						'paged'          => $paged,						'posts_per_page' => get_option( 'posts_per_page' ),						'post_status'    => 'publish',	            	); 	            	$wp_query = new WP_Query( $args );	            	if ( $wp_query->have_posts() ) : ?>			            <ul class="MovieList Rows AX A04 B03 C20 D03 E20 Alt">			            	<?php 			            	    while ( $wp_query->have_posts() ) : $wp_query->the_post();			            	        get_template_part("public/partials/template/loop-principal");			            	    endwhile; ?>			            </ul>			            <nav class="wp-pagenavi">							<?php echo TOROFLIX_Add_Theme_Support::toroflix_pagination(); ?>						</nav>					<?php endif; wp_reset_query();  ?>		        </section>		        <?php comments_template(); ?>                          </main>            <?php if($sidebar_position != 'NoSdbr'){ get_sidebar(); } ?>        </div>	</div></div><?php get_footer(); ?>