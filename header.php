<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

	<?php if( is_home() || is_front_page() ): // トップページ用のメタデータ ?>
	  <meta name="description" content="<?php bloginfo( 'description' ); ?>">

	  <?php $allcats = get_categories();
	  $kwds = array();
	  foreach ( $allcats as $allcat ) {
	    $kwds[] = $allcat->name;
	  } ?>
	  <meta name="keywords" content="<?php echo implode( ',', $kwds ); ?>">

	  <meta property="og:type" content="website">
	  <meta property="og:title" content="<?php bloginfo( 'name' ); ?>">
	  <meta property="og:url" content="<?php echo esc_url(home_url( '/' )); ?>">
	  <meta property="og:description" content="<?php bloginfo( 'description' ); ?>">
	  <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/img/site-top.png">
	<?php endif; // トップページ用のメタデータ【ここまで】 ?>

	<?php if( ( is_single() || is_page() ) && ( !is_front_page() ) ): //記事の個別ページ用のメタデータ ?>
	  <meta name="description" content="<?php echo wp_trim_words( $post->post_excerpt, 200, '…' ); ?>">

	  <?php if ( has_tag() ): ?>
	    <?php $tags = get_the_tags();
	    $kwds = array();
	    foreach ( $tags as $tag ) {
	      $kwds[] = $tag->name;
	    } ?>
	    <meta name="keywords" content="<?php echo implode( ',', $kwds ); ?>">
	  <?php endif; ?>

	  <meta property="og:type" content="article">
	  <meta property="og:title" content="<?php the_title(); ?>">
	  <meta property="og:url" content="<?php the_permalink(); ?>">
	  <meta property="og:description" content="<?php echo esc_attr( wp_trim_words( $post->post_excerpt, 200, '…' ) ); ?>">
	  <meta property="og:image" content="<?php echo get_thumb( 'large' ); ?>">
	<?php endif; //記事の個別ページ用のメタデータ【ここまで】?>

	<?php if( is_category() || is_tag() ): // カテゴリー・タグページ用のメタデータ ?>
	  <?php if( is_category() ) {
	      $termid = $cat;
	      $taxname = 'category';
	  } elseif( is_tag() ) {
	      $termid = $tag_id;
	      $taxname = 'post_tag';
	  } ?>

	  <?php $childcats = get_categories( array( 'child_of'=>$termid ) );
	  $kwds = array();
	  $kwds[] = single_term_title( '', false );
	  foreach ( $childcats as $childcat ) {
	    $kwds[] = $childcat->name;
	  } ?>
	  <meta name="keywords" content="<?php echo implode( ',', $kwds ); ?>">

	  <meta name="description" content="<?php echo esc_html__( 'This list is about posts on ', 'gachafan' ); ?><?php single_term_title(); ?>">
	  <meta property="og:type" content="website">
	  <meta property="og:title" content="<?php echo esc_html__( 'Posts related to ', 'gachafan' ); ?><?php single_term_title(); ?> | <?php bloginfo( 'name' ); ?>">
	  <meta property="og:url" content="<?php echo get_term_link( $termid, $taxname ); ?>">
	  <meta property="og:description" content="<?php echo esc_html__( 'This list is about posts on ', 'gachafan' ); ?><?php single_term_title(); ?>">
	  <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/img/site-top.png">
	<?php endif; // カテゴリ・タグページ用のメタデータ【ここまで】 ?>

	<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>">
	<meta property="og:locale" content="ja_JP">
	<meta property="og:locale:alternate" content="en_US">
	<meta property="og:locale:alternate" content="en_GB">
	<meta property="og:locale:alternate" content="zh_TW">

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-75719561-2', 'auto');
	  ga('send', 'pageview');

	</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> oncontextmenu="return false;">
<div id="page" class="site">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<div class="site-header-main">
				<div class="site-branding">

					<?php if (has_custom_logo()) : ?>
					<?php twentysixteen_the_custom_logo(); ?>
					<?php else : ?>
					<?php if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif;
					endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; ?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->

				<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) ) : ?>
					<button id="menu-toggle" class="menu-toggle"><i class="fa fa-bars fa-fw"></i><?php //_e( 'Menu', 'twentysixteen' ); ?></button>

					<div id="site-header-menu" class="site-header-menu">
						<?php if ( has_nav_menu( 'primary' ) ) : ?>
							<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'twentysixteen' ); ?>">
								<?php
									wp_nav_menu( array(
										'theme_location' => 'primary',
										'menu_class'     => 'primary-menu',
									 ) );
								?>
							</nav><!-- .main-navigation -->
						<?php endif; ?>

						<?php if ( has_nav_menu( 'social' ) ) : ?>
							<nav id="social-navigation" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'twentysixteen' ); ?>">
								<?php
									wp_nav_menu( array(
										'theme_location' => 'social',
										'menu_class'     => 'social-links-menu',
										'depth'          => 1,
										'link_before'    => '<span class="screen-reader-text">',
										'link_after'     => '</span>',
									) );
								?>
							</nav><!-- .social-navigation -->
						<?php endif; ?>
					</div><!-- .site-header-menu -->
				<?php endif; ?>
			</div><!-- .site-header-main -->

			<?php if ( get_header_image() && is_front_page() && is_home() ) : ?>
				<?php
					/**
					 * Filter the default twentysixteen custom header sizes attribute.
					 *
					 * @since Twenty Sixteen 1.0
					 *
					 * @param string $custom_header_sizes sizes attribute
					 * for Custom Header. Default '(max-width: 709px) 85vw,
					 * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'.
					 */
					$custom_header_sizes = apply_filters( 'twentysixteen_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px' );
				?>
				<div class="header-image">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id ) ); ?>" sizes="<?php echo esc_attr( $custom_header_sizes ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					</a>
				</div><!-- .header-image -->
			<?php endif; // End header image check. ?>

			<div class="header-ad">
				<?php dynamic_sidebar( 'header-ad' ); // Adsense ?>
			</div><!-- .header-ad -->
		</header><!-- .site-header -->

		<div id="content" class="site-content">
