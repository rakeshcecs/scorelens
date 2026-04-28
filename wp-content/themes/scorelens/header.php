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

<!-- ════════════ REUSABLE SVG DEFS ════════════ -->
<svg class="sl-svg-defs" aria-hidden="true" focusable="false">
	<defs>
		<symbol id="scorelens-mark" viewBox="0 0 100 100">
			<circle cx="62" cy="35" r="22" fill="none" stroke="currentColor" stroke-width="7"/>
			<path d="M 52 22 Q 48 30 52 40" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" opacity="0.6"/>
			<line x1="76" y1="20" x2="92" y2="4" stroke="currentColor" stroke-width="7" stroke-linecap="round"/>
			<path d="M 82 4 L 92 4 L 92 14" fill="none" stroke="currentColor" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M 58 44 C 58 52, 50 56, 40 56 C 28 56, 20 62, 20 72 C 20 82, 28 88, 40 88 C 50 88, 58 84, 62 78 M 40 88 C 32 88, 26 84, 24 78 M 30 44 C 32 38, 38 34, 46 34"
				fill="none" stroke="currentColor" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
		</symbol>
	</defs>
</svg>

<!-- ════════════ PRIMARY NAVIGATION ════════════ -->
<header class="sl-site-header">
	<nav class="sl-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'scorelens' ); ?>">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sl-brand" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<svg class="sl-brand-mark" viewBox="0 0 100 100" aria-hidden="true">
				<use href="#scorelens-mark"/>
			</svg>
			<span class="sl-brand-name">
				<?php bloginfo( 'name' ); ?>
			</span>
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
