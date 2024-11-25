<?php

use Vital\VitalMustache;

// Render mustache template
if (class_exists('Vital\VitalMustache')) {
	$footer_markup = VitalMustache::render('template/footer-landing', $args, true);
	$html = apply_filters('footer_landing_markup', $footer_markup);
	echo $html;
}
