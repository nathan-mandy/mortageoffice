<!DOCTYPE html>
<html <?php language_attributes(); ?> >

<head>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	
	<?php
	if (is_indium_landing_page()) {
		get_template_part('parts/header-landing', null, $args);
	} else {
		get_template_part('parts/header-default', null, $args);
	}
	?>

	<main id="main" class="main" role="main">