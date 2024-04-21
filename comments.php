<?php if(comments_open()){ ?>
 <section>
    <div class="Top AAIco-chat">
        <div class="Title"><?php _e('Comments', 'toroflix'); ?></div>
    </div>
    <div class="Comment Wrt">
        <?php comment_form(
            array(
                'cancel_reply_link' => __( 'Cancel reply', 'toroflix' ),
                'label_submit' => __( 'Post Comment', 'toroflix' ),
            )
        );  ?>
    </div>
    <ul class="CommentsList">
        <?php 
        $args = array(
            'avatar_size' => 0,
        );
        wp_list_comments( $args, $comments ); ?>
    </ul>
    <div class="wp-pagenavi"><?php paginate_comments_links() ?></div>
</section>
<?php } ?>