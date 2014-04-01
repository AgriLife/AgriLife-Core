<?php

namespace AgriLife\Core\Shortcode;

class Loop {

	public function __construct() {

		add_shortcode( 'loop', array( $this, 'loop_shortcode' ) );

	}

	public function loop_shortcode( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'pagination' => 'true',
			'query' => '',
			'category' => '',
			'post_type' => 'any',
			'posts_per_page' => -1,
		), $atts ));

		$args = array(
			'post_type' => $post_type,
			'category_name' => $category,
			'posts_per_page' => $posts_per_page,
			'orderby' => 'menu_order',
			'order' => 'DESC',
		);

		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			$content = '<section class="loop-shortcode">';
			ob_start();
			while ( $query->have_posts() ) : $query->the_post();?>

			<article class="loop-article">
				<header>
					<h3 class="title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
					<?php if ( 'post' == get_post_type() ) : ?>
						<span class="date"><?php echo get_the_date( 'm/d' ); ?></span>
					<?php endif; ?>
				</header>
				<div class="content">
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'featured' );
					} else {
					printf( '<img src="%s" alt="AgriLife Logo" title="AgriLife" />',
						get_template_directory_uri() . '/img/agrilife-default-logo.png'
					);
					} ?>

					<?php the_excerpt(); ?>

				</div>
			</article>

			<?php
			endwhile;
			$content .= ob_get_clean();
			$content .= '</section>';

			wp_reset_query();

			return $content;
		} else {
			wp_reset_query();
			return 'No posts found';
		}

	}

}