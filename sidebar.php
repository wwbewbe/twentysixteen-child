<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' )  ) : ?>
	<aside id="secondary" class="sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'submenu-1' ); ?>
		<section class="widget latest-posts">
			<h2 class="widget-title">最新記事</h2>
			<?php
			$args = array( 'posts_per_page' => 5, 'category__not_in' => '39' );
			$postslist = get_posts( $args );
			foreach ($postslist as $post):
			setup_postdata( $post );
			the_thumbnailed_article();
			endforeach;
			wp_reset_postdata();
			?>
		</section>

		<section class="widget latest-posts">
			<h2 class="widget-title">最近ゲットした「柿の種」</h2>
			<?php
			$args = array( 'posts_per_page' => 3, 'category_name' => 'kakinotane' );
			$postslist = get_posts( $args );
			foreach ($postslist as $post):
			setup_postdata( $post );
			the_thumbnailed_article();
			endforeach;
			wp_reset_postdata();
			?>
		</section>

		<section class="widget pickup-posts">
			<?php
			$location_name = 'pickupnav';
			$locations = get_nav_menu_locations();
			$myposts = wp_get_nav_menu_items( $locations[ $location_name ] );
			if( $myposts ): ?>
			<h2 class="widget-title">おすすめ記事</h2>

				<?php foreach($myposts as $post):
				if($post->object == 'post'):
				$title = $post->title;//ナビゲーションラベル名
				$post = get_post( $post->object_id );
				setup_postdata($post); ?>
				<div class="pickup-article">
				<a href="<?php the_permalink(); ?>">
				<div class="pickup-thumbnail" style="background-image: url(<?php echo get_thumb( 'full' ); ?>)"></div>
				<div class="pickup-content">
				<?php echo $title;//ナビゲーションラベル名を表示 the_title(); ?>
				</a>
				</div><!-- .thumbnailed-content -->
				</div><!-- .thumbnailed-article -->
				<?php endif;
				endforeach; ?>

			<?php wp_reset_postdata();
			endif; ?>
		</section>

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>
