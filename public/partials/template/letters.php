<?php $letters = get_categories( array(    'hide_empty' => false,    'taxonomy'   => 'letters') ); $term = get_queried_object();if($term)	$name = strtolower($term->name);if(isset($letters)){$ads_top_letter = get_option( 'ads_top_letter', $default = false );$ads_button_letter = get_option( 'ads_button_letter', $default = false ); ?>		<?php if ($ads_top_letter and is_front_page()){ ?>	    <div class="ads-top-letter">	    	<?php echo $ads_top_letter ; ?>	    </div>	<?php } ?>    <ul class="AZList">        <?php foreach ( $letters as $letter ) { ?>            <li <?php if($name == strtolower($letter->name)){ echo 'class="Current"';} ?>><a href="<?php echo esc_url( get_term_link( $letter->term_id, 'letters' ) ); ?>"><?php echo esc_html( $letter->name ); ?></a></li>        <?php } ?>    </ul>        <?php if ($ads_button_letter and is_front_page()){ ?>	    <div class="ads_button_letter">	    	<?php echo $ads_button_letter ; ?>	    </div>	<?php } ?>    <?php }