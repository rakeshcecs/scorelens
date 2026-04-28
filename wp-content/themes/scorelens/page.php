<?php
/**
 * Page Template — Static pages (About, Contact, Privacy, Terms, etc.)
 *
 * @package ScoreLens
 * @version 2.0.0
 */

get_header();
?>

<main class="sl-content-area" id="sl-primary">
	<div class="sl-container">

		<?php while ( have_posts() ) : the_post(); ?>

			<article <?php post_class( 'sl-page' ); ?> id="sl-page-<?php the_ID(); ?>">

				<header class="sl-archive-header sl-fade">
					<h1 class="sl-archive-title"><?php the_title(); ?></h1>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="sl-page-thumbnail sl-fade sl-d1">
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
				<?php endif; ?>

				<div class="sl-page-content sl-fade sl-d2">
					<?php
					the_content();

					wp_link_pages( [
						'before'      => '<nav class="sl-page-pagination" aria-label="' . esc_attr__( 'Page', 'scorelens' ) . '">',
						'after'       => '</nav>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					] );

					edit_post_link(
						esc_html__( 'Edit page', 'scorelens' ),
						'<p class="sl-edit-link">',
						'</p>'
					);
					?>
				</div>

			</article>

		<?php endwhile; ?>

	</div>
</main>

<?php get_footer(); ?>
