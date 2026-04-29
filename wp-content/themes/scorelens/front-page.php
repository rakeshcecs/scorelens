<?php
/**
 * Front Page Template — ScoreLens Landing Page
 *
 * @package ScoreLens
 * @version 2.0.0
 */

get_header();
?>

<!-- ════════════ HERO ════════════ -->
<section class="sl-hero">
	<div class="sl-hero-inner">

		<div class="sl-hero-content">

			<div class="sl-badge sl-fade">
				<span class="sl-badge-dot"></span>
				<?php esc_html_e( 'Gain the decisive AI advantage to maximize your score', 'scorelens' ); ?>
			</div>

			<h1 class="sl-hero-h sl-fade sl-d1">
				<?php esc_html_e( 'Practice like the', 'scorelens' ); ?>
				<span class="sl-serif"><?php esc_html_e( 'real exam.', 'scorelens' ); ?></span>
				<?php esc_html_e( 'Improve faster with clarity.', 'scorelens' ); ?>
			</h1>

			<h2 class="sl-section-h">
		<span class="sl-serif">	<?php esc_html_e( 'Tailored for SSC CGL, CHSL, and State PSCs', 'scorelens' ); ?>	</span>
	</h2>

			<span class="sl-hero-tagline sl-fade sl-d1">
				<?php esc_html_e( 'Simple. Accurate. Effective.', 'scorelens' ); ?>
			</span>

			<p class="sl-hero-lede sl-fade sl-d2">
				<?php esc_html_e( 'ScoreLens recreates the real SSC and PSC exam environment — full-length mocks, strict timing, and actual exam patterns — and delivers AI-driven insights to pinpoint what\'s holding your score back and how to fix it.', 'scorelens' ); ?>
			</p>

			<div class="sl-hero-cta sl-fade sl-d3">
				<a href="#sl-cta" class="sl-btn sl-btn--primary sl-btn--lg" data-sl-modal-open="sl-cta-modal">
					<span><?php esc_html_e( 'Start free — take a mock test', 'scorelens' ); ?></span>
				</a>
				<a href="#sl-how" class="sl-btn sl-btn--ghost sl-btn--lg">
					<?php esc_html_e( 'See how it works', 'scorelens' ); ?>
				</a>
			</div>

		</div><!-- .sl-hero-content -->

		<div class="sl-hero-visual sl-fade sl-d2">
			<div class="sl-hero-photo">
				<img
					src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=900&q=80&auto=format&fit=crop"
					alt="<?php esc_attr_e( 'SSC PSC aspirant studying', 'scorelens' ); ?>"
					loading="lazy"
					width="900"
					height="600"
					class="sl-hero-photo-img"
				/>
				<div class="sl-hero-photo-overlay">
					<span class="sl-photo-tag"><?php esc_html_e( 'EXAM READY → EXAM PRO', 'scorelens' ); ?></span>
					<h4><?php esc_html_e( 'From scattered practice to structured, data-driven preparation.', 'scorelens' ); ?></h4>
				</div>
			</div>

			<div class="sl-hero-floating-card sl-card--1">
				<div class="sl-card-label"><?php esc_html_e( 'Accuracy this week', 'scorelens' ); ?></div>
				<div class="sl-card-value">82% <span class="sl-card-change">↑ 14%</span></div>
			</div>

			<div class="sl-hero-floating-card sl-card--2">
				<div class="sl-card-label"><?php esc_html_e( 'Weak areas identified', 'scorelens' ); ?></div>
				<div class="sl-card-value">4 <?php esc_html_e( 'topics', 'scorelens' ); ?></div>
			</div>
		</div><!-- .sl-hero-visual -->

	</div>
</section>

