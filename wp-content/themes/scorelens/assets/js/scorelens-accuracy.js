(function () {
	'use strict';

	function ready( fn ) {
		if ( document.readyState !== 'loading' ) {
			fn();
			return;
		}
		document.addEventListener( 'DOMContentLoaded', fn );
	}

	ready( function () {
		var page = document.querySelector( '.sl-accuracy-page' );
		if ( ! page ) return;

		/* Animated hero gauge counter — 68% → 87% on scroll-into-view */
		var counter = page.querySelector( '#gauge-counter' );
		if ( counter && 'IntersectionObserver' in window ) {
			var counterIO = new IntersectionObserver( function ( entries ) {
				if ( ! entries[0].isIntersecting ) return;
				counterIO.disconnect();
				var start = 68, end = 87, dur = 1800, startTime = null;
				function tick( ts ) {
					if ( ! startTime ) startTime = ts;
					var p = Math.min( ( ts - startTime ) / dur, 1 );
					var ease = 1 - Math.pow( 1 - p, 3 );
					counter.textContent = Math.round( start + ( end - start ) * ease ) + '%';
					if ( p < 1 ) requestAnimationFrame( tick );
				}
				requestAnimationFrame( tick );
			}, { threshold: 0.5 } );
			counterIO.observe( counter );
		}

		/* Build sparkline bars */
		var sparkWrap = page.querySelector( '#sparkline' );
		if ( sparkWrap ) {
			var sparkData = [
				{ m: 'M1', v: 68 }, { m: 'M2', v: 71 }, { m: 'M3', v: 74 }, { m: 'M4', v: 76 },
				{ m: 'M5', v: 79 }, { m: 'M6', v: 81 }, { m: 'M7', v: 85 }, { m: 'M8', v: 87 }
			];
			var sparkMax = 87, sparkMin = 60;
			sparkData.forEach( function ( d, i ) {
				var pct = ( d.v - sparkMin ) / ( sparkMax - sparkMin ) * 100;
				var hue = d.v < 73 ? '#ff7a52' : d.v < 80 ? '#f4b942' : '#10b981';
				var bar = document.createElement( 'div' );
				bar.className = 'spark-bar';
				bar.style.height = pct + '%';
				bar.style.background = hue;
				bar.style.animationDelay = ( i * 0.12 ) + 's';

				var label = document.createElement( 'span' );
				label.className = 'spark-bar-label';
				label.textContent = d.m;

				var val = document.createElement( 'span' );
				val.className = 'spark-bar-val';
				val.style.color = hue;
				val.textContent = d.v + '%';

				bar.appendChild( label );
				bar.appendChild( val );
				sparkWrap.appendChild( bar );
			} );
		}

		/* FAQ accordion */
		page.querySelectorAll( '.faq-trigger' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var item = btn.closest( '.faq-item' );
				var body = item ? item.querySelector( '.faq-body' ) : null;
				if ( ! item || ! body ) return;

				var isOpen = item.classList.contains( 'open' );
				page.querySelectorAll( '.faq-item.open' ).forEach( function ( openItem ) {
					openItem.classList.remove( 'open' );
					var openBody = openItem.querySelector( '.faq-body' );
					var openBtn = openItem.querySelector( '.faq-trigger' );
					if ( openBody ) openBody.style.maxHeight = '0';
					if ( openBtn ) openBtn.setAttribute( 'aria-expanded', 'false' );
				} );

				if ( ! isOpen ) {
					item.classList.add( 'open' );
					body.style.maxHeight = body.scrollHeight + 'px';
					btn.setAttribute( 'aria-expanded', 'true' );
				}
			} );
		} );

		/* Scroll reveal */
		if ( 'IntersectionObserver' in window ) {
			var revealIO = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'visible' );
						revealIO.unobserve( entry.target );
					}
				} );
			}, { threshold: 0.1 } );

			page.querySelectorAll( '.reveal' ).forEach( function ( el, i ) {
				el.style.transitionDelay = ( i % 3 * 60 ) + 'ms';
				revealIO.observe( el );
			} );
		} else {
			page.querySelectorAll( '.reveal' ).forEach( function ( el ) {
				el.classList.add( 'visible' );
			} );
		}

		/* Reason card mouse-tracked glow */
		page.querySelectorAll( '.reason-card' ).forEach( function ( card ) {
			card.addEventListener( 'mousemove', function ( e ) {
				var r = card.getBoundingClientRect();
				card.style.setProperty( '--fx', ( ( e.clientX - r.left ) / r.width * 100 ).toFixed( 1 ) + '%' );
				card.style.setProperty( '--fy', ( ( e.clientY - r.top ) / r.height * 100 ).toFixed( 1 ) + '%' );
			} );
		} );

		/* Magnetic buttons */
		page.querySelectorAll( '.btn-primary' ).forEach( function ( btn ) {
			btn.addEventListener( 'mousemove', function ( e ) {
				var r = btn.getBoundingClientRect();
				btn.style.setProperty( '--bx', ( ( e.clientX - r.left ) / r.width * 100 ) + '%' );
				btn.style.setProperty( '--by', ( ( e.clientY - r.top ) / r.height * 100 ) + '%' );
			} );
		} );
	} );
} )();
