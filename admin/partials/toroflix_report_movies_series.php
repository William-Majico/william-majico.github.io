<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<h1 class="h4"><?php _e('Report Form', 'toroflix'); ?></h1>
		</div>

		<div class="col-12">
			<table class="table table-striped table-hover">
				<thead>
			    	<tr>
			    		<th scope="col">#</th>
			    		<th width="300" scope="col"><?php _e('Title', 'toroflix'); ?></th>
			    		<th scope="col"><?php _e('Message', 'toroflix'); ?></th>
			    		<th scope="col"><?php _e('Action', 'toroflix'); ?></th>
			    	</tr>
			    </thead>
			    <tbody>
			    	<?php $args = array(
			    	    'post_type'           => array('movies', 'series'),
			    	    'posts_per_page'      => 100,
			    	    'post_status'         => 'publish',
			    	    'meta_query' => array(
			    	    	'relation' => 'AND',
			    	    	array(
								'key'     => 'reporflix',
								'compare' => 'EXISTS'
			    	    	)
			    	    )
			    	); 
			    	$the_query = new WP_Query( $args );
			    	if ( $the_query->have_posts() ) :
			    		$count = 1;
			    	    while ( $the_query->have_posts() ) : $the_query->the_post(); 
			    	    	$messages = get_post_meta( get_the_ID(), 'reporflix', false ); ?>
			    	        <tr>
					    		<th scope="row"><?php echo $count; $count++; ?></th>
					    		<td><?php the_title(); ?></td>
					    		<td>
					    			<ol>
					    				<?php foreach ($messages as $key => $message): ?>
					    					<li><?php echo $message; ?></li>
					    				<?php endforeach ?>
					    			</ol>
					    		</td>
					    		<td><button ide="<?php the_ID(); ?>" type="button" class="btn-danger btn-sm delete-message-report"><?php _e('Delete Messages', 'toroflix'); ?></button></td>
					    	</tr>
			    	    <?php endwhile;
			    	endif; wp_reset_query(); ?>
					    	
			    </tbody>
			</table>
		</div>
	</div>
</div>