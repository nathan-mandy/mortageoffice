<?php

use Vital\VitalMustache;


$args = [
	'page_link' => site_url(),
	'home_link' => home_link(get_field('landing_page_logo', 'options')),
];

$copyright = get_option('options_copyright_text');
if ($copyright) {
	$args['copyright_text'] = str_replace('{year}', gmdate('Y'), $copyright);
}

// Render mustache template
if (class_exists('Vital\VitalMustache')) {
	$footer_markup = VitalMustache::render('template/footer-landing', $args, true);
	$html = apply_filters('footer_landing_markup', $footer_markup);
	echo $html;
}