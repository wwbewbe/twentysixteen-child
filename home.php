<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<h2 class="page-title">Topics</h2>
		<div class="top-boxes">
		<?php
		$location_name = 'topicnav';
		$locations = get_nav_menu_locations();
		$myposts = wp_get_nav_menu_items( $locations[ $location_name ] );
		if( $myposts ): ?>

			<?php foreach($myposts as $post):
			if(( $post->object == 'post' ) || ( $post->object == 'page' )):
			$post = get_post( $post->object_id );
			setup_postdata($post); ?>
				<?php the_top_thumbnailed_article(); ?>
			<?php endif;
			endforeach; ?>

		<?php wp_reset_postdata();
		endif; ?>
		</div><!-- .top-boxes -->

		<?php if ( is_active_sidebar( 'front-ad1' ) ) : ?>
			<div class="front-ad1">
				<?php dynamic_sidebar( 'front-ad1' ); // Adsense ?>
			</div><!-- .header-ad -->
		<?php endif; ?>

		<h2 class="page-title">Blog</h2>
		<?php
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$args = array(
			'category__not_in' => '39',
			'paged' => $paged,
		);
		$the_query = new WP_Query( $args ); ?>
		<?php if ( $the_query->have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
			// Start the loop.
			while ( $the_query->have_posts() ) : $the_query->the_post();
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentysixteen' ),
				'next_text'          => __( 'Next page', 'twentysixteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;

		get_template_part('snsbtn'); // add SNS button
		?>
		<?php wp_reset_postdata(); ?>
		</main><!-- .site-main -->

		<?php if ( is_active_sidebar( 'front-ad2' ) ) : ?>
			<div class="front-ad2">
				<?php dynamic_sidebar( 'front-ad2' ); // Adsense ?>
			</div><!-- .header-ad -->
		<?php endif; ?>

	</div><!-- .content-area -->

	<?php get_sidebar(); ?>

	<div class="header-ad">
		<?php dynamic_sidebar( 'header-ad' ); // Adsense ?>
	</div><!-- .header-ad -->

<?php get_footer(); ?>
