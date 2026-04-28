<?php
/**
 * Index Template — Fallback for blog/archive views
 *
 * @package ScoreLens
 * @version 2.0.0
 */

get_header();
?>

<main class="sl-content-area" id="sl-primary">
	<div class="sl-container">

		<?php if ( have_posts() ) : ?>

			<header class="sl-archive-header">
				<?php
				if ( is_home() && ! is_front_page() ) {
					single_post_title( '<h1 class="sl-archive-title">', '</h1>' );
				} elseif ( is_archive() ) {
					the_archive_title( '<h1 class="sl-archive-title">', '</h1>' );
					the_archive_description( '<div class="sl-archive-desc">', '</div>' );
				}
				?>
			</header>

			<div class="sl-posts-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'sl-post-card' ); ?> id="sl-post-<?php the_ID(); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="sl-post-thumbnail">
								<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
									<?php the_post_thumbnail( 'medium_large' ); ?>
								</a>
							</div>
						<?php endif; ?>
						<div class="sl-post-body">
							<h2 class="sl-post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<div class="sl-post-meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
									<?php echo esc_html( get_the_date() ); ?>
								</time>
							</div>
							<div class="sl-post-excerpt"><?php the_excerpt(); ?></div>
							<a href="<?php the_permalink(); ?>" class="sl-btn sl-btn--ghost">
								<?php esc_html_e( 'Read more →', 'scorelens' ); ?>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php
			the_posts_pagination( [
				'prev_text' => '← ' . esc_html__( 'Older', 'scorelens' ),
				'next_text' => esc_html__( 'Newer', 'scorelens' ) . ' →',
			] );
			?>

		<?php else : ?>

			<div class="sl-no-results">
				<h1><?php esc_html_e( 'Nothing found', 'scorelens' ); ?></h1>
				<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'scorelens' ); ?></p>
				<?php get_search_form(); ?>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
