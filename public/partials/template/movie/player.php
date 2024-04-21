<?php 
$post_id         = get_the_ID();
$loop            = $args['data'];
$data_header     = array('loop' => $loop, 'image' => true );
$links           = $loop->tr_links_movies($post_id);
$trailer         = $loop->trailer($post_id );
$links['online'] = !empty($links['online']) ? $links['online'] : '';
$tagiframe       = 'iframe';
$bgMovie         = $loop->backdrop_movie($post_id, 'original');
$enable_tab_lang = get_option('enable_tab_lang', false);

if($links['online']){ ?>
    <div class="TPost A D">
        <div class="Container">

            <?php if($enable_tab_lang){ 

                $players_enable = $links['online']; 
                $lang_pl = array();
                
                foreach($players_enable as $k => $player) {
                    if( $player['lang'] && $player['lang']!= '' ){
                        $lng = $player['lang'];
                       
                    } else { $lng = 'Undefined';  }
                    
                    if ( !in_array($lng, $lang_pl) ) {
                        $lang_pl[] = $lng;
                    }
                } 
                
                if( count($lang_pl) > 0 ){ 
                     ?>
                    <div class="optns-bx">
                        <?php foreach($lang_pl as $k => $lpl){

                            if($lpl == 'Undefined'){
                                $lng_term_name = 'Undefined';
                                $lnt = 0;
                            } else {
                                $lng_term = get_term( $lpl, 'language' ); 
                                $lng_term_name = $lng_term->name;
                                $lnt = $lpl;
                            } ?>

                            <div class="drpdn">
                                <button class="bstd Button">
                                    <span><?php echo strtoupper($lng_term_name); ?> <span><?php _e('Language', 'toroflix') ?></span></span>
                                    <i class="fa-chevron-down"></i>
                                </button>
                                <ul class="optnslst trsrcbx">
                                    <?php $kk = 0; 
                                    foreach ($links['online'] as $key => $online) { 
                                        
                                        if($online['lang'] == $lnt) { 
                                            $count = $kk + 1;
                                            
                                            $count = sprintf("%02d", $count);
                                           
                                            if( $online['server'] && $online['server']!= '' ){
                                                $server_term = get_term( $online['server'], 'server' );
                                                $server_term_name = strtoupper($server_term->name);
                                            } else {
                                                $server_term_name = '';
                                            }
                                           
                                            if( $online['lang'] && $online['lang']!= '' ){
                                                $lang_term = get_term( $online['lang'], 'language' ); 
                                                $lang_term_name = $lang_term->name;
                                            } else {
                                                $lang_term_name = '';
                                            }
                                           
                                            if( $online['quality'] && $online['quality']!= '' ){
                                                $quality_term = get_term( $online['quality'], 'quality' ); 
                                                $quality_term_name = strtoupper($quality_term->name);
                                            } else {
                                                $quality_term_name = '';
                                            }
                                            
                                            ?>
                                            <li>
                                                <button  data-typ="movie" data-key="<?php echo $online['i']; ?>" data-id="<?php echo get_the_ID(); ?>" class="Button sgty <?php if($kk == 0 && $k == 0){ echo 'on'; } ?>">
                                                    <span class="nmopt"><?php echo $count; ?></span>
                                                    <span><?php echo strtoupper($lng_term_name); ?> <span><?php echo $quality_term_name; ?> <?php if( $quality_term_name != '') { echo '• '; } ?><?php if( $online['server'] && $online['server']!= '' ) { echo $server_term_name; } ?></span></span>
                                                </button>
                                            </li>

                                        <?php $kk++; } ?>
                                   
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                <?php 
                }
            } ?>

            <div class="VideoPlayer">
                <?php foreach ($links['online'] as $key => $online) {
                    if($key == 0){ ?>
                        <div id="VideoOption01" class="Video on">
                            <<?php echo $tagiframe; ?> src="<?php echo esc_url( home_url( '/?trembed='.$online['i'].'&trid='.$post->ID ) ).'&trtype=1';  ?>" frameborder="0" allowfullscreen></<?php echo $tagiframe; ?>>
                        </div>
                    <?php }
                } ?>

                <?php if(!$enable_tab_lang){  ?>
                    <section id="VidOpt" class="VideoOptions">
                        <div class="Top AAIco-list">
                            <div class="Title"><?php _e('Options', 'toroflix'); ?></div>
                        </div>

                        <div class="d-flex-ch">
                            <ul class="ListOptions">
                                <?php foreach ($links['online'] as $key => $online) {
                                    $count = $key + 1;
                                    $count = sprintf("%02d", $count);
                                    //Server
                                    if( $online['server'] && $online['server']!= '' ){
                                    $server_term = get_term( $online['server'], 'server' ); }
                                    // lang
                                    if( $online['lang'] && $online['lang']!= '' ){
                                    $lang_term = get_term( $online['lang'], 'language' ); }
                                    // quality
                                    if( $online['quality'] && $online['quality']!= '' ){
                                    $quality_term = get_term( $online['quality'], 'quality' ); } ?>
                                    <li data-typ="movie" data-key="<?php echo $key; ?>" data-id="<?php echo get_The_ID(); ?>" class="OptionBx <?php if($key == 0){ echo 'on'; } ?>" data-VidOpt="VideoOption<?php echo $count; ?>">
                                        <div class="Optntl"><?php _e('Option', 'toroflix'); ?> <span><?php echo $count; ?></span></div>
                                        <p class="AAIco-language"><?php if($online['lang'] && $online['lang']!= ''){ echo $lang_term->name; } else {echo '';} ?></p>
                                        <p class="AAIco-dns"><?php if( $online['server'] && $online['server']!= '' ){ echo $server_term->name; } ?></p>
                                        <p class="AAIco-equalizer"><?php if( $online['quality'] && $online['quality']!= '' ){ echo $quality_term->name; } ?></p>
                                        <span class="Button"><?php _e('WATCH ONLINE', 'toroflix'); ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </section>
                    <span class="BtnOptions AAIco-list AATggl" data-tggl="VidOpt"><i class="AAIco-clear"></i></span>
                    
                <?php } ?>
                <span class="BtnLight AAIco-lightbulb_outline lgtbx-lnk"></span>
                <span class="lgtbx"></span>
            </div>
            <?php if( $bgMovie && $bgMovie!= ''){ ?>
            <div class="Image">
                <figure class="Objf"><?php echo $bgMovie; ?></figure>
            </div><?php } ?>
        </div>

        <?php
        $ads_button_player = get_option( 'ads_button_player', $default = false );
        ?>
        <?php if ($ads_button_player ){ ?>
            <div class="ads-button-player">
                <?php echo $ads_button_player ; ?>
            </div>
        <?php } ?>
    </div>
<?php }
elseif($trailer){ ?>
    <div class="TPost A D">
        <div class="Container">
            <div class="VideoPlayer">
                <div id="VideoOption01" class="Video on">
                    <?php echo htmlspecialchars_decode($trailer); ?>
                </div>
            </div>

            <?php if( $bgMovie && $bgMovie != '' ){ ?>
                <div class="Image">
                    <figure class="Objf"><?php echo $bgMovie; ?></figure>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <div class="TPost A D">
        <div class="Container">
            <div class="MovieListSldCn">
                <article class="TPost A">
                    <?php do_action( 'header_single', $data_header ); ?>
                </article>
            </div>
        </div>
        <?php if( $bgMovie && $bgMovie != '' ){ ?>
                <div class="Image">
                    <figure class="Objf"><?php echo $bgMovie; ?></figure>
                </div>
            <?php } ?>
    </div>
<?php }