<!-- ════════════ STATS ════════════ -->
<div class="sl-stats sl-fade sl-d4">
	<div class="sl-stat">
		<div class="sl-stat-num">10,000<sup>+</sup></div>
		<div class="sl-stat-label"><?php esc_html_e( 'Questions mapped to SSC syllabus', 'scorelens' ); ?></div>
	</div>
	<div class="sl-stat">
		<div class="sl-stat-num">100<sup>+</sup></div>
		<div class="sl-stat-label"><?php esc_html_e( 'Full-length mocks &amp; topic tests', 'scorelens' ); ?></div>
	</div>
	<div class="sl-stat">
		<div class="sl-stat-num">AI</div>
		<div class="sl-stat-label"><?php esc_html_e( 'Powered performance analysis', 'scorelens' ); ?></div>
	</div>
	<div class="sl-stat">
		<div class="sl-stat-num">4</div>
		<div class="sl-stat-label"><?php esc_html_e( 'Core subjects covered', 'scorelens' ); ?></div>
	</div>
</div>

<!-- ════════════ EXAM STRIP ════════════ -->
<div class="sl-exam-strip">
	<span class="sl-exam-strip-label"><?php esc_html_e( 'Designed for', 'scorelens' ); ?></span>

	<?php
	/* SSC exams — primary/highlighted variant */
	$ssc_exams = [ 'SSC CGL', 'SSC CHSL', 'SSC MTS', 'SSC GD', 'SSC JEE' ];
	foreach ( $ssc_exams as $exam ) {
		echo '<span class="sl-exam-badge sl-exam-badge--primary">' . esc_html( $exam ) . '</span>';
	}

	/* PSC exams — standard variant */
	$psc_exams = [ 'MPPSC', 'UPPSC', 'BPSC', 'RPSC' ];
	foreach ( $psc_exams as $exam ) {
		echo '<span class="sl-exam-badge">' . esc_html( $exam ) . '</span>';
	}
	?>
</div>

<!-- ════════════ FEATURES ════════════ -->
<section class="sl-block" id="sl-features">
	<div class="sl-section-label"><?php esc_html_e( 'Features', 'scorelens' ); ?></div>
	<h2 class="sl-section-h">
		<?php esc_html_e( 'Most mock platforms test you.', 'scorelens' ); ?>
		<span class="sl-serif"><?php esc_html_e( 'We help you improve', 'scorelens' ); ?></span>.
	</h2>
	<p class="sl-section-lede">
		<?php esc_html_e( 'ScoreLens is built around what SSC and PSC aspirants actually need: realistic practice, honest analysis, and a way to track whether you\'re actually improving.', 'scorelens' ); ?>
	</p>

	<div class="sl-features">

		<div class="sl-feature">
			<div class="sl-feature-icon">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/></svg>
			</div>
			<h3><?php esc_html_e( 'Full-length mock tests', 'scorelens' ); ?></h3>
			<p><?php esc_html_e( 'Complete SSC and PSC papers with the exact section structure, question count, and negative marking rules of the real exam.', 'scorelens' ); ?></p>
		</div>

		<div class="sl-feature">
			<div class="sl-feature-icon">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
			</div>
			<h3><?php esc_html_e( 'Real exam simulation', 'scorelens' ); ?></h3>
			<p><?php esc_html_e( 'Strict timer, locked navigation, no shortcuts. Practice under the same pressure you\'ll face on exam day — not a relaxed quiz.', 'scorelens' ); ?></p>
		</div>

		<div class="sl-feature">
			<div class="sl-feature-icon">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 3v18h18"/><path d="M7 14l4-4 4 4 5-5"/></svg>
			</div>
			<h3><?php esc_html_e( 'Targeted practice', 'scorelens' ); ?></h3>
			<p><?php esc_html_e( 'Focus on specific topics like Data Interpretation, Polity, or Reasoning puzzles — whenever you need.', 'scorelens' ); ?></p>
		</div>

		<div class="sl-feature">
			<div class="sl-feature-icon">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
			</div>
			<h3><?php esc_html_e( 'Deep performance breakdown', 'scorelens' ); ?></h3>
			<p><?php esc_html_e( 'Understand your score across subject → topic → question level. So you know exactly where to focus your next study session.', 'scorelens' ); ?></p>
		</div>

		<div class="sl-feature">
			<div class="sl-feature-icon">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
			</div>
			<h3><?php esc_html_e( 'Time-per-question tracking', 'scorelens' ); ?></h3>
			<p><?php esc_html_e( 'Find out which questions you over-think and which you rush through. Most aspirants lose marks to pacing, not knowledge gaps.', 'scorelens' ); ?></p>
		</div>

		<div class="sl-feature">
			<div class="sl-feature-icon">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
			</div>
			<h3><?php esc_html_e( 'Progress over time', 'scorelens' ); ?></h3>
			<p><?php esc_html_e( 'Track your historical performance and see if you\'re actually improving — not just feeling like you are. Honest data, exam after exam.', 'scorelens' ); ?></p>
		</div>

	</div>
