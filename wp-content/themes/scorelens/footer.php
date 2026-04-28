<!-- ════════════ CTA BLOCK ════════════ -->
<div class="sl-cta-block" id="sl-cta">
	<h2>
		<?php esc_html_e( 'Stop guessing.', 'scorelens' ); ?>
		<span class="sl-serif"><?php esc_html_e( 'Start improving', 'scorelens' ); ?></span>.
	</h2>
	<p class="sl-cta-tagline"><?php esc_html_e( 'Simple. Accurate. Effective.', 'scorelens' ); ?></p>
	<p>
		<?php esc_html_e( 'Join the aspirants who stopped practising blindly — and started preparing like the real exam. Start with a free mock test today.', 'scorelens' ); ?>
	</p>
	<a href="#" class="sl-btn sl-btn--primary sl-btn--lg">
		<span><?php esc_html_e( 'Take your free mock →', 'scorelens' ); ?></span>
	</a>
</div>

<!-- ════════════ SITE FOOTER ════════════ -->
<footer class="sl-site-footer" role="contentinfo">

	<!-- Brand column -->
	<div class="sl-foot-brand">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sl-brand sl-foot-logo">
			<svg class="sl-brand-mark" viewBox="0 0 100 100" aria-hidden="true">
				<use href="#scorelens-mark"/>
			</svg>
			<span class="sl-brand-name"><?php bloginfo( 'name' ); ?></span>
		</a>
		<p class="sl-foot-tag"><?php esc_html_e( 'Simple. Accurate. Effective.', 'scorelens' ); ?></p>
		<p class="sl-foot-company">
			<?php
			printf(
				/* translators: %s: company name */
				esc_html__( 'A product of %s.', 'scorelens' ),
				'<strong>' . esc_html__( 'Omnexa Solutions', 'scorelens' ) . '</strong>'
			);
			?>
		</p>
	</div>

	<!-- Footer nav: Product -->
	<div class="sl-foot-col">
		<h5><?php esc_html_e( 'Product', 'scorelens' ); ?></h5>
		<ul>
			<?php
			if ( has_nav_menu( 'sl-footer-1' ) ) {
				wp_nav_menu( [
					'theme_location' => 'sl-footer-1',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'depth'          => 1,
					'fallback_cb'    => false,
				] );
			} else {
				scorelens_footer_nav_fallback( [
					'#sl-features' => __( 'Features',    'scorelens' ),
					'#sl-pricing'  => __( 'Pricing',     'scorelens' ),
					'#sl-how'      => __( 'How it works','scorelens' ),
				] );
			}
			?>
		</ul>
	</div>

	<!-- Footer nav: Company -->
	<div class="sl-foot-col">
		<h5><?php esc_html_e( 'Company', 'scorelens' ); ?></h5>
		<ul>
			<?php
			if ( has_nav_menu( 'sl-footer-2' ) ) {
				wp_nav_menu( [
					'theme_location' => 'sl-footer-2',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'depth'          => 1,
					'fallback_cb'    => false,
				] );
			} else {
				scorelens_footer_nav_fallback( [
					'#about'   => __( 'About Omnexa',        'scorelens' ),
					'#contact' => __( 'Contact',              'scorelens' ),
					'#privacy' => __( 'Privacy Policy',       'scorelens' ),
					'#terms'   => __( 'Terms and Conditions', 'scorelens' ),
				] );
			}
			?>
		</ul>
	</div>

	<!-- Footer meta bar -->
	<div class="sl-foot-meta">
		<div>
			<?php
			printf(
				/* translators: 1: year, 2: company, 3: product */
				esc_html__( '© %1$s %2$s · %3$s', 'scorelens' ),
				esc_html( date( 'Y' ) ),
				esc_html__( 'Omnexa Solutions', 'scorelens' ),
				esc_html( get_bloginfo( 'name' ) )
			);
			?>
		</div>
		<div><?php esc_html_e( 'Practice like the real exam. Improve faster with clarity.', 'scorelens' ); ?></div>
	</div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
