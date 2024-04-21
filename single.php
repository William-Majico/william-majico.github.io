<?php get_header(); 
    if(have_posts()) : while(have_posts()) : the_post();?>
        <div class="Body">
            <div class="Main Container">
                <div class="TpRwCont">
                    <main>
                        <article class="TPost A single-post">
                            <header class="Top">
                                <h1 class="Title"><?php the_title(); ?></h1>
                                <div class="Info">
                                    <span class="fa-user User"><?php the_author(); ?></span>
                                    <span class="Date fa-calendar-o"><?php echo get_the_date(); ?></span>
                                </div>
                            </header>
                            <div class="Description">
                                <?php the_content() ?>
                            </div>
                            <footer>
                                <ul class="ShareList">
                                    <li><a href="javascript:void(0)" onclick="window.open ('https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>', 'Facebook', 'toolbar=0, status=0, width=650, height=450');" class="fa-facebook"></a></li>
                                    <li><a href="javascript:void(0)" onclick="javascript:window.open('https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?>', 'Twitter', 'toolbar=0, status=0, width=650, height=450');" class="fa-twitter"></a></li>
                                </ul>
                            </footer>
                        </article>
                        <?php comments_template(); ?>
                    </main>
                    <?php get_sidebar(); ?>
                </div>
           </div>
        </div>
    <?php endwhile; endif;
get_footer(); ?>