</section>

<!-- ════════════ ANALYTICS SHOWCASE ════════════ -->
<section class="sl-block sl-block--no-pt">
	<div class="sl-showcase">
		<div class="sl-showcase-grid">

			<div class="sl-showcase-copy">
				<div class="sl-badge">
					<span class="sl-badge-dot"></span>
					<?php esc_html_e( 'Performance analytics', 'scorelens' ); ?>
				</div>
				<h3>
					<?php esc_html_e( 'From a score, to a', 'scorelens' ); ?>
					<span class="sl-serif"><?php esc_html_e( 'strategy', 'scorelens' ); ?></span>.
				</h3>
				<p>
					<?php esc_html_e( 'After every mock, ScoreLens breaks down your performance by subject and topic — showing you exactly which areas are strong, which are weak, and where to spend your next study hour.', 'scorelens' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'This is where most aspirants improve — not by studying more, but by fixing the right things.', 'scorelens' ); ?>
				</p>
				<p>
					<em class="sl-accent-em"><?php esc_html_e( 'No guesswork. No random practice. Just data-driven improvement.', 'scorelens' ); ?></em>
				</p>
			</div>

			<!-- Mock dashboard UI -->
			<div class="sl-dashboard">
				<div class="sl-dash-header">
					<div>
						<div class="sl-dash-meta"><?php esc_html_e( 'SSC CGL · Tier I · Mock 04', 'scorelens' ); ?></div>
						<div class="sl-dash-title"><?php esc_html_e( 'Taken 12 April 2026', 'scorelens' ); ?></div>
					</div>
					<div class="sl-dash-score">
						<div class="sl-dash-score-num">154<sup>/200</sup></div>
						<div class="sl-dash-projected"><?php esc_html_e( '77% ACCURACY', 'scorelens' ); ?></div>
					</div>
				</div>

				<div class="sl-dash-section-label"><?php esc_html_e( 'Subject Accuracy', 'scorelens' ); ?></div>

				<div class="sl-topic">
					<div class="sl-topic-name"><?php esc_html_e( 'General Awareness', 'scorelens' ); ?></div>
					<div class="sl-topic-bar"><span class="sl-topic-fill sl-topic-fill--p88 sl-topic-fill--success"></span></div>
					<div class="sl-topic-pct">88%</div>
				</div>
				<div class="sl-topic">
					<div class="sl-topic-name"><?php esc_html_e( 'English Comprehension', 'scorelens' ); ?></div>
					<div class="sl-topic-bar"><span class="sl-topic-fill sl-topic-fill--p82 sl-topic-fill--success"></span></div>
					<div class="sl-topic-pct">82%</div>
				</div>
				<div class="sl-topic">
					<div class="sl-topic-name"><?php esc_html_e( 'General Intelligence &amp; Reasoning', 'scorelens' ); ?></div>
					<div class="sl-topic-bar"><span class="sl-topic-fill sl-topic-fill--p74 sl-topic-fill--warning"></span></div>
					<div class="sl-topic-pct">74%</div>
				</div>
				<div class="sl-topic">
					<div class="sl-topic-name"><?php esc_html_e( 'Quantitative Aptitude', 'scorelens' ); ?></div>
					<div class="sl-topic-bar"><span class="sl-topic-fill sl-topic-fill--p52 sl-topic-fill--warning"></span></div>
					<div class="sl-topic-pct">52%</div>
				</div>
				<div class="sl-topic sl-topic--sub">
					<div class="sl-topic-name">&nbsp;&nbsp;↳ <?php esc_html_e( 'Data Interpretation', 'scorelens' ); ?></div>
					<div class="sl-topic-bar"><span class="sl-topic-fill sl-topic-fill--p31 sl-topic-fill--danger"></span></div>
					<div class="sl-topic-pct">31%</div>
				</div>

				<div class="sl-ai-note">
					<strong><?php esc_html_e( 'AI Insight', 'scorelens' ); ?></strong>
					<?php esc_html_e( 'Data Interpretation is dragging your Quant score — 31% accuracy with 2.4× higher time than average. Fixing DI alone can improve your overall score by 8–12 marks. Start with 15 DI sets this week.', 'scorelens' ); ?>
				</div>
			</div><!-- .sl-dashboard -->

		</div>
	</div>
