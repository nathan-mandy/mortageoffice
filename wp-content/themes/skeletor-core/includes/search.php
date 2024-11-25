<?php

namespace Skeletor;
use Skeletor\Pagination;

class Search {
	public static function setup() {
		\add_action('before_search_loop', [__CLASS__, 'inject_search_header']);
		\add_action('search_results', [__CLASS__, 'inject_search_results']);
		\add_action('search_no_results', [__CLASS__, 'inject_no_results']);
		\add_action('after_search_loop', [__CLASS__, 'inject_pagination']);
	}

	public static function inject_search_header() {
		get_template_part('parts/search', 'hero');
	}

	public static function inject_search_results() {
		get_template_part('parts/search', 'results');
	}

	public static function inject_no_results() {
		get_template_part('parts/content', 'none');
	}

	public static function inject_pagination() {
		if (class_exists('\Skeletor\Pagination')) {
			echo Pagination::vital_pagination(true, '', 1, 0);
		}
	}
}

add_action('after_setup_theme', ['Skeletor\Search', 'setup']);
