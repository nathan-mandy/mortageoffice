<?php

use Vital\VitalMustache;

$args = [
	'home_link' => home_link(),
];

// Render mustache template
if (class_exists('Vital\VitalMustache')) {
	$header_markup = VitalMustache::render('template/header-landing', $args, true);
	$html = apply_filters('header_landing_markup', $header_markup);
	echo $html;
}
