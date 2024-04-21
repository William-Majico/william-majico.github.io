<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
</head>
<?php $gradient = get_option( 'header_type', false ); 
if($gradient){ $gra = 'BdGradient';}else{$gra = '';} ?>
<body id="Tf-Wp" <?php body_class($gra); ?>>
	<div class="Tf-Wp">
		<header id="Hd" class="Header">
			<div class="Container">
		        <div id="HdTop" class="Top">
		            <?php do_action('header_container');
		            		#10: Toggle menu
		            		#20: Search form
		            		#30: Logotype
		            		#40: Navigation ?>
		        </div>
			</div>
		</header>