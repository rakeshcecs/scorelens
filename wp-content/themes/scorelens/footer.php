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
	<a href="#" class="sl-btn sl-btn--primary sl-btn--lg" data-sl-modal-open="sl-cta-modal">
		<span><?php esc_html_e( 'Take your free mock →', 'scorelens' ); ?></span>
	</a>
</div>

<!-- ════════════ SITE FOOTER ════════════ -->
<footer class="sl-site-footer" role="contentinfo">

	<!-- Brand column -->
	<div class="sl-foot-brand">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sl-brand sl-foot-logo">
			<img
				class="sl-brand-logo"
				src="<?php echo esc_url( SCORELENS_URI . '/assets/images/scorelens_logo-H.svg' ); ?>"
				alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
				width="160"
				height="40"
			/>
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

<!-- ════════════ CTA MODAL — Lead capture popup ════════════ -->
<?php
/* ─── Edit these to update popup content. The form fields,
 *     CAPTCHA, urgency line and CTA button live inside the
 *     form-plugin shortcode (Fluent Forms / CF7 / WPForms). ─── */
$sl_modal_badge     = __( 'Early access · Launching soon', 'scorelens' );
$sl_modal_title     = __( 'Be among the first to improve your SSC score', 'scorelens' );
$sl_modal_desc      = __( '<strong>ScoreLens is launching soon for SSC aspirants.</strong> Sign up now and we\'ll notify you the moment it goes live — plus give you <strong>1 month of Pro access free.</strong>', 'scorelens' );
$sl_modal_shortcode = '[fluentform id="1"]';
$sl_modal_trust     = __( 'No spam. Just early access + 1 month free Pro.', 'scorelens' );
/* ───────────────────────────────────────────────────────── */
?>
<div class="sl-modal" id="sl-cta-modal" role="dialog" aria-modal="true" aria-labelledby="sl-cta-modal-title" aria-hidden="true">
	<div class="sl-modal-backdrop" data-sl-modal-close></div>
	<div class="sl-modal-dialog" role="document">
		<button class="sl-modal-close" type="button" data-sl-modal-close aria-label="<?php esc_attr_e( 'Close', 'scorelens' ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
				<path d="M18 6L6 18M6 6l12 12"/>
			</svg>
		</button>
		<div class="sl-modal-content">
			<div class="sl-modal-header">
				<div class="sl-badge">
					<span class="sl-badge-dot"></span>
					<?php echo esc_html( $sl_modal_badge ); ?>
				</div>
				<h3 class="sl-modal-title" id="sl-cta-modal-title"><?php echo esc_html( $sl_modal_title ); ?></h3>
				<p class="sl-modal-desc"><?php echo wp_kses( $sl_modal_desc, [ 'strong' => [], 'b' => [], 'em' => [], 'br' => [] ] ); ?></p>
			</div>
			<div class="sl-modal-body">
				<?php echo do_shortcode( $sl_modal_shortcode ); ?>
			</div>
			<?php if ( ! empty( $sl_modal_trust ) ) : ?>
				<p class="sl-modal-trust"><?php echo wp_kses( $sl_modal_trust, [ 'strong' => [], 'b' => [], 'em' => [], 'br' => [] ] ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
