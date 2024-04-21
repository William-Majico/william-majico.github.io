        <footer class="Footer">
            <?php if( is_active_sidebar('sidebar-footer') ) { ?>
            <div class="Top">
                <div class="Container">
                    <div class="Rows DF D03">
                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-footer')) : endif; ?>
                    </div>
                </div>
            </div>
            <?php } if(get_option( 'text_footer' )){ ?>
                <div class="Bot">
                    <div class="Container">
                        <p><?php echo get_option( 'text_footer', ''); ?></p>
                    </div>
                </div>
            <?php } ?>
        </footer>
    </div>
    <?php wp_footer(); ?>
</body>
</html>