<?php

namespace Mortageoffice;

class Enqueuer {
	public static $defer_styles = [
		'google_fonts',
		'skeletor_animation',
		'skeletor_blog_posts',
		'skeletor_resource_center',
	];

	public static function setup() {
		add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_scripts'], PHP_INT_MAX);
		add_action('admin_enqueue_scripts', [__CLASS__, 'admin_enqueue_scripts'], PHP_INT_MAX);
		add_action('enqueue_block_editor_assets', [__CLASS__, 'enqueue_scripts'], PHP_INT_MAX);
		add_filter('defer_styles', [__CLASS__, 'defer_styles']);

		//Wait until init so that it loads AFTER the base skeletor styles
		add_action('init', function () {
			add_editor_style(['build/main.css']);
		});
	}

	/**
	 * Gets site info for use in wp_localize_script()
	 * @return object Site information
	 */
	public static function get_site_info() {
		return apply_filters(
			'skeletor_site_info', [
				'homeUrl'        => get_home_url(),
				'themeDirectory' => get_stylesheet_directory_uri(),
				'parentDirectory' => get_template_directory_uri(),
			]
		);
	}

	public static function defer_styles($handles) {
		return array_merge($handles, self::$defer_styles);
	}

	public static function enqueue_fonts() {
		/**
		 * NOTE:
		 * the google fonts query args for multiple families
		 * uses the 'family' parameter multiple times
		 * when WP tries to process the 'version' it strips
		 * out all but one of those parameters.
		 * Setting the version to null will get around this
		 */
		wp_enqueue_style(
			'google_fonts',
			'https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap',
			[],
			null
		);
	}

	public static function enqueue_scripts() {
		self::enqueue_fonts();

		$build_path = sprintf('%s/build', get_stylesheet_directory());
		$build_url = sprintf('%s/build', get_stylesheet_directory_uri());

		// check for file existence first, otherwise we'll get a fatal error
		if (!file_exists(sprintf('%s/main.asset.php', $build_path))) {
			return;
		}
		$asset = require_once(sprintf('%s/main.asset.php', $build_path));
		if (!$asset) {
			return;
		}

		wp_enqueue_script(
			'__THEMEDIR__',
			sprintf('%s/main.js', $build_url),
			$asset['dependencies'],
			$asset['version'],
			true
		);

		wp_enqueue_style(
			'mortageoffice',
			sprintf('%s/main.css', $build_url),
			[],
			filemtime(sprintf('%s/main.css', $build_path))
		);

		if (!is_admin() && is_singular('vtl_person') || is_singular('vtl_product') || is_singular('vtl_market') || is_singular('vtl_application')) {
			wp_enqueue_script(
				'vital-tabbed-content-view-scripts',
				plugins_url() . '/vital-tabbed-content/build/view.js',
				$asset['dependencies'],
				$asset['version'],
				true
			);
		}

		wp_enqueue_style(
			'select2',
			'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
			[],
			null
		);

		wp_enqueue_script(
			'select2',
			'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
			[],
			'4.1.0',
			true
		);

		wp_localize_script('__THEMEDIR__', 'SiteInfo', self::get_site_info());
	}

	public static function admin_enqueue_scripts() {
		$build_path = sprintf('%s/build', get_stylesheet_directory());
		$build_url = sprintf('%s/build', get_stylesheet_directory_uri());

		$admin_asset = require_once(sprintf('%s/admin.asset.php', $build_path));
		if (!$admin_asset) {
			return;
		}

		wp_enqueue_script(
			'mortageoffice',
			sprintf('%s/admin.js', $build_url),
			$admin_asset['dependencies'],
			$admin_asset['version'],
			true
		);

		wp_enqueue_style(
			'mortageoffice_admin',
			sprintf('%s/admin.css', $build_url),
			[],
			filemtime(sprintf('%s/admin.css', $build_path))
		);
	}
}

add_action('after_setup_theme', ['Mortageoffice\Enqueuer', 'setup']);
