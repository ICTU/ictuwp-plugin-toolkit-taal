<?php

/**
 * @link                https://github.com/ICTU/ictuwp-plugin-toolkit-taal
 * @package             ictuwpPluginToolkitTaal
 *
 * @wordpress-plugin
 * Plugin Name:         ICTU / Gebruiker Centraal / Toolkit Taal
 * Plugin URI:          https://github.com/ICTU/ictuwp-plugin-toolkit-taal
 * Description:         Plugin voor functionaliteit van de 'toolkit taal'-subsite
 * Version:             1.0.1
 * Version description: Better filter breadcrumb list when viewing a single Voorbeeld CPT.
 * Author:              Paul van Buuren / David Hund
 * Author URI:          https://github.com/ICTU/ictuwp-plugin-toolkit-taal/
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:         gctheme
 * Domain Path:         /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// CONSTANTS:
//========================================================================================================
// `voorbeeld` custom post type
defined( 'TT_EXAMPLE_CPT' ) or define( 'TT_EXAMPLE_CPT', 'voorbeeld' );

// `voorbeeld_type` taxonomy
defined( 'TT_EXAMPLE_TYPE_TAX' ) or define( 'TT_EXAMPLE_TYPE_TAX', 'voorbeeld_type' );
defined( 'TT_PAGETEMPLATE_OVERVIEW_EXAMPLE_CPT' ) or define( 'TT_PAGETEMPLATE_OVERVIEW_EXAMPLE_CPT', 'template-voorbeelden.php' );

// page ID for overview of all example posts, used in customizr and enriching the breadcrumb
defined( 'TT_EXAMPLE_CPT_OVERVIEW_PAGEID' ) or define( 'TT_EXAMPLE_CPT_OVERVIEW_PAGEID', 'tt_overview_voorbeelden_pageid' );

// the TT_EXAMPLE_TYPE_TAX taxonomy is also registered for this post type
defined( 'GC_INSTRUMENT_CPT' ) or define( 'GC_INSTRUMENT_CPT', 'instrument' );

//========================================================================================================
// only this plugin should activate the TT_EXAMPLE_TYPE_TAX taxonomy
if ( ! taxonomy_exists( TT_EXAMPLE_TYPE_TAX ) ) {
	add_action( 'plugins_loaded', array( 'ICTU_GC_toolkit_taal', 'init' ), 10 );
}


//========================================================================================================

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */


if ( ! class_exists( 'ICTU_GC_toolkit_taal' ) ) :

	class ICTU_GC_toolkit_taal {

		/** ----------------------------------------------------------------------------------------------------
		 * Init
		 */
		public static function init() {

			$new_tt = new self();

		}

		/** ----------------------------------------------------------------------------------------------------
		 * Constructor
		 */
		public function __construct() {

			$this->setup_actions();

		}

		/** ----------------------------------------------------------------------------------------------------
		 * Hook this plugins functions into WordPress.
		 * Use priority = 20, to ensure that the taxonomy is registered for post types from other plugins,
		 * such as the podcasts plugin (seriously-simple-podcasting)
		 */
		private function setup_actions() {

			// register taxonomies
			add_action( 'init', array( $this, 'register_taxonomy' ), 20 );

			// filter the breadcrumbs
			add_filter( 'wpseo_breadcrumb_links', array( $this, 'yoast_filter_breadcrumb' ) );

		}

		/** ----------------------------------------------------------------------------------------------------
		 * Do actually register the taxonomies we need
		 *
		 * @return void
		 */
		public function register_taxonomy() {

			require_once plugin_dir_path( __FILE__ ) . 'includes/register-voorbeeld_type-taxonomy.php';

		}



		/**
		 * Filter the Yoast SEO breadcrumb: get the ID for the page that shows an overview
		 * of all TT_EXAMPLE_CPT and insert this page into the breadcrumb list
		 *
		 * @in: $links (array)
		 *
		 * @return: $links (array)
		 *
		 */
		public function yoast_filter_breadcrumb( $links ) {

			if (  is_singular( TT_EXAMPLE_CPT ) ) {
				// we are viewing a single TT_EXAMPLE_CPT
				$example_type_overview_page_id = $this->get_example_type_overview_page();
				if ( $example_type_overview_page_id ) {
					$taxonomy_link = array(
						'url'  => get_permalink( $example_type_overview_page_id ),
						'text' => get_the_title( $example_type_overview_page_id )
					);
					array_splice( $links, - 1, 0, array( $taxonomy_link ) );
				}
			}

			return $links;

		}

		/**
		 * Retrieve a page that is the TT_EXAMPLE_TYPE_TAX overview page. This
		 * page should exist in the theme folder with the file name TT_PAGETEMPLATE_OVERVIEW_EXAMPLE_CPT
		 * First we try to retrieve the page ID from the theme settings in the customizer. If no such
		 * settings exist we check if a page is published with the correct template.
		 *
		 * @in: $args (array)
		 *
		 * @return: $overview_page_id (integer)
		 *
		 */

		private function get_example_type_overview_page( $args = array() ) {

			$return = 0;

			if ( get_theme_mod( TT_EXAMPLE_CPT_OVERVIEW_PAGEID ) ) {
				// Page ID is available from the theme settings, so retrieve it
				$return = get_theme_mod( TT_EXAMPLE_CPT_OVERVIEW_PAGEID );
			} else {
				// No page ID from the theme settings.
				// So we check if a page is published having the appropriate template. If such
				// a page exists we save this page ID to the theme settings
				$page_template_query_args = array(
					'number'      => 1,
					'sort_column' => 'post_date',
					'sort_order'  => 'DESC',
					'meta_key'    => '_wp_page_template',
					'meta_value'  => TT_PAGETEMPLATE_OVERVIEW_EXAMPLE_CPT
				);
				$overview_page            = get_pages( $page_template_query_args );
				if ( $overview_page && isset( $overview_page[0]->ID ) ) {
					// the correct page exists, so we save it
					$return = $overview_page[0]->ID;
					set_theme_mod( TT_EXAMPLE_CPT_OVERVIEW_PAGEID, $overview_page[0]->ID );
				}

			}

			return $return;

		}


	}

endif;


//========================================================================================================

/**
 * Load plugin textdomain.
 * only load translations if we can safely assume the taxonomy is active
 */
add_action( 'init', 'toolkit_taal_load_plugin_textdomain' );

function toolkit_taal_load_plugin_textdomain() {

	load_plugin_textdomain( 'gctheme', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

}

//========================================================================================================



