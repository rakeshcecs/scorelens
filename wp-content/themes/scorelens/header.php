<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="light">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'sl-site' ); ?>>
<?php wp_body_open(); ?>

<!-- ════════════ ANIMATED BACKGROUND LAYERS ════════════ -->
<div class="sl-bg-grid" aria-hidden="true"></div>
<div class="sl-bg-orbs" aria-hidden="true">
	<div class="sl-orb sl-orb--1" data-parallax="0.04"></div>
	<div class="sl-orb sl-orb--2" data-parallax="0.06"></div>
	<div class="sl-orb sl-orb--3" data-parallax="0.03"></div>
</div>
<div class="sl-bg-spotlight" aria-hidden="true"></div>

<!-- ════════════ PRIMARY NAVIGATION ════════════ -->
<header class="sl-site-header">
	<nav class="sl-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'scorelens' ); ?>">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sl-brand" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<img
				class="sl-brand-logo"
				src="<?php echo esc_url( SCORELENS_URI . '/assets/images/scorelens_logo-H.svg' ); ?>"
				alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
				width="160"
				height="40"
			/>
		</a>

		<div class="sl-nav-links" id="sl-primary-nav">
			<?php
			if ( has_nav_menu( 'sl-primary' ) ) {
				wp_nav_menu( [
					'theme_location' => 'sl-primary',
					'container'      => false,
					'fallback_cb'    => false,
					'items_wrap'     => '%3$s',
					'depth'          => 1,
					'walker'         => new ScoreLens_Nav_Walker(),
				] );
			} else {
				scorelens_primary_nav_fallback();
			}
			?>
		</div>

		<div class="sl-nav-right">
			<button
				class="sl-theme-toggle"
				id="sl-theme-toggle"
				type="button"
				aria-label="<?php esc_attr_e( 'Toggle dark / light theme', 'scorelens' ); ?>"
			>
				<svg class="sl-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
					<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
				</svg>
				<svg class="sl-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
					<circle cx="12" cy="12" r="4"/>
					<path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
				</svg>
			</button>

			<a href="<?php echo esc_url( wp_login_url() ); ?>" class="sl-btn sl-btn--ghost" style="display: none;">
				<?php esc_html_e( 'Sign in', 'scorelens' ); ?>
			</a>

			<a href="#sl-cta" class="sl-btn sl-btn--primary" data-sl-modal-open="sl-cta-modal">
				<span><?php esc_html_e( 'Start free →', 'scorelens' ); ?></span>
			</a>
		</div>

	</nav>
</header>
