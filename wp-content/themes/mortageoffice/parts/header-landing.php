<?php

use Vital\VitalMustache;

$args = [
	'page_link' => site_url(),
	'home_link' => home_link(get_field('landing_page_logo', 'options')),
];

// Render mustache template
if (class_exists('Vital\VitalMustache')) {
	$header_markup = VitalMustache::render('template/header-landing', $args, true);
	$html = apply_filters('header_landing_markup', $header_markup);
	echo $html;
}
