<?php

/**
 * Landing Page functions
 */

/**
 * Checks if a landing page was requested based on set criteria
 * @return boolean
 */
function is_indium_landing_page() {

	switch (true) {
		case is_singular('resource') && get_field('gated_resource') == 1 && !get_query_var( 'thankyou'):
			$return_value = true;
			break;

		default:
			$return_value = false;
			break;
	}

	return apply_filters('skeletor_is_landing_page', $return_value);
}

/**
 * Adds body class to all landing pages
 */
add_filter('body_class', function($classes) {
    // Check if query var 'thankyou' is set
    if (get_query_var('thankyou')) {
        $classes[] = 'is-thank-you';
        return $classes; // Prevents adding other classes
    }

    if (is_indium_landing_page()) {
        $classes[] = 'landing-page';
    }

    if (is_singular('resource')) {
        if (get_field('gated_resource') == 1) {
            $classes[] = 'is-gated-resource';
        } elseif (get_field('gated_resource') == 0) {
            $classes[] = 'is-un-gated-resource';
        }
    }

    return $classes;
});