</section>

<!-- ════════════ HOW IT WORKS ════════════ -->
<section class="sl-block" id="sl-how">
	<div class="sl-section-label"><?php esc_html_e( 'How it works', 'scorelens' ); ?></div>
	<h2 class="sl-section-h">
		<?php esc_html_e( 'From sign-up to', 'scorelens' ); ?>
		<span class="sl-serif"><?php esc_html_e( 'exam-ready', 'scorelens' ); ?></span>.
	</h2>
	<p class="sl-section-lede">
		<?php esc_html_e( 'A continuous improvement loop designed for serious PSC and SSC aspirants — not casual learners.', 'scorelens' ); ?>
	</p>

	<div class="sl-steps">
		<div class="sl-step">
			<div class="sl-step-num">i</div>
			<h4><?php esc_html_e( 'Choose your exam', 'scorelens' ); ?></h4>
			<p><?php esc_html_e( 'Pick your target — SSC (CGL, CHSL, MTS, GD) or PSC (state). Your whole experience is customized around it.', 'scorelens' ); ?></p>
		</div>
		<div class="sl-step">
			<div class="sl-step-num">ii</div>
			<h4><?php esc_html_e( 'Choose a test', 'scorelens' ); ?></h4>
			<p><?php esc_html_e( 'Full-length mock for exam simulation, or a topic-wise test when you want to drill a specific weak area.', 'scorelens' ); ?></p>
		</div>
		<div class="sl-step">
			<div class="sl-step-num">iii</div>
			<h4><?php esc_html_e( 'Take it timed', 'scorelens' ); ?></h4>
			<p><?php esc_html_e( 'Real timer, locked navigation, proper negative marking. Build the discipline you\'ll need on exam day.', 'scorelens' ); ?></p>
		</div>
		<div class="sl-step">
			<div class="sl-step-num">iv</div>
			<h4><?php esc_html_e( 'Practice, Improve &amp; Repeat', 'scorelens' ); ?></h4>
			<p><?php esc_html_e( 'Instantly understand your weak areas, time usage, and accuracy gaps. Fix weak areas → take next mock → track your progress.', 'scorelens' ); ?></p>
		</div>
	</div>
</section>

