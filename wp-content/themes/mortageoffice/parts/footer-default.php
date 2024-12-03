<?php

use Vital\VitalMustache;

// Fetch Main Menu
if (has_nav_menu('footer_nav')) {
	$args['footer_menu'] = wp_nav_menu([
		'theme_location'  => 'footer_nav',
		'container'       => 'div',
		'container_class' => 'footer-menu-wrapper',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'menu_class'      => 'menu footer-menu group',
		'menu_id'         => 'footer-menu',
		'depth'           => 0,
		'echo'            => 0,
	]);
}

// Fetch the Terms Menu
if (has_nav_menu('footer_terms')) {
	$args['footer_terms'] = wp_nav_menu([
		'theme_location'  => 'footer_terms',
		'container'       => 'div',
		'container_class' => 'footer-terms-wrapper',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'menu_class'      => 'menu footer-terms group',
		'menu_id'         => 'footer-terms',
		'depth'           => 0,
		'echo'            => 0,
	]);
}

$copyright = get_option('options_copyright_text');
if ($copyright) {
	$args['copyright_text'] = str_replace('{year}', gmdate('Y'), $copyright);
}


$social_media = \get_option('options_social_links');

if ($social_media) {
	$socials = \get_the_content(false, null, $social_media);

	$parsed_social_links_blocks = parse_blocks($socials);

	$social_links = array_map(function ($block) {
		return apply_filters('the_content', render_block($block));
	}, $parsed_social_links_blocks);
	$args['social_links'] = implode('', $social_links);
}

// Render mustache template
if (class_exists('Vital\VitalMustache')) {
	VitalMustache::render('template/footer-default', $args);
}
