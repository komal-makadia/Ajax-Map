<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.2.1' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );

			/*
			 * Editor Styles
			 */
			add_theme_support( 'editor-styles' );
			add_editor_style( 'editor-styles.css' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				get_template_directory_uri() . '/header-footer' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

// Admin notice
if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

/**
 * Display Google Map using AJAX in WordPress with iframe from wp-config.php
 */

function enqueue_google_maps_scripts() {
    // Enqueue the custom script

    wp_enqueue_script('dynamic-map', get_template_directory_uri() . '/assets/js/dynamic-map.js', array('jquery'), null, true);

    // Add the Google Maps API script with async and defer attributes
    add_filter('script_loader_tag', function($tag, $handle) {
        if ('google-maps' !== $handle) {
            return $tag;
        }
        return str_replace(' src', ' async defer src', $tag);
    }, 10, 2);
	$api_key = MY_API_KEY;
    wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key='.$api_key, array(), null, true);

    // Localize the script
    wp_localize_script('dynamic-map', 'ajax_map_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_google_maps_scripts');


function ajax_load_google_map_by_address() {
    $address = isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '';

    if (empty($address)) {
        wp_send_json_error('Address is required.');
    } 

	echo '<div class="mapswrapper">
    <iframe 
        width="600" 
        height="450" 
        loading="lazy" 
        allowfullscreen 
        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&q=' . urlencode($address) . '&zoom=10&maptype=roadmap">
    </iframe>
    <a href="https://taxinstructions.net/form-709/" style="color:rgba(0,0,0,0);position:absolute;left:0;top:0;z-index:0;">Form 709 instructions</a>
    <style>
        .mapswrapper {
            background: #fff;
            position: relative;
        }
        .mapswrapper iframe {
            border: 0;
            position: relative;
            z-index: 2;
        }
        .mapswrapper a {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 0;
            display: block;
            width: 100%;
            height: 100%;
        }
    </style>
</div>';


}

add_action('wp_ajax_load_google_map_by_address', 'ajax_load_google_map_by_address');
add_action('wp_ajax_nopriv_load_google_map_by_address', 'ajax_load_google_map_by_address');


function google_map_by_address_shortcode() {
    ob_start();
    ?>
    <div id="map-form">
        <input type="text" id="address" placeholder="Enter Address, City, State, Country" style="width: 300px; padding: 5px;" />
        <button id="load-map" style="padding: 5px 10px;">Load Map</button>
    </div>
    <div id="map-container" style="width: 100%; height: 400px; margin-top: 20px; border: 1px solid #ccc;">
	<div class="mapswrapper"><iframe width="600" height="450" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&q=Ahmedabad&zoom=10&maptype=roadmap"></iframe><a href="https://taxinstructions.net/form-709/">Form 709 instructions</a><style>.mapswrapper{background:#fff;position:relative}.mapswrapper iframe{border:0;position:relative;z-index:2}.mapswrapper a{color:rgba(0,0,0,0);position:absolute;left:0;top:0;z-index:0}</style></div>
	</div>
    <?php
    return ob_get_clean();
}
add_shortcode('google_map_by_address', 'google_map_by_address_shortcode');

/**
 * Display Google Map using AJAX in WordPress with API Key from wp-config.php
 */
function google_map_by_api_shortcode() {

    // HTML for the form and map container (echoed directly)
    echo '<div id="map-form">';
    echo '<input type="text" id="address-api" placeholder="Enter Address, City, State, Country" style="width: 300px; padding: 5px;" />';
    echo '<button id="load-map-api" style="padding: 5px 10px;">Load Map</button>';
    echo '</div>';
    echo '<div id="map-container-api" style="width: 100%; height: 400px; margin-top: 20px; border: 1px solid #ccc;"></div>';

}

add_shortcode('google_map_by_api', 'google_map_by_api_shortcode');

function ajax_load_google_map_by_api() {
    $addressAPI = isset($_POST['addressAPI']) ? sanitize_text_field($_POST['addressAPI']) : '';

    if (empty($addressAPI)) {
        wp_send_json_error('Address is required.');
    }

    $api_key = MY_API_KEY; // Replace with your free Google Maps API key
    $geocode_url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($addressAPI) . "&key=" . $api_key;

    // Fetch geocode data from Google API
    $response = wp_remote_get($geocode_url);

    if (is_wp_error($response)) {
        wp_send_json_error('Failed to fetch geocode data.');
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!empty($data['results'][0]['geometry']['location'])) {
        $location = $data['results'][0]['geometry']['location'];
        wp_send_json_success(array(
            'latitude' => $location['lat'],
            'longitude' => $location['lng'],
            'formatted_address' => $data['results'][0]['formatted_address'],
        ));
    } else {
        wp_send_json_error('Invalid address or no results found.');
    }
}

add_action('wp_ajax_load_google_map_by_api', 'ajax_load_google_map_by_api');
add_action('wp_ajax_nopriv_load_google_map_by_api', 'ajax_load_google_map_by_api');










