import SimpleLightbox from 'simplelightbox';

import '../scss/main.scss';

// lightbox for feed.
const lightGalleryInit = () => {
	const feedContainers = document.querySelectorAll(
		'.instagram-feeds-container'
	);

	feedContainers.forEach( ( item ) => {
		let lightboxClass = '#' + item.id + ' .row a';
		new SimpleLightbox( lightboxClass, {
			fileExt: false,
		} );
	} );
};

lightGalleryInit();
