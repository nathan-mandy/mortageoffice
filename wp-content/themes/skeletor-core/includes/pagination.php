<?php

namespace Skeletor;

class Pagination {
	public static function setup() {
		add_action('skeletor_archive_pagination', [__CLASS__, 'archive_pagination']);
	}

	public static function archive_pagination($queried_object) : void {
		$classes = ['wp-block-group', 'archive-pagination'];
		if (is_a($queried_object, 'WP_Post_Type')) {
			$classes[] = sprintf('%s__archive-pagination', $queried_object->name);
		}
		$classes = apply_filters('archive_pagination_classes', $classes, $queried_object);
		if (!is_array($classes)) {
			$classes = [$classes];
		}
		?>
		<section class="<?php echo implode(' ', $classes); ?>">
			<?php
			if (function_exists('facetwp_display')) {
				echo facetwp_display('pager');
			}
			?>
		</section>
		<?php
	}

	/**
	 * Custom Pagination
	 *
	 * Use without arguments for standard loops, or include arguments to
	 * customize pagination inside WP_Queries
	 *
	 * More info: http://callmenick.com/post/custom-wordpress-loop-with-pagination
	 *
	 * @param  {Boolean} $echo      Whether to echo output or return it
	 * @param  {String}  $numpages  Number of pages returned by our query
	 * @param  {String}  $pagerange Range of pages that we will display (even number)
	 * @param  {String}  $paged     The $paged value
	 * @return {String}             Pagination HTML
	 */

	public static function vital_pagination($echo = true, $numpages = '', $pagerange = '', $paged = '') {
		global $paged, $wp_query;

		$output = '';

		if (empty($pagerange)) {
			$pagerange = 2;
		}

		if (empty($paged)) {
			$paged = 1;
		}

		if ($numpages === '') {
			$numpages = $wp_query->max_num_pages;
			if (!$numpages) {
				$numpages = 1;
			}
		}

		$pagination_args = array(
			'base'         => get_pagenum_link(1) . '%_%',
			'format'       => 'page/%#%',
			'total'        => $numpages,
			'current'      => $paged,
			'show_all'     => false,
			'end_size'     => 1,
			'mid_size'     => $pagerange,
			'prev_next'    => true,
			'prev_text'    => __('Previous'),
			'next_text'    => __('Next'),
			'type'         => 'plain',
			'add_args'     => false,
			'add_fragment' => '',
		);

		$paginate_links = paginate_links($pagination_args);
		if ($paginate_links) {
			$output = sprintf(
				'<section class="wp-block-group archive-pagination"><div class="facetwp-pager">%s</div></section>',
				$paginate_links
			);
			// Change the span to anchor and WP's page-numbers class on the anchor to facetwp-page.
			$output = str_replace('class="page-numbers', 'class="facetwp-page', $output);
			$output = str_replace('<span', '<a', $output);
			$output = str_replace('</span', '</a', $output);
		}

		if ($echo === true) {
			echo $output;
			return;
		}

		return $output;
	}
}
add_action('after_setup_theme', ['\\Skeletor\\Pagination', 'setup']);
