<?php

namespace Skeletor\FacetWP;

use DOMDocument;

class Pager_Customizations {
	public static function setup() {
		\add_filter( 'facetwp_facet_pager_link', [__CLASS__,'modify_pager_link' ], 99, 2 );
	}

	/**
	 * when applicable, adds the appropriate href to the element
	 *
	 * @param string $output
	 * @param array $params
	 * @return string
	 */
	public static function modify_pager_link($output, $params) {
		$pagination = mb_convert_encoding($output, 'HTML-ENTITIES', "UTF-8"); 
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->loadHTML($pagination);
		$anchors = $doc->getElementsByTagName('a');
		if (!$anchors || $anchors->length === 0) {
			return $output;
		}

		$anchor = $anchors->item(0);
		if (!is_a($anchor, 'DOMElement')) {
			return $output;
		}

		$href = self::_generate_pager_url($params['page']);

		/**
		 * FYI: linter will think getAttribute isn't a function
		 * as it probably interprets the $anchor var as a DOMNode
		 * and not a DOMElement which extends the DOMNode
		 */
		$anchor->setAttribute('href', $href);
		$html = $doc->saveHTML($anchor);
		if ($html) {
			return $html;
		}

		return $output;
	}

	/**
	 * generates the URL for our pager link
	 *
	 * @param int $page_number
	 * @return string
	 */
	private static function _generate_pager_url($page_number) {
		// fetch our current URL
		$url = get_current_url();

		// parse our page number
		$page_number = intval($page_number);
		
		// turn the url into fragments
		$fragments = parse_url($url);

		// get our query args
		if (!array_key_exists('query', $fragments) || empty($fragments['query'])) {
			$query_args = [];
		} else {
			parse_str($fragments['query'], $query_args);
		}

		// if we have no page number or it's one or less (? could it ever be ?)
		// unset our page number
		if (!$page_number || $page_number < 2) {
			if (array_key_exists('_paged', $query_args)) {
				unset($query_args['_paged']);
			}
		} else {
			// add our page number
			$query_args['_paged'] = $page_number;
		}

		// if we have no query args just go with the path
		if (count($query_args) === 0) {
			return sprintf('/%s/', $fragments['path']);
		}

		// give back our url with the query args
		return sprintf('/%s/?%s', $fragments['path'], http_build_query($query_args));
	}

}
\add_action('after_setup_theme', ['Skeletor\FacetWP\Pager_Customizations', 'setup']);
