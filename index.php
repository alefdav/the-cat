<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<?php if (is_home() && !is_front_page()) : ?>
	<header>
		<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
	</header>
<?php endif; ?>

<?php
// Start the loop.
while (have_posts()) : the_post();

?>
	<?php
	/**
	 * The default template for displaying content
	 *
	 * Used for both single and index/archive/search.
	 *
	 * @package WordPress
	 * @subpackage Twenty_Fifteen
	 * @since Twenty Fifteen 1.0
	 */
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


		<header class="entry-header">
			<?php
			if (is_single()) :
				the_title('<h1 class="entry-title">', '</h1>');
			else :
				the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
			endif;
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			/* translators: %s: Name of current post */
			the_content(sprintf(
				__('Continue reading %s', 'twentyfifteen'),
				the_title('<span class="screen-reader-text">', '</span>', false)
			));

			wp_link_pages(array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'twentyfifteen') . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __('Page', 'twentyfifteen') . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			));
			?>
		</div><!-- .entry-content -->

		<?php
		// Author bio.
		if (is_single() && get_the_author_meta('description')) :
			get_template_part('author-bio');
		endif;
		?>

		<footer class="entry-footer">

			<?php edit_post_link(__('Edit', 'twentyfifteen'), '<span class="edit-link">', '</span>'); ?>
		</footer><!-- .entry-footer -->

	</article><!-- #post-## -->

<?php

// End the loop.
endwhile;

// Previous/next page navigation.
the_posts_pagination(array(
	'prev_text'          => __('Previous page', ''),
	'next_text'          => __('Next page', ''),
	'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', '') . ' </span>',
));

?>
</main><!-- .site-main -->
</div><!-- .content-area -->
<?php get_footer(); ?>