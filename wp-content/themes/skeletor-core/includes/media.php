<?php

/**
 * Media library functions
 */

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 */
function vital_content_width() {

	$content_width = 800;

	$GLOBALS['content_width'] = apply_filters('vital_content_width', $content_width);
}

add_action('after_setup_theme', 'vital_content_width', 0);

/**
 * Adds custom image sizes
 */
// add_image_size('maximum_size', 1000, 1000, true);

/**
 * Adds formatted names to media sizes
 */
function vital_image_size_names_choose($sizes) {
	$custom_sizes = array(
		'maximum_size' => 'Maximum Size',
	);
	$all_sizes = array_merge($sizes, $custom_sizes);
	return $all_sizes;
}
// add_filter('image_size_names_choose', 'vital_image_size_names_choose');
