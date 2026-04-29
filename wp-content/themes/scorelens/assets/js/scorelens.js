/**
 * ScoreLens WordPress Theme — Main Script v2.0.0
 *
 * @package ScoreLens
 *
 * Changes from v1:
 *  - Custom cursor removed (per updated design)
 *  - Mouse tracking is now touch-aware (isTouch guard)
 *  - { passive: true } on mousemove for performance
 *  - Stat counter handles comma-formatted numbers (10,000+)
 *  - Avatar image fallback handled via JS class (no onerror attr)
 *  - Scroll reveal uses CSS classes — never inline opacity/transform
 *  - All selectors use .sl- namespace
 */

( function () {
	'use strict';

	/* Detect touch/pointer capability once */
	var isTouch = window.matchMedia( '(hover: none)' ).matches;

	/* ══════════════════════════════════════════════════════════
	   THEME TOGGLE
	   ══════════════════════════════════════════════════════════ */
	function initThemeToggle() {
		var btn = document.getElementById( 'sl-theme-toggle' );
		if ( ! btn ) return;

		btn.addEventListener( 'click', function () {
			var html    = document.documentElement;
			var current = html.getAttribute( 'data-theme' ) || 'light';
			var next    = current === 'light' ? 'dark' : 'light';
			html.setAttribute( 'data-theme', next );
			try { localStorage.setItem( 'scorelens-theme', next ); } catch ( e ) {}
		} );
	}

	/* ══════════════════════════════════════════════════════════
	   MOUSE TRACKING — spotlight + orb parallax
	   Desktop / hover-capable devices only.
	   ══════════════════════════════════════════════════════════ */
	function initMouseTracking() {
		if ( isTouch ) return;

		window.addEventListener( 'mousemove', function ( e ) {
			var pctX = ( e.clientX / window.innerWidth  * 100 ).toFixed( 2 ) + '%';
			var pctY = ( e.clientY / window.innerHeight * 100 ).toFixed( 2 ) + '%';

			/* Spotlight via CSS custom properties on body */
			document.body.style.setProperty( '--sl-mx', pctX );
			document.body.style.setProperty( '--sl-my', pctY );

			/* Parallax orbs */
			document.querySelectorAll( '[data-parallax]' ).forEach( function ( el ) {
				var depth = parseFloat( el.dataset.parallax );
				var dx    = ( e.clientX - window.innerWidth  / 2 ) * depth;
				var dy    = ( e.clientY - window.innerHeight / 2 ) * depth;
				el.style.setProperty( '--sl-px', dx + 'px' );
				el.style.setProperty( '--sl-py', dy + 'px' );
			} );
		}, { passive: true } );

		/* Apply orb parallax via marginLeft/marginTop using rAF */
		function applyOrbParallax() {
			document.querySelectorAll( '[data-parallax]' ).forEach( function ( el ) {
				var px = el.style.getPropertyValue( '--sl-px' ) || '0px';
				var py = el.style.getPropertyValue( '--sl-py' ) || '0px';
				el.style.marginLeft = px;
				el.style.marginTop  = py;
			} );
			requestAnimationFrame( applyOrbParallax );
		}
		applyOrbParallax();
	}

	/* ══════════════════════════════════════════════════════════
	   FEATURE CARD — 3D TILT + RADIAL GLOW
	   ══════════════════════════════════════════════════════════ */
	function initCardTilt() {
		var prefersReduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		document.querySelectorAll( '.sl-feature' ).forEach( function ( card ) {
			card.addEventListener( 'mousemove', function ( e ) {
				var r  = card.getBoundingClientRect();
				var x  = e.clientX - r.left;
				var y  = e.clientY - r.top;

				/* Radial glow origin */
				card.style.setProperty( '--sl-fx', ( x / r.width  * 100 ).toFixed( 1 ) + '%' );
				card.style.setProperty( '--sl-fy', ( y / r.height * 100 ).toFixed( 1 ) + '%' );

				/* 3D tilt */
				if ( ! prefersReduced ) {
					var rotY = ( ( x / r.width  ) - 0.5 ) * 8;
					var rotX = ( ( y / r.height ) - 0.5 ) * -8;
					card.style.transform = 'perspective(900px) rotateX(' + rotX + 'deg) rotateY(' + rotY + 'deg) translateY(-4px)';
				}
			} );

			card.addEventListener( 'mouseleave', function () {
				card.style.transform = '';
			} );
		} );
	}

	/* ══════════════════════════════════════════════════════════
	   MAGNETIC PRIMARY BUTTONS
	   ══════════════════════════════════════════════════════════ */
	function initMagneticButtons() {
		var prefersReduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		document.querySelectorAll( '.sl-btn--primary' ).forEach( function ( btn ) {
			/* Skip disabled buttons */
			if ( btn.getAttribute( 'aria-disabled' ) === 'true' ) return;

			btn.addEventListener( 'mousemove', function ( e ) {
				var r = btn.getBoundingClientRect();
				var x = e.clientX - r.left;
				var y = e.clientY - r.top;
				btn.style.setProperty( '--sl-bx', ( x / r.width  * 100 ) + '%' );
				btn.style.setProperty( '--sl-by', ( y / r.height * 100 ) + '%' );
				if ( ! prefersReduced ) {
					btn.style.transform = 'translate(' + ( ( x - r.width / 2 ) * 0.25 ) + 'px, ' + ( ( y - r.height / 2 ) * 0.4 ) + 'px)';
				}
			} );

			btn.addEventListener( 'mouseleave', function () {
				btn.style.transform = '';
			} );
		} );
	}

	/* ══════════════════════════════════════════════════════════
	   STAT COUNTER — animates numbers on scroll entry
	   Handles comma-formatted values like "10,000"
	   ══════════════════════════════════════════════════════════ */
	function initStatCounters() {
		var statNums = document.querySelectorAll( '.sl-stat-num' );
		if ( ! statNums.length ) return;

		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( ! entry.isIntersecting || entry.target.dataset.counted ) return;
				entry.target.dataset.counted = '1';

				var el       = entry.target;
				var text     = el.textContent;
				var match    = text.match( /([\d,.]+)/ );
				if ( ! match ) return;

				var raw      = match[1].replace( /,/g, '' );
				var target   = parseFloat( raw );
				if ( ! target || isNaN( target ) ) return;

				var isFloat      = raw.indexOf( '.' ) !== -1;
				var finalDisplay = match[0]; /* preserve original e.g. "10,000" */
				var duration     = 1400;
				var start        = performance.now();

				function tick( now ) {
					var t       = Math.min( ( now - start ) / duration, 1 );
					var ease    = 1 - Math.pow( 1 - t, 3 );
					var val     = target * ease;
					var display = isFloat
						? val.toFixed( 1 )
						: Math.round( val ).toLocaleString( 'en-IN' );

					/* Update only the leading text node, preserving <sup> children */
					var node = el.firstChild;
					if ( node && node.nodeType === Node.TEXT_NODE ) {
						node.textContent = display;
					}

					if ( t < 1 ) {
						requestAnimationFrame( tick );
					} else if ( node && node.nodeType === Node.TEXT_NODE ) {
						node.textContent = finalDisplay;
					}
				}
				requestAnimationFrame( tick );
			} );
		}, { threshold: 0.5 } );

		statNums.forEach( function ( n ) { io.observe( n ); } );
	}

	/* ══════════════════════════════════════════════════════════
	   SCROLL REVEAL — class-based, never inline styles
	   Adds .sl-reveal, removes via .sl-reveal--visible
	   ══════════════════════════════════════════════════════════ */
	function initScrollReveal() {
		var els = document.querySelectorAll( '.sl-feature, .sl-plan, .sl-step' );
		if ( ! els.length ) return;

		els.forEach( function ( el ) {
			el.classList.add( 'sl-reveal' );
		} );

		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'sl-reveal--visible' );
					io.unobserve( entry.target );
				}
			} );
		}, { threshold: 0.12 } );

		els.forEach( function ( el ) { io.observe( el ); } );
	}

	/* ══════════════════════════════════════════════════════════
	   AVATAR IMAGE FALLBACK
	   Replaces broken avatar images with initials text from
	   the data-initials attribute — no onerror="" in HTML.
	   ══════════════════════════════════════════════════════════ */
	function initAvatarFallback() {
		document.querySelectorAll( '.sl-testimonial-avatar' ).forEach( function ( wrapper ) {
			var img      = wrapper.querySelector( 'img' );
			var initials = wrapper.dataset.initials || '';
			if ( ! img || ! initials ) return;

			img.addEventListener( 'error', function () {
				wrapper.textContent = initials;
			} );
		} );
	}

	/* ══════════════════════════════════════════════════════════
	   MOBILE NAV HAMBURGER
	   Injected dynamically so it only appears at the
	   breakpoint where the nav links are hidden.
	   ══════════════════════════════════════════════════════════ */
	function initMobileNav() {
		var nav      = document.querySelector( '.sl-nav' );
		var navLinks = document.querySelector( '.sl-nav-links' );
		var navRight = nav ? nav.querySelector( '.sl-nav-right' ) : null;

		if ( ! nav || ! navLinks || ! navRight ) return;

		var hamburger = document.createElement( 'button' );
		hamburger.type      = 'button';
		hamburger.className = 'sl-hamburger';
		hamburger.setAttribute( 'aria-label', 'Toggle navigation' );
		hamburger.setAttribute( 'aria-expanded', 'false' );
		hamburger.setAttribute( 'aria-controls', 'sl-primary-nav' );
		hamburger.innerHTML =
			'<span class="sl-hamburger-bar"></span>' +
			'<span class="sl-hamburger-bar"></span>' +
			'<span class="sl-hamburger-bar"></span>';

		nav.insertBefore( hamburger, navRight );

		hamburger.addEventListener( 'click', function () {
			var open = navLinks.classList.toggle( 'sl-nav-links--open' );
			hamburger.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			hamburger.classList.toggle( 'sl-hamburger--active', open );
		} );

		document.addEventListener( 'click', function ( e ) {
			if ( ! nav.contains( e.target ) ) {
				navLinks.classList.remove( 'sl-nav-links--open' );
				hamburger.setAttribute( 'aria-expanded', 'false' );
				hamburger.classList.remove( 'sl-hamburger--active' );
			}
		} );

		/* Close menu when a nav link is clicked */
		navLinks.addEventListener( 'click', function ( e ) {
			if ( e.target.tagName === 'A' ) {
				navLinks.classList.remove( 'sl-nav-links--open' );
				hamburger.setAttribute( 'aria-expanded', 'false' );
				hamburger.classList.remove( 'sl-hamburger--active' );
			}
		} );
	}

	/* ══════════════════════════════════════════════════════════
	   MODAL — open/close via [data-sl-modal-open] / [data-sl-modal-close]
	   ESC key closes. Body scroll is locked while open.
	   ══════════════════════════════════════════════════════════ */
	function initModal() {
		var openTriggers = document.querySelectorAll( '[data-sl-modal-open]' );
		if ( ! openTriggers.length ) return;

		var lastTrigger = null;

		function openModal( id, trigger ) {
			var modal = document.getElementById( id );
			if ( ! modal ) return;
			lastTrigger = trigger || null;
			modal.classList.add( 'sl-modal--open' );
			modal.setAttribute( 'aria-hidden', 'false' );
			document.body.classList.add( 'sl-modal-locked' );

			var focusable = modal.querySelector(
				'input, textarea, select, button:not([data-sl-modal-close]), a[href]'
			);
			if ( focusable ) {
				focusable.focus();
			} else {
				var closeBtn = modal.querySelector( '.sl-modal-close' );
				if ( closeBtn ) closeBtn.focus();
			}
		}

		function closeModal( modal ) {
			if ( ! modal ) return;
			modal.classList.remove( 'sl-modal--open' );
			modal.setAttribute( 'aria-hidden', 'true' );
			document.body.classList.remove( 'sl-modal-locked' );
			if ( lastTrigger && typeof lastTrigger.focus === 'function' ) {
				lastTrigger.focus();
			}
			lastTrigger = null;
		}

		openTriggers.forEach( function ( trigger ) {
			trigger.addEventListener( 'click', function ( e ) {
				var id = trigger.getAttribute( 'data-sl-modal-open' );
				if ( ! id ) return;
				e.preventDefault();
				openModal( id, trigger );
			} );
		} );

		document.querySelectorAll( '[data-sl-modal-close]' ).forEach( function ( el ) {
			el.addEventListener( 'click', function () {
				closeModal( el.closest( '.sl-modal' ) );
			} );
		} );

		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key !== 'Escape' ) return;
			var openOne = document.querySelector( '.sl-modal.sl-modal--open' );
			if ( openOne ) closeModal( openOne );
		} );
	}

	/* ══════════════════════════════════════════════════════════
	   SCROLL-TO-TOP BUTTON
	   Injects a floating button that appears after the user
	   scrolls past a threshold and smooth-scrolls back to top.
	   ══════════════════════════════════════════════════════════ */
	function initScrollToTop() {
		var btn = document.createElement( 'button' );
		btn.type      = 'button';
		btn.className = 'sl-scroll-top';
		btn.setAttribute( 'aria-label', 'Scroll to top' );
		btn.innerHTML =
			'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' +
				'<path d="M18 15l-6-6-6 6"/>' +
			'</svg>';
		document.body.appendChild( btn );

		btn.addEventListener( 'click', function () {
			window.scrollTo( { top: 0, behavior: 'smooth' } );
		} );

		var threshold = 300;
		function toggle() {
			if ( window.scrollY > threshold ) {
				btn.classList.add( 'sl-scroll-top--visible' );
			} else {
				btn.classList.remove( 'sl-scroll-top--visible' );
			}
		}
		window.addEventListener( 'scroll', toggle, { passive: true } );
		toggle();
	}

	/* ══════════════════════════════════════════════════════════
	   INIT — wait for DOM
	   ══════════════════════════════════════════════════════════ */
	document.addEventListener( 'DOMContentLoaded', function () {
		initThemeToggle();
		initMouseTracking();
		initCardTilt();
		initMagneticButtons();
		initStatCounters();
		initScrollReveal();
		initAvatarFallback();
		initMobileNav();
		initModal();
		initScrollToTop();
	} );

} )();
