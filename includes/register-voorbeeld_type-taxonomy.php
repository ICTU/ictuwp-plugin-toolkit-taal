<?php
/**
 * Custom Post Type: voorbeelden
 * Custom Taxonomy: voorbeeld_type
 * -  hierarchical (like 'category') but only for UI, used non-hierarchical
 *
 * @package ictuwpPluginToolkitTaal
 *
 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/
 * @see https://developer.wordpress.org/reference/functions/get_taxonomy_labels/
 *
 * CONTENTS:
 * - Set TT_EXAMPLE_CPT post type arguments and labels
 * - Register TT_EXAMPLE_CPT post type
 * - Set TT_EXAMPLE_TYPE_TAX taxonomy labels
 * - Set TT_EXAMPLE_TYPE_TAX taxonomy arguments
 * - Register TT_EXAMPLE_TYPE_TAX taxonomy
 *
 * Not used yet:
 * public function fn_ictu_example_get_post_example_type_terms() - Retreive voorbeeld Type terms with custom field data for Post
 * ----------------------------------------------------- */

if ( ! post_type_exists( TT_EXAMPLE_CPT ) ) {

	$slug_of_posttype = TT_EXAMPLE_CPT;
	$args             = array(
		'label'       => esc_html__( TT_EXAMPLE_CPT, 'gctheme' ),
		'description' => '',
		'labels'      => array(
			'name'                  => esc_html_x( 'Voorbeelden', 'post type definition', 'gctheme' ),
			'singular_name'         => esc_html_x( 'Voorbeeld', 'post type definition', 'gctheme' ),
			'menu_name'             => esc_html_x( 'Voorbeelden', 'post type definition', 'gctheme' ),
			'name_admin_bar'        => esc_html_x( 'Voorbeeld', 'post type definition', 'gctheme' ),
			'archives'              => esc_html_x( 'Overzicht voorbeelden', 'post type definition', 'gctheme' ),
			'attributes'            => esc_html_x( 'Eigenschappen voorbeeld', 'post type definition', 'gctheme' ),
			'parent_item_colon'     => esc_html_x( 'Parent voorbeeld:', 'post type definition', 'gctheme' ),
			'all_items'             => esc_html_x( 'Alle voorbeelden', 'post type definition', 'gctheme' ),
			'add_new_item'          => esc_html_x( 'Voorbeeld toevoegen', 'post type definition', 'gctheme' ),
			'add_new'               => esc_html_x( 'Toevoegen', 'post type definition', 'gctheme' ),
			'new_item'              => esc_html_x( 'Nieuw voorbeeld', 'post type definition', 'gctheme' ),
			'edit_item'             => esc_html_x( 'Bewerk voorbeeld', 'post type definition', 'gctheme' ),
			'update_item'           => esc_html_x( 'Update voorbeeld', 'post type definition', 'gctheme' ),
			'view_item'             => esc_html_x( 'Bekijk voorbeeld', 'post type definition', 'gctheme' ),
			'view_items'            => esc_html_x( 'Bekijk voorbeelden', 'post type definition', 'gctheme' ),
			'search_items'          => esc_html_x( 'Zoek voorbeeld', 'post type definition', 'gctheme' ),
			'not_found'             => esc_html_x( 'Niet gevonden', 'post type definition', 'gctheme' ),
			'not_found_in_trash'    => esc_html_x( 'Niet gevonden in prullenbak', 'post type definition', 'gctheme' ),
			'featured_image'        => esc_html_x( 'Uitgelichte afbeelding', 'post type definition', 'gctheme' ),
			'set_featured_image'    => esc_html_x( 'Uitgelichte afbeelding toevoegen', 'post type definition', 'gctheme' ),
			'remove_featured_image' => esc_html_x( 'Uitgelichte afbeelding verwijderen', 'post type definition', 'gctheme' ),
			'use_featured_image'    => esc_html_x( 'Gebruik als uitgelichte afbeelding', 'post type definition', 'gctheme' ),
			'insert_into_item'      => esc_html_x( 'Toevoegen', 'post type definition', 'gctheme' ),
			'uploaded_to_this_item' => esc_html_x( 'Bij dit voorbeeld geüpload', 'post type definition', 'gctheme' ),
			'items_list'            => esc_html_x( 'Overzicht', 'post type definition', 'gctheme' ),
			'items_list_navigation' => esc_html_x( 'Overzicht-menu', 'post type definition', 'gctheme' ),
			'filter_items_list'     => esc_html_x( 'Filter lijst met voorbeelden', 'post type definition', 'gctheme' ),
		),

		'show_in_rest'        => true,
		'supports'            => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'custom-fields',
			'revisions',
		),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'menu_icon'           => 'dashicons-media-document',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => array( 'slug' => $slug_of_posttype ),
		'capability_type'     => 'post'
	);

	register_post_type( TT_EXAMPLE_CPT, $args );
}


