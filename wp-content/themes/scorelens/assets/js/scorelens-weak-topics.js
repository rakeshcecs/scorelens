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
		var page = document.querySelector( '.sl-weak-topics-page' );
		if ( ! page ) return;

		/* Subject accordion */
		var subjectCards = page.querySelectorAll( '.subject-card' );

		function closeSubject( card ) {
			card.classList.remove( 'open' );
			var body = card.querySelector( '.subject-body' );
			if ( body ) body.style.maxHeight = '0';
		}

		function openSubject( card ) {
			var body = card.querySelector( '.subject-body' );
			card.classList.add( 'open' );
			if ( body ) body.style.maxHeight = body.scrollHeight + 'px';
		}

		subjectCards.forEach( function ( card ) {
			var header = card.querySelector( '.subject-header' );
			if ( ! header ) return;
			header.addEventListener( 'click', function () {
				var isOpen = card.classList.contains( 'open' );
				subjectCards.forEach( closeSubject );
				if ( ! isOpen ) openSubject( card );
			} );
		} );

		/* Open first subject by default */
		if ( subjectCards.length ) {
			openSubject( subjectCards[0] );
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
			var io = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'visible' );
						io.unobserve( entry.target );
					}
				} );
			}, { threshold: 0.1 } );

			page.querySelectorAll( '.reveal' ).forEach( function ( el, i ) {
				el.style.transitionDelay = ( i % 3 * 60 ) + 'ms';
				io.observe( el );
			} );
		} else {
			page.querySelectorAll( '.reveal' ).forEach( function ( el ) {
				el.classList.add( 'visible' );
			} );
		}

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
