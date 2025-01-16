const SELECTOR = '.header-search';

function onDocumentReady() {
	const els = document.querySelectorAll(SELECTOR);

	if (!els) {
		return;
	}

	const windowWidth = window.innerWidth;

	if (windowWidth > 1200) {
		els.forEach(e => initListener(e));
    }
}

function initListener(el) {
	const input = el.querySelector('.search-field');

	input.addEventListener('focus', (e) => {
		activateSearch(e, el);
	});

	input.addEventListener('focusout', (e) => {
		deactivateSearch(e, el);
	});
}

function activateSearch(e, el) {
	el.classList.add('activated');
}

function deactivateSearch(e, el) {
	el.classList.remove('activated');
}

document.addEventListener('DOMContentLoaded', onDocumentReady);