if ( ! taxonomy_exists( TT_EXAMPLE_TYPE_TAX ) && post_type_exists( TT_EXAMPLE_CPT ) ) {

	// [1] Voorbeeld Type Taxonomy Labels
	$example_type_tax_labels = [
		'name'                       => _x( 'Voorbeeld-type', 'Custom taxonomy labels definition', 'gctheme' ),
		'singular_name'              => _x( 'Voorbeeld-type', 'Custom taxonomy labels definition', 'gctheme' ),
		'search_items'               => _x( 'Zoek voorbeeld-types', 'Custom taxonomy labels definition', 'gctheme' ),
		'popular_items'              => _x( 'Populaire voorbeeld-types', 'Custom taxonomy labels definition', 'gctheme' ),
		'all_items'                  => _x( 'Alle voorbeeld-types', 'Custom taxonomy labels definition', 'gctheme' ),
		'edit_item'                  => _x( 'Bewerk voorbeeld-type', 'Custom taxonomy labels definition', 'gctheme' ),
		'view_item'                  => _x( 'Bekijk voorbeeld-type', 'Custom taxonomy labels definition', 'gctheme' ),
		'update_item'                => _x( 'Voorbeeld-type bijwerken', 'Custom taxonomy labels definition', 'gctheme' ),
		'add_new_item'               => _x( 'Voeg nieuw voorbeeld-type toe', 'Custom taxonomy labels definition', 'gctheme' ),
		'new_item_name'              => _x( 'Nieuwe voorbeeld-type', 'Custom taxonomy labels definition', 'gctheme' ),
		'separate_items_with_commas' => _x( 'Kommagescheiden voorbeeld-types', 'Custom taxonomy labels definition', 'gctheme' ),
		'add_or_remove_items'        => _x( 'Voorbeeld-types toevoegen of verwijderen', 'Custom taxonomy labels definition', 'gctheme' ),
		'choose_from_most_used'      => _x( 'Kies uit de meest-gekozen voorbeeld-types', 'Custom taxonomy labels definition', 'gctheme' ),
		'not_found'                  => _x( 'Geen voorbeeld-types gevonden', 'Custom taxonomy labels definition', 'gctheme' ),
		'no_terms'                   => _x( 'Geen voorbeeld-types gevonden', 'Custom taxonomy labels definition', 'gctheme' ),
		'items_list_navigation'      => _x( 'Navigatie door voorbeeld-type lijst', 'Custom taxonomy labels definition', 'gctheme' ),
		'items_list'                 => _x( 'Voorbeeld-type lijst', 'Custom taxonomy labels definition', 'gctheme' ),
		'item_link'                  => _x( 'Voorbeeld-type Link', 'Custom taxonomy labels definition', 'gctheme' ),
		'item_link_description'      => _x( 'Een link naar een voorbeeld-type', 'Custom taxonomy labels definition', 'gctheme' ),
		'menu_name'                  => _x( 'Voorbeeld-types', 'Custom taxonomy labels definition', 'gctheme' ),
		'back_to_items'              => _x( 'Terug naar voorbeeld-types', 'Custom taxonomy labels definition', 'gctheme' ),
		'not_found_in_trash'         => _x( 'Geen voorbeeld-types gevonden in de prullenbak', 'Custom taxonomy labels definition', 'gctheme' ),
		'featured_image'             => _x( 'Uitgelichte afbeelding', 'Custom taxonomy labels definition', 'gctheme' ),
		'archives'                   => _x( 'Voorbeeld-type overzicht', 'Custom taxonomy labels definition', 'gctheme' ),
	];

	// [2] Voorbeeld Type Taxonomy Arguments
	$example_type_slug = TT_EXAMPLE_TYPE_TAX;
	// TODO: discuss if slug should be set to a page with the overview template
	// like so:
	// $example_type_slug = fn_ictu_example_get_example_type_overview_page();

	$example_type_tax_args = [
		"labels"             => $example_type_tax_labels,
		"label"              => _x( 'Voorbeeld-types', 'Custom taxonomy arguments definition', 'gctheme' ),
		"description"        => _x( 'Type voorbeelden uit de Toolkit Taal van Gebruiker Centraal', 'Custom taxonomy arguments definition', 'gctheme' ),
		"hierarchical"       => true,
		"public"             => true,
		"show_ui"            => true,
		"show_in_menu"       => true,
		"show_in_nav_menus"  => false,
		"query_var"          => false,
		// Needed for tax to appear in Gutenberg editor.
		'show_in_rest'       => true,
		"show_admin_column"  => true,
		// Needed for tax to appear in Gutenberg editor.
		"rewrite"            => [
			'slug'       => $example_type_slug,
			'with_front' => true,
		],
		"show_in_quick_edit" => true,
	];

	// register the taxonomy with these post types
	$post_types_with_example_type = [
		TT_EXAMPLE_CPT,
		GC_INSTRUMENT_CPT
		// 'post',
		// 'page',
		// 'podcast',
		// 'session',
		// 'keynote',
		// 'speaker',
		// 'event',
		// 'video_page',
	];

	// check if the post types exist
	$post_types_with_example_type = array_filter( $post_types_with_example_type, 'post_type_exists' );

	// [3] Register our Custom Taxonomy
	register_taxonomy( TT_EXAMPLE_TYPE_TAX, $post_types_with_example_type, $example_type_tax_args );

} // if ( ! taxonomy_exists( TT_EXAMPLE_TYPE_TAX ) )

