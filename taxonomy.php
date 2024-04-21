<?php get_header(); 
$loop             = new TOROFLIX_Movies();
$sidebar_position = $loop->sidebar_position('sidebar_type_category'); ?>
<div class="Body">
    <div class="Main Container">
       <?php $alphabet = get_option('alphabet_show');
        if($alphabet){
	        	get_template_part('public/partials/template/letters');
	        } ?>
        <div class="TpRwCont <?php echo $sidebar_position; ?>">
            <main>
		        <section>
		            <div class="Top AAIco-movie_filter">
		                <h2 class="Title"><?php single_cat_title(); ?></h2>
		                <div class="SrtdBy AADrpd">
		                    <i class="AALink"></i>
		                    <span><?php _e('Sorted by:', 'toroflix'); ?></span>
		                    <ul class="List AACont">
		                        <li class="on"><a class="fa-check" href="#Latest"><?php _e('Latest', 'toroflix'); ?></a></li>
		                        <li><a class="AAIco-check" href="#Popular"><?php _e('Popular', 'toroflix'); ?></a></li>
		                        <li><a class="AAIco-check" href="#Views"><?php _e('Views', 'toroflix'); ?></a></li>
		                    </ul>
		                </div>
		            </div>
		            <ul class="MovieList Rows AX A04 B03 C20 D03 E20 Alt">
		            	<?php if(have_posts()) : 
		            		while(have_posts()) : the_post();?>
		            			<?php get_template_part("public/partials/template/loop-principal"); ?>
		            		<?php endwhile; ?> 
		            	<?php else: ?>
		            		<div>
		            			<?php _e('There are no articles', 'toroflix'); ?>
		            		</div>
		            	<?php endif; ?>
		            </ul>
					<nav class="wp-pagenavi">
						<?php echo TOROFLIX_Add_Theme_Support::toroflix_pagination(); ?>
					</nav>
		        </section>                
            </main>
            <?php if($sidebar_position != 'NoSdbr'){ get_sidebar(); } ?>
        </div>
	</div>
</div>
<?php get_footer(); ?>