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
		var page = document.querySelector( '.sl-time-mgmt-page' );
		if ( ! page ) return;

		/* Countdown clock — 60:00 looping every minute */
		var mm = page.querySelector( '#clock-mm' );
		var ss = page.querySelector( '#clock-ss' );
		if ( mm && ss ) {
			var total = 60 * 60;
			function tick() {
				if ( total <= 0 ) total = 60 * 60;
				var m = Math.floor( total / 60 );
				var s = total % 60;
				mm.textContent = String( m ).padStart( 2, '0' );
				ss.textContent = String( s ).padStart( 2, '0' );
				total--;
				setTimeout( tick, 1000 );
			}
			tick();
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

		/* Step card mouse-tracked glow */
		page.querySelectorAll( '.step-card' ).forEach( function ( card ) {
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