// DISABLED BELOW:
// SEE IF IT'S NEEDED FOR THE FUTURE
// IF NOT, DELETE IT

// 
// /**
//  * fn_ictu_example_get_example_type_terms()
//  *
//  * 'Voorbeeld Type' is a custom taxonomy (category)
//  * It has 2 extra ACF fields for an
//  * image and a landingspage
//  *
//  * This function fills an array of all
//  * terms, with their extra fields...
//  *
//  * If one $example_type_name is passed it returns only that
//  * If $term_args is passed it uses that for the query
//  *
//  * @see https://developer.wordpress.org/reference/functions/get_terms/
//  * @see https://www.advancedcustomfields.com/resources/adding-fields-taxonomy-term/
//  * @see https://developer.wordpress.org/reference/classes/wp_term_query/__construct/
//  *
//  * @param String $example_type_name Specific term name/slug to query
//  * @param Array $example_type_args Specific term query Arguments to use
//  */
// 
// 
// function fn_ictu_example_get_example_type_terms( $example_type_name = null, $term_args = null ) {
// 
// 	// TODO: I foresee that editors will want to have a custom order to the taxonomy terms
// 	// but for now the terms are ordered alphabetically
// 	$example_type_terms    = [];
// 	$example_type_query    = is_array( $term_args ) ? $term_args : [
// 		'taxonomy'   => TT_EXAMPLE_TYPE_TAX,
// 		// We also want Terms with NO linked content, in this case
// 		'hide_empty' => false,
// 		// sort by our custom numerical `example_type_sort_order` field ASC (so lower == first)
// 		// With equal values, we would *like* to sort alphabetically (on `name`), but that's not possible :(
// 		// So: with equal sort order, we sort by `term_id` (which is the order in which they were created)
// 		'order'      => 'ASC',
// 		'orderby'    => 'meta_value_num',
// 		'meta_key'   => 'example_type_sort_order',
// 		'meta_type'  => 'NUMERIC', // sort numerically, even if `example_type_sort_order` is stored as String
// 	];
// 
// 	// Query specific term name
// 	if ( ! empty( $example_type_name ) ) {
// 		// If we find a Space, or an Uppercase letter, we assume `name`
// 		// otherwise we use `slug`
// 		$RE_disqualify_slug              = "/[\sA-Z]/";
// 		$query_prop_type                 = preg_match( $RE_disqualify_slug, $example_type_name ) ? 'name' : 'slug';
// 		$example_type_query[ $query_prop_type ] = $example_type_name;
// 	}
// 
// 	$found_example_type_terms = get_terms( $example_type_query );
// 
// 	if ( is_array( $found_example_type_terms ) && ! empty( $found_example_type_terms ) ) {
// 		// Add our custom Fields to each found WP_Term instance
// 		// And add to $example_type_terms[]
// 		foreach ( $found_example_type_terms as $example_type_term ) {
// 			foreach ( get_fields( $example_type_term ) as $key => $val ) {
// 				$example_type_term->$key = $val;
// 			}
// 			// DEBUG: prefix name with term_id and example_type_sort_order
// 			// $example_type_term->name = $example_type_term->term_id . '-' . $example_type_term->example_type_sort_order . '-' . $example_type_term->name;
// 			$example_type_terms[] = $example_type_term;
// 		}
// 	}
// 
// 	return $example_type_terms;
// }
// 
// /**
//  * fn_ictu_example_get_post_example_type_terms()
//  *
//  * This function fills an array of all
//  * terms, with their extra fields _for a specific Post_...
//  *
//  * - Only top-level Terms
//  * - 1 by default
//  *
//  * used in [themes]/ictuwp-theme-gc2020/includes/gc-fill-context-with-acf-fields.php
//  *
//  * @param String|Number $post_id Post to retrieve linked terms for
//  *
//  * @return Array        Array of WPTerm Objects with extra ACF fields
//  */
// function fn_ictu_example_get_post_example_type_terms( $post_id = null, $term_number = 1 ) {
// 	$return_terms = [];
// 	if ( ! $post_id ) {
// 		return $return_terms;
// 	}
// 
// 	$post_example_type_terms = wp_get_post_terms( $post_id, TT_EXAMPLE_TYPE_TAX, [
// 		'taxonomy'   => TT_EXAMPLE_TYPE_TAX,
// 		'number'     => $term_number, // Return max $term_number Terms
// 		'hide_empty' => true,
// 		'parent'     => 0,
// 		'fields'     => 'names' // Only return names (to use in `fn_ictu_example_get_example_type_terms()`)
// 	] );
// 
// 	foreach ( $post_example_type_terms as $_term ) {
// 		$full_post_example_type_term = fn_ictu_example_get_example_type_terms( $_term );
// 		if ( ! empty( $full_post_example_type_term ) ) {
// 			$return_terms[] = $full_post_example_type_term[0];
// 		}
// 	}
// 
// 	return $return_terms;
// }
// 