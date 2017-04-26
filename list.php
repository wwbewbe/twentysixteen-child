<div class="list">
	<?php
	$args=array(
	            'posts_per_page'	=> $num,		//リスト数を指定
				'category__not_in'	=> array(1),	//カテゴリが未分類の記事は非表示
	            'tag'				=> $tagname,	//タグを指定(slug)
				'category_name'		=> $catname,	//カテゴリーを指定(slug)
				'paged'				=> $paged,
	        );
	?>
	<?php $the_query = new WP_Query($args); ?>

	<?php if($the_query->have_posts()): while($the_query->have_posts()):
	$the_query->the_post();

		get_template_part( 'template-parts/content' );

	endwhile; ?>

	<div class="navigation pagination list-page">
		<?php echo paginate_links( array( 'type' => 'list',
								'prev_text' => '&laquo;',
								'next_text' => '&raquo;',
								'total'		=> $the_query->max_num_pages
							) ); ?>
	</div>

	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

	<?php get_template_part('snsbtn'); // add SNS button?>

</div>
