import { addFilter } from '@wordpress/hooks';

const slideAllowedBlocks = [
	'acf/customer-story-slide',
	'acf/testimonial-card',
];

addFilter(
	'vital_swiper_slide_allowed_blocks',
	'channelPartners.vitalSwiper.slideAllowedBlocks',
	(allowedBlocks) => [...allowedBlocks, ...slideAllowedBlocks]
);
