jQuery(document).ready(function ($) {
	// got this information from the localize_script function in the enqueue_scripts file
	let homeUrl = window.cwssData.homeUrl;
	let currentUrl = window.cwssData.currentUrl;
	let iconSize = window.cwssData.iconSize;
	let iconSvg = window.cwssData.iconSVG;
	// console.log('iconSvg', iconSvg);
	// let iconColor = window.cwssData.iconColor;

	var hash = window.location.hash;

	// '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="auto" height="85%" viewBox="0 0 100 100"><path fill="#000" d="M904.829 252.63l-147.363 255.233c-23.283 40.251-74.734 54.061-115.028 30.778l-36.42-21.052 42.104-72.882c20.126 11.579 45.893 4.716 57.472-15.41l105.26-182.309c11.621-20.168 4.716-45.893-15.368-57.514l-145.89-84.208c-20.168-11.621-45.893-4.716-57.472 15.41l-105.26 182.309c-11.663 20.168-4.758 45.893 15.368 57.514l-42.104 72.882-36.42-21.052c-40.293-23.241-54.103-74.734-30.82-114.985l147.363-255.233c23.283-40.293 74.734-54.061 115.028-30.82l218.729 126.311c40.293 23.241 54.103 74.734 30.82 115.028zM406.74 694.298c-20.168-11.621-27.073-37.388-15.41-57.514l168.415-291.695c11.621-20.168 37.388-27.073 57.514-15.41s27.073 37.388 15.368 57.514l-168.415 291.695c-11.579 20.126-37.304 26.989-57.472 15.41zM375.92 579.313v0c-20.168-11.621-45.893-4.716-57.514 15.368l-105.26 182.309c-11.621 20.168-4.716 45.893 15.41 57.514l145.89 84.208c20.126 11.621 45.893 4.716 57.472-15.41l105.26-182.309c11.621-20.126 4.716-45.893-15.368-57.514v0l42.104-72.882 36.42 21.052c40.293 23.241 54.103 74.692 30.82 114.985l-147.363 255.233c-23.283 40.293-74.734 54.061-115.028 30.82l-218.771-126.311c-40.293-23.283-54.103-74.734-30.82-115.028l147.363-255.233c23.283-40.293 74.776-54.103 115.070-30.82l36.42 21.052-42.104 72.966z"></path></svg>';


	let iconSvg1 = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="auto" height="85%" viewBox="0 0 100 100"><path fill="#000" d="M35.47,31.63l7.44,7.05,22.91-24.18,18.77,17.78-22.91,24.18,7.44,7.05,29.97-31.63L65.44,0l-29.97,31.63ZM34.56,100l29.97-31.63-7.44-7.05-22.91,24.18-18.77-17.78,22.91-24.18-7.44-7.05L.9,68.11l33.65,31.89Z"/><rect class="cls-1" x="24.74" y="44.87" width="50.51" height="10.26" transform="translate(-20.69 51.9) rotate(-46.54)"/></svg>';

	let iconSvg4 = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="auto" height="85%" viewBox="0 0 100 100"><path fill="#000" d="M73.15,51.66c-.55-.93-1.18-1.8-1.87-2.59-.22-.26-.45-.5-.68-.74l-6.48-6.6-1.61-1.64c-3.18-3.24-7.44-5.03-12-5.03s-8.62,1.71-11.78,4.81l-2.48,2.43c.19.4.41.77.68,1.11.14.18.28.33.41.46l4.88,4.97,2.71-2.66c1.49-1.47,3.48-2.27,5.58-2.27s4.18.85,5.69,2.38l1.61,1.64,6.48,6.6c.18.18.37.4.56.64.57.72,1.01,1.54,1.32,2.44.08.24.15.48.2.72.62,2.7-.19,5.51-2.18,7.46l-23.51,23.08c-1.49,1.47-3.48,2.27-5.58,2.28-2.16,0-4.18-.85-5.69-2.38l-8.09-8.24c-3.08-3.13-3.03-8.19.1-11.27l11.23-11.03-4.88-4.97c-.27-.27-.52-.55-.78-.84-.16-.19-.32-.37-.48-.57l-11.3,11.09c-6.62,6.5-6.72,17.17-.22,23.78l8.09,8.24c3.18,3.24,7.44,5.03,12,5.03h0c4.44,0,8.62-1.71,11.78-4.81l23.51-23.08c5.48-5.38,6.62-13.78,2.77-20.44,0,0,0,0,0-.01Z"/><path d="M85,13.27l-8.09-8.24c-3.18-3.24-7.45-5.03-12-5.03s-8.62,1.71-11.78,4.81l-23.51,23.08c-5.48,5.38-6.62,13.78-2.77,20.44,0,0,0,0,0,.01.55.93,1.18,1.8,1.86,2.59.22.26.45.5.68.74l6.48,6.6,1.61,1.64c3.18,3.24,7.44,5.03,12,5.03h0c4.44,0,8.62-1.71,11.78-4.81l2.48-2.43c-.19-.4-.41-.77-.68-1.11-.14-.18-.28-.33-.41-.46l-4.88-4.97-2.71,2.66c-1.5,1.47-3.48,2.27-5.58,2.27s-4.18-.85-5.69-2.38l-1.61-1.64-6.48-6.6c-.18-.19-.37-.4-.56-.64-.57-.72-1.01-1.54-1.32-2.44-.08-.24-.15-.48-.2-.72-.62-2.7.19-5.51,2.18-7.46l23.51-23.08c1.49-1.47,3.48-2.28,5.58-2.28s4.18.85,5.69,2.38l8.09,8.24c3.08,3.13,3.03,8.19-.1,11.27l-11.23,11.03,4.88,4.97c.27.27.52.55.78.84.16.19.32.37.48.57l11.3-11.09c3.2-3.14,4.99-7.35,5.03-11.85.04-4.5-1.66-8.74-4.81-11.94Z"/></svg>';

	let iconSvg8 = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="auto" height="85%" viewBox="0 0 100 100"><path fill="#000" d="M55.73,74.63c-1.25-.04-2.5-.16-3.73-.34-.35-.05-.7-.11-1.05-.18l-10.34,10.74c-6.96,7.23-18.24,7.88-25.17,1.29-6.96-6.62-6.94-17.95.05-25.2l10.48-10.88,3.49-3.63c.54-.56,1.1-1.07,1.68-1.55,2.77-2.26,6.02-3.62,9.34-4.05.86-.11,1.73-.16,2.6-.15.8.01,1.59.08,2.38.2h0c3.34.51,6.53,1.99,9.1,4.47,2.34,2.25,3.88,5.04,4.62,8.02,2.21-.35,4.29-1.28,6.05-2.72.41-.33.8-.69,1.17-1.08l1.15-1.2c-1.28-3.67-3.4-7.07-6.35-9.92-2.95-2.84-6.43-4.83-10.15-5.97-1.25-.38-2.53-.67-3.83-.87-1.01-.15-2.03-.24-3.06-.28-3.84-.13-7.74.56-11.41,2.05-.51.21-1.02.43-1.52.67-.56.26-1.1.55-1.64.85-2.41,1.35-4.68,3.08-6.71,5.19l-13.97,14.51c-10.62,11.03-10.7,28.24-.17,38.36,10.49,10.08,27.89,9.17,38.47-1.82l13.8-14.34c.87-.9,1.66-1.84,2.39-2.82-2.54.51-5.12.72-7.68.64Z"/><path d="M53.06,8.77l-13.97,14.51c-.87.9-1.66,1.84-2.39,2.82,2.54-.51,5.12-.72,7.68-.64,1.23.04,2.48.15,3.72.34.35.05.71.11,1.06.18l10.48-10.88c6.98-7.25,18.3-7.71,25.18-1,6.85,6.68,6.63,17.97-.34,25.2l-10.34,10.74-3.49,3.63c-.54.56-1.1,1.07-1.68,1.55-2.77,2.26-6.02,3.62-9.34,4.05-.86.11-1.73.16-2.6.15-.8-.01-1.59-.08-2.38-.2-3.34-.51-6.53-1.99-9.11-4.47-2.34-2.25-3.88-5.04-4.62-8.02-2.21.34-4.29,1.28-6.05,2.72-.41.33-.8.69-1.17,1.08l-1.15,1.2c1.28,3.67,3.4,7.07,6.35,9.92,2.95,2.85,6.44,4.83,10.15,5.97,1.25.38,2.53.67,3.83.87,1.01.15,2.03.24,3.05.28,3.84.13,7.74-.56,11.41-2.05.51-.21,1.02-.43,1.52-.67.55-.26,1.1-.55,1.64-.85,2.41-1.35,4.68-3.08,6.71-5.19l13.8-14.34c10.58-10.99,10.84-28.41.36-38.51-10.51-10.13-27.71-9.4-38.33,1.62Z"/></svg>';


	if( !iconSvg ) {
		let iconSvg = iconSvg1;
	} else {
		if( iconSvg == 'option1' ) {
			iconSvg = iconSvg1;
		} else if( iconSvg == 'option2' ) {
			iconSvg = iconSvg4;
		} else if( iconSvg == 'option3' ) {
			iconSvg = iconSvg8;
		}
		console.log('iconSvg', iconSvg);
	}

	// find every <h3> element within the page
	// $headings = $( 'body' ).find( 'h3' );
	let headings = document.querySelectorAll('h3');
	// console.log( 'headings', headings );

	// $headings.each(function(i) {
	headings.forEach(function (heading, i) {
		// console.log('heading', heading);
		// console.log('i', i);
		// check if <h3> already has an ID.
		// if doesn't, create one from its content
		// remember that var or let declares a variable
		// let $slug = $(this).attr( 'id' );
		let slug = heading.getAttribute('id');

		// $(this).addClass( 'cwss-h3');
		heading.classList.add('cwss-h3');

		if (!slug) {
			// let $title = $(this).text();
			// innerText não pega textos ocultos por CSS, é o que o usuário vê no browser
			// já o textContent pega todos os textos, inclusive os ocultos
			let title = heading.innerText;
			slug = slugify(title);

			// $(this).attr( 'id', $slug );
			heading.setAttribute('id', slug);
		}

		// text to be copied is the URL with the string added after it
		// let $copyText = currentUrl + '#' + $slug;
		let copyText = currentUrl + '#' + slug;
		// console.log( 'copyText', copyText );

		// create a wrapper for the <h3> content
		// $(this).wrapInner( '<div class="cwss-h3-wrapper"></div>');
		let wrapper = document.createElement('div');
		wrapper.classList.add('cwss-h3-wrapper');

		wrapper.innerHTML = heading.innerHTML;
		heading.innerHTML = '';

		heading.appendChild(wrapper);

		// create the copy URL button within the <h3> heading
		// $(this).find('.cwss-h3-wrapper').append( `<button class="cwss-h3-link-icon">${iconSvg}</button>` );
		let button = document.createElement('button');
		button.classList.add('cwss-h3-link-icon');
		button.innerHTML = iconSvg;
		wrapper.append(button);

		// set the width of the button to the height of the <h3> container
		let h3ContainerHeight =
			heading.querySelector('.cwss-h3-wrapper').offsetHeight;
		// console.log('h3ContainerHeight', h3ContainerHeight);

		button.style.width = h3ContainerHeight * iconSize;

		// when the button is clicked, copy the URL to the clipboard
		button.addEventListener('click', function () {
			navigator.clipboard.writeText(copyText);
			console.log('Copied: ' + copyText);
		});
	});

	// if there is a hash in the URL, find the element and scroll to it
	if (hash) {
		let element = document.getElementById(hash.substring(1));
		console.log('element', element);
		if (element) {
			let pt = window
				.getComputedStyle(element)
				.getPropertyValue('padding-top');
			console.log('pt', pt);

			// check if the element has padding-top
			if (pt == 0) {
				element.scrollIntoView();
			} else {
				let offset = element.offsetTop;
				// console.log( 'offset', offset );
				let scroll = offset - 32;
				// console.log( 'scroll', scroll );
				$('html, body').animate(
					{
						scrollTop: scroll,
					},
					300
				);
			}
		}
	}

	function slugify($stringToSlugify) {
		$title_slugfied = $stringToSlugify.toLowerCase();

		const from = 'ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;';
		const to = 'aaaaaeeeeeiiiiooooouuuunc------';
		for (let i = 0, l = from.length; i < l; i++) {
			$title_slugfied = $title_slugfied.replace(
				new RegExp(from.charAt(i), 'g'),
				to.charAt(i)
			);
		}

		$title_slugfied = $title_slugfied
			.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
			.replace(/\s+/g, '-') // collapse whitespace and replace by -
			.replace(/-+/g, '-'); // collapse dashes

		return $title_slugfied;
	}
});