<!-- ════════════ TESTIMONIALS ════════════ -->
<section class="sl-block sl-block--pt-sm" id="sl-testimonials">
	<div class="sl-section-label"><?php esc_html_e( 'Early users · Real feedback', 'scorelens' ); ?></div>
	<h2 class="sl-section-h">
		<?php esc_html_e( 'Aspirants who stopped guessing', 'scorelens' ); ?>
		<span class="sl-serif"><?php esc_html_e( 'and started improving', 'scorelens' ); ?></span>.
	</h2>

	<div class="sl-testimonials">

		<div class="sl-testimonial">
			<div class="sl-testimonial-stars" aria-label="<?php esc_attr_e( '5 stars', 'scorelens' ); ?>">★★★★★</div>
			<div class="sl-testimonial-quote">
				<?php esc_html_e( '"I was taking 2-3 mocks a week but my score wasn\'t moving. ScoreLens showed me I was', 'scorelens' ); ?>
				<em><?php esc_html_e( 'spending 40% of my time on just 15% of the questions', 'scorelens' ); ?></em>
				<?php esc_html_e( '— fixing that alone pushed my mock from 118 to 147."', 'scorelens' ); ?>
			</div>
			<div class="sl-testimonial-author">
				<div class="sl-testimonial-avatar" data-initials="RM">
					<img
						src="<?php echo get_template_directory_uri(); ?>/assets/images/test02.jpg"
						alt="<?php esc_attr_e( 'Rohan M.', 'scorelens' ); ?>"
						loading="lazy"
						width="44"
						height="44"
					/>
				</div>
				<div>
					<div class="sl-testimonial-name"><?php esc_html_e( 'Rohan M.', 'scorelens' ); ?></div>
					<div class="sl-testimonial-meta"><?php esc_html_e( 'SSC CGL aspirant · Lucknow', 'scorelens' ); ?></div>
				</div>
			</div>
		</div>

		<div class="sl-testimonial">
			<div class="sl-testimonial-stars" aria-label="<?php esc_attr_e( '5 stars', 'scorelens' ); ?>">★★★★★</div>
			<div class="sl-testimonial-quote">
				<?php esc_html_e( '"I\'m preparing from home with just YouTube and notes. ScoreLens gave me the', 'scorelens' ); ?>
				<em><?php esc_html_e( 'one thing I was missing', 'scorelens' ); ?></em>
				<?php esc_html_e( '— honest analysis of where I actually stand. The topic-wise breakdown is gold."', 'scorelens' ); ?>
			</div>
			<div class="sl-testimonial-author">
				<div class="sl-testimonial-avatar" data-initials="AR">
					<img
						src="<?php echo get_template_directory_uri(); ?>/assets/images/test01.jpg"
						alt="<?php esc_attr_e( 'Ananya R.', 'scorelens' ); ?>"
						loading="lazy"
						width="44"
						height="44"
					/>
				</div>
				<div>
					<div class="sl-testimonial-name"><?php esc_html_e( 'Ananya R.', 'scorelens' ); ?></div>
					<div class="sl-testimonial-meta"><?php esc_html_e( 'SSC CGL aspirant · Indore', 'scorelens' ); ?></div>
				</div>
			</div>
		</div>

		<div class="sl-testimonial">
			<div class="sl-testimonial-stars" aria-label="<?php esc_attr_e( '5 stars', 'scorelens' ); ?>">★★★★★</div>
			<div class="sl-testimonial-quote">
				<?php esc_html_e( '"Every other platform just throws tests at you. ScoreLens is the first one that felt like someone was actually', 'scorelens' ); ?>
				<em><?php esc_html_e( 'watching how I improve', 'scorelens' ); ?></em>.
				<?php esc_html_e( 'The progress tracking keeps me accountable."', 'scorelens' ); ?>
			</div>
			<div class="sl-testimonial-author">
				<div class="sl-testimonial-avatar" data-initials="KS">
					<img
						src="<?php echo get_template_directory_uri(); ?>/assets/images/03.jpg"
						alt="<?php esc_attr_e( 'Kavya S.', 'scorelens' ); ?>"
						loading="lazy"
						width="44"
						height="44"
					/>
				</div>
				<div>
					<div class="sl-testimonial-name"><?php esc_html_e( 'Kavya S.', 'scorelens' ); ?></div>
					<div class="sl-testimonial-meta"><?php esc_html_e( 'SSC CHSL aspirant · Pune', 'scorelens' ); ?></div>
				</div>
			</div>
		</div>

	</div>
</section>

