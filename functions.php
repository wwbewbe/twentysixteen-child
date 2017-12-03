<?php

// エディタスタイルシート
add_editor_style( get_stylesheet_directory_uri() . '/editor-style.css?ver=' . date( 'U' ) );
add_editor_style( '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
	wp_enqueue_style( 'font-opensans', 'http://fonts.googleapis.com/css?family=Open+Sans' );
	wp_enqueue_style( 'child-fonts-google-css', 'https://fonts.googleapis.com/css?family=Averia+Serif+Libre:300,400,700|Oleo+Script:400,700|Open+Sans+Condensed:300,700|Open+Sans:300,400,700,800|Roboto+Condensed:300,400,700|Roboto+Slab:300,400,700|Roboto:300,400,700,900' );
	wp_enqueue_style( 'child-font-mplus1p-css', 'https://fonts.googleapis.com/earlyaccess/mplus1p.css' );
	wp_enqueue_style( 'child-font-roundedmplus1c-css', 'https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css' );
	wp_enqueue_style( 'child-font-awesome-css', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
}

function theme_enqueue_scripts() {
	wp_enqueue_script( 'gotop-btn', get_stylesheet_directory_uri() .'/js/gotop-btn.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );

// 編集画面の設定
function editor_setting($init) {
	$init[ 'block_formats' ] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre';

	$style_formats = array(
		array( 'title' => 'Tips',
			'block' => 'div',
			'classes' => 'tips',
			'wrapper' => true ),
		array( 'title' => 'Point',
			'block' => 'div',
			'classes' => 'point',
			'wrapper' => true ),
		array( 'title' => 'Attention',
			'block' => 'div',
			'classes' => 'attention',
			'wrapper' => true ),
		array( 'title' => 'Highlight',
			'inline' => 'span',
			'classes' => 'highlight') );
	$init[ 'style_formats' ] = json_encode( $style_formats );

	return $init;
}
add_filter( 'tiny_mce_before_init', 'editor_setting');

//スタイルメニューを有効化
function add_stylemenu( $buttons ) {
			array_splice( $buttons, 1, 0, 'styleselect' );
			return $buttons;
}
add_filter( 'mce_buttons_2', 'add_stylemenu' );

/* メニュー */
register_nav_menu( 'pickupnav', 'Pickup Posts' );	//おすすめ記事
register_nav_menu( 'topicnav', 'Topic Posts' );		//トピック記事

function showads() {
	$title = '<div style="font-size:7px">スポンサーリンク</div>';
	$shortad = '<';
	$adcode = '<div style="margin-bottom:20px;"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-6212569927869845"
     data-ad-slot="2703921407"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script></div>';

    return $title.$adcode;
}

add_shortcode('adsense', 'showads');

/**
 * Prints HTML with meta information for the categories, tags.
 *
 * Create your own twentysixteen_entry_meta() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_entry_meta() {
	if ( in_array( get_post_type(), array( 'post', 'attachment', 'page' ) ) ) {
		twentysixteen_entry_date();
	}

	if ( 'post' === get_post_type() ) {
		twentysixteen_entry_taxonomies();
	}
}

/**
 * Prints HTML with date information for current post.
 *
 * Create your own twentysixteen_entry_date() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_entry_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date('Y/m/d'),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date('Y/m/d')
	);

	printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span>%2$s</span>',
		_x( 'Posted on', 'Used before publish date.', 'twentysixteen' ),
		$time_string
	);
}

/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own twentysixteen_entry_taxonomies() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_entry_taxonomies() {

	$categories = get_the_category();
	$separator = ' ';
	$categories_list = '';
	if ( $categories ) {
		foreach( $categories as $category ) {
			if ( $category->term_id != 1 ) {
				$categories_list .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;
			}
		}
	}

//	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentysixteen' ) );
	if ( $categories_list && twentysixteen_categorized_blog() ) {
		printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			_x( 'Categories', 'Used before category names.', 'twentysixteen' ),
			$categories_list
		);
	}

	$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'twentysixteen' ) );
	if ( $tags_list ) {
		printf( '<i class="fa fa-tags fa-fw"></i><span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			_x( 'Tags', 'Used before tag names.', 'twentysixteen' ),
			$tags_list
		);
	}
}
/**
 * Determines whether blog/site has more than one category.
 *
 * Create your own twentysixteen_categorized_blog() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 *
 * @return bool True if there is more than one category, false otherwise.
 */
function twentysixteen_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'twentysixteen_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			// We only need to know if there is more than one category.
			'number'     => 2,
			// 未分類のカテゴリーを除外
			'exclude'    => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'twentysixteen_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so twentysixteen_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so twentysixteen_categorized_blog should return false.
		return false;
	}
}

/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * Create your own twentysixteen_post_thumbnail() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_post_thumbnail() {
	if ( post_password_required() || is_attachment() ) {
		return;
	}

	if ( is_singular( 'post' ) ) :
	?>

	<?php
	if (has_post_thumbnail()) {
		printf('<div class="post-thumbnail">');
		the_post_thumbnail(array('700,400'));
		printf('</div><!-- .post-thumbnail -->');
	} else {
		return;
	}
	?>

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
		if (has_post_thumbnail()) {
			the_post_thumbnail( 'full', array( 'alt' => the_title_attribute( 'echo=0' ) ) );
		} else {
			$thumbnail = get_thumb('full');
			$alt = the_title_attribute( 'echo=0' );
			printf('<img src="'.$thumbnail.'" alt="'.$alt.'">');
		}
		?>
	</a>
	<?php endif; // End is_singular()
}

/* サムネイル付き投稿リスト */
function the_thumbnailed_article() {
	printf('<div class="thumbnailed-article">');
	printf('<a href="%1$s">',get_the_permalink());
	printf('<div class="thumbnailed-area">');
	if (has_post_thumbnail()) {
		the_post_thumbnail('full');
	} else {
		$thumbnail = get_thumb('full');
		$alt = the_title_attribute( 'echo=0' );
		printf('<img src="'.$thumbnail.'" alt="'.$alt.'">');
	}
	printf('</div><!-- .thumbnailed-area -->');
	printf('<div class="thumbnailed-content">');
	the_title();
	printf('</a><br />');
	printf('<span class="thumbnailed-date">%1$s</span>', get_the_modified_date('Y-m-d'));
	printf('</div><!-- .thumbnailed-content -->');
	printf('</div><!-- .thumbnailed-article -->');
}

/* トップページサムネイル付きボックスリスト */
function the_top_thumbnailed_article() {
	printf('<div class="top-box">');
	printf('<a href="%1$s">',get_the_permalink());
	printf('<div class="top-thumbnail" style="background-image: url(');
	echo get_thumb( 'full' );
	printf(')"></div>');
	the_title();
	printf('</a>');
	printf('</div><!-- .top-box -->');
}

/* 記事からサムネイル画像取得 */
function get_thumb( $size ) {
	global $post;

	if ( has_post_thumbnail() ) {
		$postthumb = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
		$url = $postthumb[0];
	} elseif( preg_match( '/wp-image-(\d+)/s', $post->post_content, $thumbid ) ) {
		$postthumb = wp_get_attachment_image_src( $thumbid[1], $size );
		$url = $postthumb[0];
	} else {
		$url = get_stylesheet_directory_uri() . '/noimage.png';
	}
	return $url;
}

/* サイドバーを追加 */
register_sidebar( array(
	'id' => 'submenu-1',
	'name' => 'SubMenu1',
	'description' => 'setting submenu widget on side bar.',
	'before_widget' => '<section id="%1$s" class="widget %2$s">',
	'after_widget' => '</section>',
	'before_title' => '<h2 class="widget-title">',
	'after_title' => '</h2>'
) );
register_sidebar( array(
	'id' => 'header-ad',
	'name' => 'HeaderAdMenu',
	'description' => 'setting adsense menu widget on header.',
	'before_widget' => '<section id="%1$s" class="widget %2$s">',
	'after_widget' => '</section>',
	'before_title' => '<h2 class="widget-title">',
	'after_title' => '</h2>'
) );
register_sidebar( array(
	'id' => 'footer-ad',
	'name' => 'FooterAdMenu',
	'description' => 'setting adsense menu widget on footer.',
	'before_widget' => '<section id="%1$s" class="widget %2$s">',
	'after_widget' => '</section>',
	'before_title' => '<h2 class="widget-title">',
	'after_title' => '</h2>'
) );

/* 検索フォーム */
add_theme_support( 'html5', array( 'search-form' ) );

/* 抜粋の表示文字数 */
function custom_excerpt_length( $length ) {
	return 150;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// カテゴリ一覧ウィジェットから特定のカテゴリを除外
function my_theme_catexcept($cat_args){
    $cat_args['exclude'] = 1;	// 除外するカテゴリID(未分類)
    return $cat_args;
}
add_filter('widget_categories_args', 'my_theme_catexcept',10);

// リストを表示するショートコード
function set_list($params = array()) {
    extract(shortcode_atts(array(
        				'file'		=>	'list',	//表示に使用するPHPファイル
						'tagname'	=>	0,			//表示するタグ名
						'catname'	=>	0,			//表示するカテゴリー名
						'num'		=>	10,			//表示するリスト数
    					), $params));
    ob_start();
    include( STYLESHEETPATH . "/$file.php" );
    return ob_get_clean();
}
add_shortcode('list', 'set_list');
