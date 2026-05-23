<?php
/**
 * Template Name: SSC Weak Topic Analysis
 * Template Post Type: page
 *
 * @package ScoreLens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_head', function () {
	?>
	<script type="application/ld+json">
	<?php
	$faqs = [
		[ 'q' => 'How can I identify weak topics in SSC exams?', 'a' => 'Analyze repeated mistakes, low-accuracy areas, and topics where excessive time is consumed during mock tests.' ],
		[ 'q' => 'Why is weak-topic analysis important?', 'a' => 'Weak-topic analysis helps aspirants focus preparation efficiently and improve overall exam performance faster.' ],
		[ 'q' => 'How often should I analyze weak topics?', 'a' => 'Weak-topic analysis should be done after every mock test to track progress continuously.' ],
		[ 'q' => 'Can AI analytics help identify weak topics?', 'a' => 'Yes. AI-powered analytics can automatically detect patterns, low-accuracy areas, and repeated mistakes more effectively.' ],
		[ 'q' => 'How can I improve weak SSC topics quickly?', 'a' => 'Focused revision, targeted practice, sectional tests, and regular performance analysis help improve weak topics faster.' ],
		[ 'q' => 'Should I focus only on weak topics?', 'a' => 'No. Aspirants should maintain strong areas while gradually improving weak sections strategically.' ],
	];
	echo wp_json_encode( [
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => array_map( function ( $faq ) {
			return [
				'@type'          => 'Question',
				'name'           => $faq['q'],
				'acceptedAnswer' => [
					'@type' => 'Answer',
					'text'  => $faq['a'],
				],
			];
		}, $faqs ),
	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	?>
	</script>
	<?php
}, 2 );

get_header();
?>

<main class="sl-weak-topics-page" id="sl-primary">

  <?php
    // get_template_part('template-parts/breadcrumb', null, array( 'title' => 'SSC Weak Topic Analysis' ) );
    // get_template_part('template-parts/breadcrumb');
  ?>


  <!-- ════════════ FOLD 1 — HERO ════════════ -->
  <section class="hero">
    <div class="hero-inner">
      <div>
        <div class="badge fade"><span class="badge-dot"></span>Topic-level AI analytics</div>
        <h1 class="hero-h fade d1">SSC Weak Topic Analysis for <span class="serif">Smarter Preparation</span></h1>
        <p class="hero-lede fade d2">Identify weak topics, track repeated mistakes, and improve your SSC exam performance using AI-powered mock test analytics &mdash; automatically, after every attempt.</p>
        <div class="hero-cta fade d3">
          <a href="#sl-cta" class="btn btn-primary btn-lg" data-sl-modal-open="sl-cta-modal"><span>Analyze Weak Topics Free</span></a>
          <a href="#sample" class="btn btn-ghost btn-lg">View AI Performance Insights</a>
        </div>
      </div>

      <!-- Topic heatmap visual -->
      <div class="heatmap-card fade d2">
        <div class="hm-label">Your Topic Performance Heatmap</div>

        <div class="hm-subject">
          <div class="hm-subject-name">Quantitative Aptitude</div>
          <div class="hm-topics">
            <span class="hm-topic strong">Percentage 92%</span>
            <span class="hm-topic good">Profit &amp; Loss 74%</span>
            <span class="hm-topic weak">Time &amp; Work 61%</span>
            <span class="hm-topic vweak">Data Interpretation 31%</span>
            <span class="hm-topic weak">Algebra 58%</span>
          </div>
        </div>

        <div class="hm-subject">
          <div class="hm-subject-name">Reasoning</div>
          <div class="hm-topics">
            <span class="hm-topic strong">Analogies 90%</span>
            <span class="hm-topic good">Series 78%</span>
            <span class="hm-topic weak">Seating Arrangement 61%</span>
            <span class="hm-topic vweak">Puzzles 44%</span>
          </div>
        </div>

        <div class="hm-subject">
          <div class="hm-subject-name">General Awareness</div>
          <div class="hm-topics">
            <span class="hm-topic good">History 76%</span>
            <span class="hm-topic weak">Polity 64%</span>
            <span class="hm-topic vweak">Current Affairs 49%</span>
            <span class="hm-topic weak">Geography 62%</span>
          </div>
        </div>

        <div class="hm-legend">
          <div class="hm-legend-item"><div class="hm-legend-dot hm-legend-dot--strong"></div>Strong (85%+)</div>
          <div class="hm-legend-item"><div class="hm-legend-dot hm-legend-dot--good"></div>Good (70&ndash;84%)</div>
          <div class="hm-legend-item"><div class="hm-legend-dot hm-legend-dot--weak"></div>Weak (50&ndash;69%)</div>
          <div class="hm-legend-item"><div class="hm-legend-dot hm-legend-dot--vweak"></div>Very Weak (&lt;50%)</div>
        </div>
      </div>
    </div>
  </section>


  <!-- ════════════ FOLD 2 — WHY IT MATTERS ════════════ -->
  <div class="alt-section">
    <section class="section">
      <div class="section-label">The core problem</div>
      <h2 class="section-h">Why Weak Topic Analysis <span class="serif">Matters in SSC Preparation</span></h2>

      <div class="why-split">
        <div class="why-copy">
          <p>Many SSC aspirants continue practicing randomly without identifying the exact topics responsible for score loss. As a result, they spend excessive time on strong areas while weak subjects continue reducing their overall score.</p>
          <p>Weak-topic analysis shifts preparation from random to targeted &mdash; so every study hour drives the maximum score improvement.</p>
          <ul class="why-points">
            <li>Focus preparation on exactly what's costing you marks</li>
            <li>Improve low-scoring sections with precision, not guesswork</li>
            <li>Reduce repeated mistakes in the same topic areas</li>
            <li>Increase overall accuracy across all four subjects</li>
            <li>Build a targeted, data-driven study strategy</li>
          </ul>
        </div>
        <div class="study-compare reveal">
          <div class="study-col random">
            <div class="sc-head">
              <div class="sc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
              <h4>Random Practice</h4>
            </div>
            <p class="sc-desc">Revising whatever feels comfortable. Spending hours on already-strong topics. No measurement of what's actually weak.</p>
            <div class="sc-result">Score stays flat</div>
          </div>
          <div class="study-col targeted">
            <div class="sc-head">
              <div class="sc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
              <h4>Targeted Practice</h4>
            </div>
            <p class="sc-desc">Identifying exact weak topics via analytics. Practicing only where it moves your score. Tracking improvement topic by topic.</p>
            <div class="sc-result">Score improves consistently</div>
          </div>
        </div>
      </div>
    </section>
  </div>


  <!-- ════════════ FOLD 3 — IDENTIFY WEAK TOPICS ════════════ -->
  <section class="section" id="signals">
    <div class="section-label">Warning signs</div>
    <h2 class="section-h">How To Identify Weak Topics <span class="serif">in SSC Exams</span></h2>
    <p class="section-lede">Six clear signals that a topic is weak &mdash; look for these patterns across multiple mock tests, not just in one attempt.</p>

    <div class="signals-grid">
      <div class="signal-card lvl-high reveal">
        <div class="signal-top">
          <div class="signal-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
          <span class="signal-badge">Critical</span>
        </div>
        <h3>Repeated Mistakes</h3>
        <p>Making similar mistakes across multiple mock tests usually indicates conceptual weakness &mdash; not just a bad day.</p>
      </div>
      <div class="signal-card lvl-high reveal">
        <div class="signal-top">
          <div class="signal-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 14l4-4 4 4 5-5"/></svg></div>
          <span class="signal-badge">Critical</span>
        </div>
        <h3>Low Accuracy Percentage</h3>
        <p>Consistently low accuracy in specific topics signals poor understanding or lack of sufficient practice in that area.</p>
      </div>
      <div class="signal-card lvl-med reveal">
        <div class="signal-top">
          <div class="signal-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></div>
          <span class="signal-badge">High</span>
        </div>
        <h3>High Time Consumption</h3>
        <p>Spending excessive time on certain question types indicates weak confidence or inefficient solving methods.</p>
      </div>
      <div class="signal-card lvl-med reveal">
        <div class="signal-top">
          <div class="signal-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/></svg></div>
          <span class="signal-badge">High</span>
        </div>
        <h3>Frequent Guessing</h3>
        <p>Over-dependence on guesses in specific sections often leads to negative marking &mdash; a sure sign of weak preparation.</p>
      </div>
      <div class="signal-card lvl-low reveal">
        <div class="signal-top">
          <div class="signal-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div>
          <span class="signal-badge">Medium</span>
        </div>
        <h3>Avoiding Certain Questions</h3>
        <p>Skipping particular topics repeatedly is often a sign of weak preparation &mdash; not just strategic skipping.</p>
      </div>
      <div class="signal-card lvl-low reveal">
        <div class="signal-top">
          <div class="signal-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
          <span class="signal-badge">Medium</span>
        </div>
        <h3>Score Fluctuations</h3>
        <p>Unstable section-wise scores usually highlight inconsistent topic mastery &mdash; knowledge gaps that surface unpredictably.</p>
      </div>
    </div>
  </section>


  <!-- ════════════ FOLD 4 — STEP-BY-STEP ════════════ -->
  <div class="alt-section">
    <section class="section" id="framework">
      <div class="section-label">The process</div>
      <h2 class="section-h">Step-by-Step Process to <span class="serif">Analyze Weak Topics</span></h2>
      <p class="section-lede">A six-step framework that turns your mock test data into a precise weak-topic action plan &mdash; repeatable after every attempt.</p>

      <div class="stepper">
        <div class="stepper-item reveal">
          <div class="stepper-num">i</div>
          <h4>Review Section-wise Performance</h4>
          <p>Analyze scores separately for Quantitative Aptitude, Reasoning, English, and General Awareness to identify which subject is dragging overall score.</p>
        </div>
        <div class="stepper-item reveal">
          <div class="stepper-num">ii</div>
          <h4>Identify Frequently Incorrect Topics</h4>
          <p>Track which topics generate repeated mistakes across multiple mocks &mdash; not just in a single attempt. Patterns, not outliers.</p>
        </div>
        <div class="stepper-item reveal">
          <div class="stepper-num">iii</div>
          <h4>Measure Accuracy Topic-wise</h4>
          <p>Calculate topic-wise accuracy instead of focusing only on overall score. A 92% section average can hide a 31% sub-topic disaster.</p>
        </div>
        <div class="stepper-item reveal">
          <div class="stepper-num">iv</div>
          <h4>Analyze Time Spent Per Topic</h4>
          <p>Identify topics where solving speed is consistently low &mdash; excessive time on a topic usually signals conceptual uncertainty.</p>
        </div>
        <div class="stepper-item reveal">
          <div class="stepper-num">v</div>
          <h4>Prioritize High-Impact Weak Areas</h4>
          <p>Focus first on topics that contribute heavily to overall score reduction. Fix Data Interpretation before Current Affairs if DI costs more marks.</p>
        </div>
        <div class="stepper-item reveal">
          <div class="stepper-num">vi</div>
          <h4>Create a Targeted Practice Plan</h4>
          <p>Build revision and practice schedules specifically around weak topics &mdash; not the topics you're already comfortable with.</p>
        </div>
      </div>
    </section>
  </div>


  <!-- ════════════ FOLD 5 — COMMON WEAK TOPICS ════════════ -->
  <section class="section" id="common-topics">
    <div class="section-label">Where most aspirants struggle</div>
    <h2 class="section-h">Common Weak Topics Faced by <span class="serif">SSC Aspirants</span></h2>
    <p class="section-lede">These are the topics that consistently drag scores down across SSC CGL, CHSL, MTS, and GD &mdash; based on real mock test performance data.</p>

    <div class="subjects-grid">
      <div class="subject-card" data-subject="quant">
        <div class="subject-header subj-quant">
          <div class="subject-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg></div>
          <div class="subject-title">Quantitative Aptitude</div>
          <svg class="subject-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </div>
        <div class="subject-body">
          <div class="subject-body-inner">
            <span class="topic-pill t-vweak">Data Interpretation</span>
            <span class="topic-pill t-weak">Algebra</span>
            <span class="topic-pill t-weak">Percentage</span>
            <span class="topic-pill t-med">Profit &amp; Loss</span>
            <span class="topic-pill t-weak">Time &amp; Work</span>
            <span class="topic-pill t-med">Time, Speed &amp; Distance</span>
          </div>
        </div>
      </div>

      <div class="subject-card" data-subject="reason">
        <div class="subject-header subj-reason">
          <div class="subject-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg></div>
          <div class="subject-title">General Intelligence &amp; Reasoning</div>
          <svg class="subject-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </div>
        <div class="subject-body">
          <div class="subject-body-inner">
            <span class="topic-pill t-vweak">Puzzles</span>
            <span class="topic-pill t-weak">Seating Arrangement</span>
            <span class="topic-pill t-weak">Coding-Decoding</span>
            <span class="topic-pill t-med">Syllogism</span>
            <span class="topic-pill t-med">Blood Relations</span>
          </div>
        </div>
      </div>

      <div class="subject-card" data-subject="english">
        <div class="subject-header subj-english">
          <div class="subject-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg></div>
          <div class="subject-title">English Language &amp; Comprehension</div>
          <svg class="subject-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </div>
        <div class="subject-body">
          <div class="subject-body-inner">
            <span class="topic-pill t-weak">Cloze Test</span>
            <span class="topic-pill t-weak">Error Detection</span>
            <span class="topic-pill t-med">Reading Comprehension</span>
            <span class="topic-pill t-weak">Vocabulary</span>
            <span class="topic-pill t-med">Para Jumbles</span>
          </div>
        </div>
      </div>

      <div class="subject-card" data-subject="ga">
        <div class="subject-header subj-ga">
          <div class="subject-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg></div>
          <div class="subject-title">General Awareness</div>
          <svg class="subject-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </div>
        <div class="subject-body">
          <div class="subject-body-inner">
            <span class="topic-pill t-med">Static GK</span>
            <span class="topic-pill t-vweak">Current Affairs</span>
            <span class="topic-pill t-weak">Polity</span>
            <span class="topic-pill t-weak">Geography</span>
            <span class="topic-pill t-med">Economy</span>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ════════════ FOLD 6 — HOW TO IMPROVE ════════════ -->
  <div class="alt-section">
    <section class="section" id="improve">
      <div class="section-label">Improvement strategy</div>
      <h2 class="section-h">How to Improve Weak Topics <span class="serif">Faster</span></h2>

      <div class="improve-grid">
        <div class="improve-copy">
          <p>Improving weak topics requires focused and structured preparation instead of random practice. Aspirants should revise concepts, practice targeted questions, and track performance improvements regularly.</p>
          <p>The biggest mistake is spending revision time on topics you already know. Once a weak topic is identified, it deserves the first hour of every study session &mdash; not the last.</p>
          <ul class="improve-list">
            <li>Daily targeted practice on identified weak topics</li>
            <li>Maintain an error log with every wrong answer logged</li>
            <li>Topic-wise revision of core concepts and formulas</li>
            <li>Timed sectional tests to simulate real pressure</li>
            <li>Performance tracking after every mock to measure progress</li>
          </ul>
        </div>

        <!-- Before/after progress bars per topic -->
        <div class="progress-card reveal">
          <div class="pc-title">Topic Accuracy &mdash; Before vs After Targeted Practice</div>

          <div class="pc-topic">
            <div class="pc-topic-header">
              <span class="pc-topic-name">Data Interpretation</span>
              <span class="pc-topic-delta">+26%</span>
            </div>
            <div class="pc-bars">
              <div class="pc-bar-row">
                <div class="pc-bar-label">Before</div>
                <div class="pc-bar-track"><div class="pc-bar-fill bar-before pc-bar-fill--w31"></div></div>
                <div class="pc-bar-pct pc-bar-pct--bad">31%</div>
              </div>
              <div class="pc-bar-row">
                <div class="pc-bar-label">After</div>
                <div class="pc-bar-track"><div class="pc-bar-fill bar-after pc-bar-fill--w57"></div></div>
                <div class="pc-bar-pct pc-bar-pct--good">57%</div>
              </div>
            </div>
          </div>

          <div class="pc-topic">
            <div class="pc-topic-header">
              <span class="pc-topic-name">Current Affairs</span>
              <span class="pc-topic-delta">+22%</span>
            </div>
            <div class="pc-bars">
              <div class="pc-bar-row">
                <div class="pc-bar-label">Before</div>
                <div class="pc-bar-track"><div class="pc-bar-fill bar-before pc-bar-fill--w49"></div></div>
                <div class="pc-bar-pct pc-bar-pct--bad">49%</div>
              </div>
              <div class="pc-bar-row">
                <div class="pc-bar-label">After</div>
                <div class="pc-bar-track"><div class="pc-bar-fill bar-after pc-bar-fill--w71"></div></div>
                <div class="pc-bar-pct pc-bar-pct--good">71%</div>
              </div>
            </div>
          </div>

          <div class="pc-topic">
            <div class="pc-topic-header">
              <span class="pc-topic-name">Seating Arrangement</span>
              <span class="pc-topic-delta">+19%</span>
            </div>
            <div class="pc-bars">
              <div class="pc-bar-row">
                <div class="pc-bar-label">Before</div>
                <div class="pc-bar-track"><div class="pc-bar-fill bar-before pc-bar-fill--w61"></div></div>
                <div class="pc-bar-pct pc-bar-pct--warn">61%</div>
              </div>
              <div class="pc-bar-row">
                <div class="pc-bar-label">After</div>
                <div class="pc-bar-track"><div class="pc-bar-fill bar-after pc-bar-fill--w80"></div></div>
                <div class="pc-bar-pct pc-bar-pct--good">80%</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


  <!-- ════════════ FOLD 7 — AI ANALYTICS ════════════ -->
  <section class="section">
    <div class="ai-section">
      <div class="ai-grid">
        <div class="ai-copy">
          <div class="badge"><span class="badge-dot"></span>AI weak-topic detection</div>
          <h2>How AI Analytics <span class="serif">Detect Weak Topics Automatically</span></h2>
          <p>Traditional mock test platforms usually show only overall scores and rankings. AI-powered analytics identify hidden weak areas by analyzing topic-wise accuracy, repeated mistakes, and performance trends &mdash; automatically.</p>
          <p>ScoreLens doesn't just tell you your score. It tells you which topic to study next.</p>
          <ul class="ai-points">
            <li>Detect weak topics automatically after every mock</li>
            <li>Monitor topic-wise accuracy progress over time</li>
            <li>Analyze repeated mistake patterns across attempts</li>
            <li>Identify low-accuracy topics hidden inside passing sections</li>
            <li>Build personalized preparation plans from real data</li>
          </ul>
        </div>

        <div class="ai-heatmap">
          <div class="ahm-header">AI Topic Accuracy Report</div>
          <div class="ahm-rows">
            <div class="ahm-row ahm-strong">
              <div class="ahm-topic">Percentage</div>
              <div class="ahm-pct">92%</div>
              <div class="ahm-tag">Strong</div>
            </div>
            <div class="ahm-row ahm-good">
              <div class="ahm-topic">Reading Comprehension</div>
              <div class="ahm-pct">84%</div>
              <div class="ahm-tag">Good</div>
            </div>
            <div class="ahm-row ahm-weak">
              <div class="ahm-topic">Data Interpretation</div>
              <div class="ahm-pct">58%</div>
              <div class="ahm-tag">Weak</div>
            </div>
            <div class="ahm-row ahm-weak">
              <div class="ahm-topic">Seating Arrangement</div>
              <div class="ahm-pct">61%</div>
              <div class="ahm-tag">Weak</div>
            </div>
            <div class="ahm-row ahm-vweak">
              <div class="ahm-topic">Current Affairs</div>
              <div class="ahm-pct">49%</div>
              <div class="ahm-tag">Very Weak</div>
            </div>
          </div>
          <div class="ahm-note">
            <strong>AI Priority Recommendation</strong>
            Fix Current Affairs and Data Interpretation first &mdash; these two topics are responsible for ~60% of your score loss. Start with 3 DI sets and 30 min of CA daily this week.
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ════════════ FOLD 8 — SAMPLE ANALYSIS ════════════ -->
  <div class="alt-section">
    <section class="section" id="sample">
      <div class="section-label">Example analysis</div>
      <h2 class="section-h">Example of SSC <span class="serif">Weak Topic Analysis</span></h2>
      <p class="section-lede">A real breakdown of topic-level performance &mdash; the kind of analysis ScoreLens generates automatically after every mock attempt.</p>

      <div class="sample-wrap reveal">
        <div class="sample-head">
          <div>
            <div class="sample-meta">SSC CGL &middot; Tier I &middot; Mock #5 &middot; Topic Analysis</div>
            <div class="sample-title">Weak Topic Identification Report &mdash; 18 May 2026</div>
          </div>
          <div class="heat-legend">
            <div class="hl-item"><div class="hl-dot hl-dot--strong"></div>Strong</div>
            <div class="hl-item"><div class="hl-dot hl-dot--good"></div>Good</div>
            <div class="hl-item"><div class="hl-dot hl-dot--weak"></div>Weak</div>
            <div class="hl-item"><div class="hl-dot hl-dot--vweak"></div>Very Weak</div>
          </div>
        </div>

        <table class="heat-table">
          <thead>
            <tr>
              <th>Topic</th>
              <th>Accuracy</th>
              <th>Trend</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="td-topic">Percentage (Quant)</td>
              <td>
                <div class="heat-cell">
                  <div class="heat-bar-track"><div class="heat-bar-fill heat-bar-fill--strong heat-bar-fill--w92"></div></div>
                  <span class="pct-text pct-text--strong">92%</span>
                </div>
              </td>
              <td class="trend-cell trend-cell--up">&uarr; Stable</td>
              <td><span class="status-tag st-strong">Strong</span></td>
            </tr>
            <tr>
              <td class="td-topic">Reading Comprehension</td>
              <td>
                <div class="heat-cell">
                  <div class="heat-bar-track"><div class="heat-bar-fill heat-bar-fill--good heat-bar-fill--w84"></div></div>
                  <span class="pct-text pct-text--good">84%</span>
                </div>
              </td>
              <td class="trend-cell trend-cell--steady">&rarr; Steady</td>
              <td><span class="status-tag st-good">Good</span></td>
            </tr>
            <tr>
              <td class="td-topic">Data Interpretation</td>
              <td>
                <div class="heat-cell">
                  <div class="heat-bar-track"><div class="heat-bar-fill heat-bar-fill--weak heat-bar-fill--w58"></div></div>
                  <span class="pct-text pct-text--weak">58%</span>
                </div>
              </td>
              <td class="trend-cell trend-cell--down">&darr; Declining</td>
              <td><span class="status-tag st-weak">Weak</span></td>
            </tr>
            <tr>
              <td class="td-topic">Seating Arrangement</td>
              <td>
                <div class="heat-cell">
                  <div class="heat-bar-track"><div class="heat-bar-fill heat-bar-fill--weak heat-bar-fill--w61"></div></div>
                  <span class="pct-text pct-text--weak">61%</span>
                </div>
              </td>
              <td class="trend-cell trend-cell--steady">&rarr; Steady</td>
              <td><span class="status-tag st-weak">Weak</span></td>
            </tr>
            <tr>
              <td class="td-topic">Current Affairs</td>
              <td>
                <div class="heat-cell">
                  <div class="heat-bar-track"><div class="heat-bar-fill heat-bar-fill--vweak heat-bar-fill--w49"></div></div>
                  <span class="pct-text pct-text--vweak">49%</span>
                </div>
              </td>
              <td class="trend-cell trend-cell--decline">&darr; Declining</td>
              <td><span class="status-tag st-vweak">Very Weak</span></td>
            </tr>
          </tbody>
        </table>

        <div class="sample-summary">
          <strong>AI Analysis Summary</strong>
          This aspirant performs well in arithmetic basics (Percentage: 92%) but struggles with Data Interpretation and Current Affairs. Focused revision and sectional practice in these two areas can significantly improve the overall mock score &mdash; estimated +12&ndash;18 marks with 2 weeks of targeted work.
        </div>
      </div>
    </section>
  </div>


  <!-- ════════════ FOLD 9 — FAQ ════════════ -->
  <section class="section" id="faq">
    <div class="section-label">FAQ</div>
    <h2 class="section-h">Frequently Asked <span class="serif">Questions</span></h2>

    <div class="faq-list">
      <div class="faq-item">
        <button class="faq-trigger" type="button" aria-expanded="false">
          How can I identify weak topics in SSC exams?
          <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        </button>
        <div class="faq-body"><p>Analyze repeated mistakes, low-accuracy areas, and topics where excessive time is consumed during mock tests. Look for patterns across at least 3&ndash;4 mocks before concluding a topic is consistently weak.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-trigger" type="button" aria-expanded="false">
          Why is weak-topic analysis important?
          <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        </button>
        <div class="faq-body"><p>Weak-topic analysis helps aspirants focus preparation efficiently and improve overall exam performance faster. Without it, aspirants tend to over-practice comfortable topics while weak areas continue to drag their score down.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-trigger" type="button" aria-expanded="false">
          How often should I analyze weak topics?
          <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        </button>
        <div class="faq-body"><p>Weak-topic analysis should be done after every mock test to track progress continuously. A topic that was weak in mock #3 may have improved by mock #6 &mdash; you need fresh data to know.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-trigger" type="button" aria-expanded="false">
          Can AI analytics help identify weak topics?
          <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        </button>
        <div class="faq-body"><p>Yes. AI-powered analytics can automatically detect patterns, low-accuracy areas, and repeated mistakes more effectively than manual review &mdash; and they do it instantly after every single mock attempt.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-trigger" type="button" aria-expanded="false">
          How can I improve weak SSC topics quickly?
          <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        </button>
        <div class="faq-body"><p>Focused revision, targeted practice sets, timed sectional tests, and regular performance analysis help improve weak topics faster. Prioritize the topics with the highest score-improvement potential &mdash; typically those with both low accuracy and high frequency.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-trigger" type="button" aria-expanded="false">
          Should I focus only on weak topics?
          <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        </button>
        <div class="faq-body"><p>No. Aspirants should maintain strong areas while gradually improving weak sections strategically. A good ratio is roughly 70% focus on weak topics and 30% maintenance of strong ones in the weeks leading up to the exam.</p></div>
      </div>
    </div>

    <div class="related-block">
      <div class="section-label related-label">Related resources</div>
      <div class="internal-links">
        <a href="<?php echo esc_url( home_url( '/how-to-analyze-ssc-mock-tests/' ) ); ?>" class="int-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
          How to Analyze SSC Mock Tests
        </a>
        <a href="<?php echo esc_url( home_url( '/how-to-improve-ssc-mock-test-score/' ) ); ?>" class="int-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
          How to Improve SSC Mock Test Score
        </a>
        <a href="<?php echo esc_url( home_url( '/improve-accuracy-in-ssc-exams/' ) ); ?>" class="int-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
          Improve Accuracy in SSC Exams
        </a>
        <a href="<?php echo esc_url( home_url( '/ssc-time-management-strategy/' ) ); ?>" class="int-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
          SSC Time Management Strategy
        </a>
      </div>
    </div>
  </section>


  <!-- ════════════ FOLD 10 — CTA ════════════ -->
  <div class="cta-block" id="cta">
    <h2>Identify Weak Topics and Improve Your SSC Score <span class="serif">Smarter</span></h2>
    <p>Track topic-wise performance, reduce repeated mistakes, and improve your SSC preparation using AI-powered analytics from ScoreLens.</p>
    <div class="cta-btns">
      <a href="#sl-cta" class="btn btn-primary btn-lg" data-sl-modal-open="sl-cta-modal"><span>Start Free Weak Topic Analysis &rarr;</span></a>
      <a href="#sample" class="btn btn-ghost btn-lg">Explore AI Performance Insights</a>
    </div>
  </div>

</main>

<?php
get_footer();
