jQuery(document).ready(($) => {
	// got this information from the localize_script function in the enqueue_scripts file
	const homeUrl = window.cwssData.homeUrl;
	const currentUrl = window.cwssData.currentUrl;
	const iconSize = window.cwssData.iconSize;
	let iconSvg = window.cwssData.iconSVG;
	const iconText = window.cwssData.iconText;
	const element = window.cwssData.element.replace(/[<>]/g, "");

	// console.log("element", element);
	// console.log("iconSvg", iconSvg);

	const hash = window.location.hash;

	const iconSvg1 =
		'<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100 100"><path fill="#000" d="M35.47,31.63l7.44,7.05,22.91-24.18,18.77,17.78-22.91,24.18,7.44,7.05,29.97-31.63L65.44,0l-29.97,31.63ZM34.56,100l29.97-31.63-7.44-7.05-22.91,24.18-18.77-17.78,22.91-24.18-7.44-7.05L.9,68.11l33.65,31.89Z"/><rect class="cls-1" x="24.74" y="44.87" width="50.51" height="10.26" transform="translate(-20.69 51.9) rotate(-46.54)"/></svg>';

	const iconSvg4 =
		'<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100 100"><path fill="#000" d="M73.15,51.66c-.55-.93-1.18-1.8-1.87-2.59-.22-.26-.45-.5-.68-.74l-6.48-6.6-1.61-1.64c-3.18-3.24-7.44-5.03-12-5.03s-8.62,1.71-11.78,4.81l-2.48,2.43c.19.4.41.77.68,1.11.14.18.28.33.41.46l4.88,4.97,2.71-2.66c1.49-1.47,3.48-2.27,5.58-2.27s4.18.85,5.69,2.38l1.61,1.64,6.48,6.6c.18.18.37.4.56.64.57.72,1.01,1.54,1.32,2.44.08.24.15.48.2.72.62,2.7-.19,5.51-2.18,7.46l-23.51,23.08c-1.49,1.47-3.48,2.27-5.58,2.28-2.16,0-4.18-.85-5.69-2.38l-8.09-8.24c-3.08-3.13-3.03-8.19.1-11.27l11.23-11.03-4.88-4.97c-.27-.27-.52-.55-.78-.84-.16-.19-.32-.37-.48-.57l-11.3,11.09c-6.62,6.5-6.72,17.17-.22,23.78l8.09,8.24c3.18,3.24,7.44,5.03,12,5.03h0c4.44,0,8.62-1.71,11.78-4.81l23.51-23.08c5.48-5.38,6.62-13.78,2.77-20.44,0,0,0,0,0-.01Z"/><path d="M85,13.27l-8.09-8.24c-3.18-3.24-7.45-5.03-12-5.03s-8.62,1.71-11.78,4.81l-23.51,23.08c-5.48,5.38-6.62,13.78-2.77,20.44,0,0,0,0,0,.01.55.93,1.18,1.8,1.86,2.59.22.26.45.5.68.74l6.48,6.6,1.61,1.64c3.18,3.24,7.44,5.03,12,5.03h0c4.44,0,8.62-1.71,11.78-4.81l2.48-2.43c-.19-.4-.41-.77-.68-1.11-.14-.18-.28-.33-.41-.46l-4.88-4.97-2.71,2.66c-1.5,1.47-3.48,2.27-5.58,2.27s-4.18-.85-5.69-2.38l-1.61-1.64-6.48-6.6c-.18-.19-.37-.4-.56-.64-.57-.72-1.01-1.54-1.32-2.44-.08-.24-.15-.48-.2-.72-.62-2.7.19-5.51,2.18-7.46l23.51-23.08c1.49-1.47,3.48-2.28,5.58-2.28s4.18.85,5.69,2.38l8.09,8.24c3.08,3.13,3.03,8.19-.1,11.27l-11.23,11.03,4.88,4.97c.27.27.52.55.78.84.16.19.32.37.48.57l11.3-11.09c3.2-3.14,4.99-7.35,5.03-11.85.04-4.5-1.66-8.74-4.81-11.94Z"/></svg>';

	const iconSvg8 =
		'<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100 100"><path fill="#000" d="M55.73,74.63c-1.25-.04-2.5-.16-3.73-.34-.35-.05-.7-.11-1.05-.18l-10.34,10.74c-6.96,7.23-18.24,7.88-25.17,1.29-6.96-6.62-6.94-17.95.05-25.2l10.48-10.88,3.49-3.63c.54-.56,1.1-1.07,1.68-1.55,2.77-2.26,6.02-3.62,9.34-4.05.86-.11,1.73-.16,2.6-.15.8.01,1.59.08,2.38.2h0c3.34.51,6.53,1.99,9.1,4.47,2.34,2.25,3.88,5.04,4.62,8.02,2.21-.35,4.29-1.28,6.05-2.72.41-.33.8-.69,1.17-1.08l1.15-1.2c-1.28-3.67-3.4-7.07-6.35-9.92-2.95-2.84-6.43-4.83-10.15-5.97-1.25-.38-2.53-.67-3.83-.87-1.01-.15-2.03-.24-3.06-.28-3.84-.13-7.74.56-11.41,2.05-.51.21-1.02.43-1.52.67-.56.26-1.1.55-1.64.85-2.41,1.35-4.68,3.08-6.71,5.19l-13.97,14.51c-10.62,11.03-10.7,28.24-.17,38.36,10.49,10.08,27.89,9.17,38.47-1.82l13.8-14.34c.87-.9,1.66-1.84,2.39-2.82-2.54.51-5.12.72-7.68.64Z"/><path d="M53.06,8.77l-13.97,14.51c-.87.9-1.66,1.84-2.39,2.82,2.54-.51,5.12-.72,7.68-.64,1.23.04,2.48.15,3.72.34.35.05.71.11,1.06.18l10.48-10.88c6.98-7.25,18.3-7.71,25.18-1,6.85,6.68,6.63,17.97-.34,25.2l-10.34,10.74-3.49,3.63c-.54.56-1.1,1.07-1.68,1.55-2.77,2.26-6.02,3.62-9.34,4.05-.86.11-1.73.16-2.6.15-.8-.01-1.59-.08-2.38-.2-3.34-.51-6.53-1.99-9.11-4.47-2.34-2.25-3.88-5.04-4.62-8.02-2.21.34-4.29,1.28-6.05,2.72-.41.33-.8.69-1.17,1.08l-1.15,1.2c1.28,3.67,3.4,7.07,6.35,9.92,2.95,2.85,6.44,4.83,10.15,5.97,1.25.38,2.53.67,3.83.87,1.01.15,2.03.24,3.05.28,3.84.13,7.74-.56,11.41-2.05.51-.21,1.02-.43,1.52-.67.55-.26,1.1-.55,1.64-.85,2.41-1.35,4.68-3.08,6.71-5.19l13.8-14.34c10.58-10.99,10.84-28.41.36-38.51-10.51-10.13-27.71-9.4-38.33,1.62Z"/></svg>';

	if (!iconSvg) {
		iconSvg = iconSvg1;
	} else {
		if ("option1" === iconSvg) {
			iconSvg = iconSvg1;
		} else if (iconSvg === "option2") {
			iconSvg = iconSvg4;
		} else if (iconSvg === "option3") {
			iconSvg = iconSvg8;
		}
	}

	// find every <h3> element within the page
	const headings = document.querySelectorAll(element);

	headings.forEach((heading, i) => {
		let slug = heading.getAttribute("id");

		heading.classList.add("cwss-h3");

		if (!slug) {
			// innerText não pega textos ocultos por CSS, é o que o usuário vê no browser
			// já o textContent pega todos os textos, inclusive os ocultos
			const title = heading.innerText;
			slug = slugify(title);

			heading.setAttribute("id", slug);
		}

		// text to be copied is the URL with the string added after it
		const copyText = `${currentUrl}#${slug}`;
		// console.log( 'copyText', copyText );

		// create a wrapper for the <h3> content
		// $(this).wrapInner( '<div class="cwss-h3-wrapper"></div>');
		const wrapper = document.createElement("div");
		wrapper.classList.add("cwss-h3-wrapper");
		wrapper.innerHTML = heading.innerHTML;

		heading.innerHTML = "";
		heading.appendChild(wrapper);

		// create the copy URL button within the <h3> heading
		const button = document.createElement("button");
		button.classList.add("cwss-h3-link-icon");
		button.innerHTML = iconSvg;
		wrapper.append(button);

		// set the width of the button to the height of the <h3> container
		const h3Wrapper = heading.querySelector(".cwss-h3-wrapper");
		const h3ContainerHeight = h3Wrapper.offsetHeight;

		// button.style.width = `${h3ContainerHeight * iconSize}px`;
		// button.style.height = `${h3ContainerHeight * iconSize}px`;

		// console.log(
		// 	"headings.style.fontSize",
		// 	window.getComputedStyle(headings[0], null).getPropertyValue("font-size"),
		// );
		const headingsWidth = window
			.getComputedStyle(wrapper, null)
			.getPropertyValue("font-size");

		const headingsWidthNumber = Number(headingsWidth.replace("px", ""));

		button.style.width = `${headingsWidthNumber * iconSize}px`;
		button.style.height = `${headingsWidthNumber * iconSize}px`;

		// h3Wrapper.style.paddingRight = `${h3ContainerHeight * iconSize + 10}px`;
		h3Wrapper.style.paddingRight = `${headingsWidthNumber * iconSize + 10}px`;

		// when the button is clicked, copy the URL to the clipboard
		button.addEventListener("click", function () {
			navigator.clipboard.writeText(copyText);

			// Cria um novo elemento para mostrar a mensagem
			const messageElement = document.createElement("span");
			messageElement.classList.add("cwss-message-balloon");
			messageElement.textContent = iconText;

			// Adiciona estilos ao elemento
			const rect = this.getBoundingClientRect();
			messageElement.style.left = `${rect.left + this.offsetWidth / 2}px`;
			messageElement.style.top = `${rect.bottom + 40}px`;

			// Adiciona o elemento ao corpo do documento
			document.body.appendChild(messageElement);

			// Aplica a animação de fade out após 2 segundos
			setTimeout(() => {
				messageElement.style.animation = "fadeOut 0.5s ease-out forwards";

				// 	Remove o elemento após a animação de fade out
				setTimeout(() => {
					document.body.removeChild(messageElement);
				}, 500);
				// Corresponde à duração da animação de fade out
			}, 800);
			// Ajuste este valor conforme necessário
		});
	});

	// if there is a hash in the URL, find the element and scroll to it
	if (hash) {
		const element = document.getElementById(hash.substring(1));
		// console.log('element', element);
		if (element) {
			const pt = window
				.getComputedStyle(element)
				.getPropertyValue("padding-top");

			// check if the element has padding-top
			if (0 === pt) {
				element.scrollIntoView();
			} else {
				const offset = element.offsetTop;
				// console.log( 'offset', offset );
				const scroll = offset - 32;
				// console.log( 'scroll', scroll );

				$("html, body").animate(
					{
						scrollTop: scroll,
					},
					200,
				);
			}
		}
	}

	function slugify($stringToSlugify) {
		$title_slugfied = $stringToSlugify.toLowerCase();

		const from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
		const to = "aaaaaeeeeeiiiiooooouuuunc------";
		for (let i = 0, l = from.length; i < l; i++) {
			$title_slugfied = $title_slugfied.replace(
				new RegExp(from.charAt(i), "g"),
				to.charAt(i),
			);
		}

		$title_slugfied = $title_slugfied
			.replace(/[^a-z0-9 -]/g, "") // remove invalid chars
			.replace(/\s+/g, "-") // collapse whitespace and replace by -
			.replace(/-+/g, "-"); // collapse dashes

		if (document.getElementById($title_slugfied)) {
			console.warn(`SnapSection: duplicated ID "${$title_slugfied}"`);
		}
		return $title_slugfied;
	}
});