<!-- ════════════ PRICING ════════════ -->
<section class="sl-block" id="sl-pricing">
	<div class="sl-section-label"><?php esc_html_e( 'Pricing', 'scorelens' ); ?></div>
	<h2 class="sl-section-h">
		<?php esc_html_e( 'Simple pricing.', 'scorelens' ); ?>
		<span class="sl-serif"><?php esc_html_e( 'Real results', 'scorelens' ); ?></span>.
	</h2>
	<p class="sl-section-lede">
		<?php esc_html_e( 'A freemium model built for aspirants on a budget. No hidden costs, no trial traps.', 'scorelens' ); ?>
	</p>

	<div class="sl-pricing">

		<!-- Free plan — live -->
		<div class="sl-plan">
			<div class="sl-plan-name"><?php esc_html_e( 'FREE', 'scorelens' ); ?></div>
			<div class="sl-plan-price">₹0<small><?php esc_html_e( ' /forever', 'scorelens' ); ?></small></div>
			<div class="sl-plan-desc"><?php esc_html_e( 'Try the platform, zero strings attached.', 'scorelens' ); ?></div>
			<ul>
				<li><?php esc_html_e( '2 full-length mock tests per month', 'scorelens' ); ?></li>
				<li><?php esc_html_e( 'Basic score &amp; subject breakdown', 'scorelens' ); ?></li>
				<li><?php esc_html_e( 'Topic-wise practice (limited)', 'scorelens' ); ?></li>
				<li><?php esc_html_e( 'Community access', 'scorelens' ); ?></li>
			</ul>
			<a href="#" class="sl-btn sl-btn--ghost" data-sl-modal-open="sl-cta-modal"><?php esc_html_e( 'Start free', 'scorelens' ); ?></a>
		</div>

		<!-- Pro Monthly — featured, coming soon -->
		<div class="sl-plan sl-plan--featured">
			<span class="sl-plan-ribbon"><?php esc_html_e( 'Most popular', 'scorelens' ); ?></span>
			<div class="sl-plan-name"><?php esc_html_e( 'PRO · MONTHLY', 'scorelens' ); ?></div>
			<div class="sl-plan-price">₹299<small><?php esc_html_e( ' /month', 'scorelens' ); ?></small></div>
			<div class="sl-plan-desc"><?php esc_html_e( 'Full platform access, month-to-month.', 'scorelens' ); ?></div>
			<ul>
				<li><?php esc_html_e( 'Unlimited full-length mocks', 'scorelens' ); ?></li>
				<li><?php esc_html_e( 'Unlimited topic-wise tests', 'scorelens' ); ?></li>
				<li><?php esc_html_e( 'Complete AI performance analytics', 'scorelens' ); ?></li>
				<li><?php esc_html_e( 'Time-per-question tracking', 'scorelens' ); ?></li>
				<li><?php esc_html_e( 'Historical progress trends', 'scorelens' ); ?></li>
			</ul>
			<a href="#" class="sl-btn sl-btn--disabled" aria-disabled="true">
				<span><?php esc_html_e( 'Coming soon', 'scorelens' ); ?></span>
			</a>
		</div>

		<!-- Pro Annual — coming soon -->
		<div class="sl-plan">
			<div class="sl-plan-name"><?php esc_html_e( 'PRO · ANNUAL', 'scorelens' ); ?></div>
			<div class="sl-plan-price">₹2,499<small><?php esc_html_e( ' /year', 'scorelens' ); ?></small></div>
			<div class="sl-plan-desc"><?php esc_html_e( 'Best value · save ₹1,089 vs monthly.', 'scorelens' ); ?></div>
			<ul>
				<li><?php esc_html_e( 'Everything in Pro Monthly', 'scorelens' ); ?></li>
				<li><?php esc_html_e( 'Priority support', 'scorelens' ); ?></li>
				<li><?php esc_html_e( 'Early access to new exams', 'scorelens' ); ?></li>
				<li><?php esc_html_e( 'Locked-in price for 12 months', 'scorelens' ); ?></li>
			</ul>
			<a href="#" class="sl-btn sl-btn--disabled" aria-disabled="true">
				<?php esc_html_e( 'Coming soon', 'scorelens' ); ?>
			</a>
		</div>

	</div>
</section>

<?php get_footer(); ?>
