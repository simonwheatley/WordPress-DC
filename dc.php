<?php

/*
Plugin Name: DC
Plugin URI: http://simonwheatley.co.uk/wordpress/dc
Description: Some Dublin Corification
Version: 0.1
Author: Simon Wheatley
Author URI: http://simonwheatley.co.uk//wordpress/
*/

/*  Copyright 2011 Simon Wheatley

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

/**
 * Hooks the WP init action 
 *
 * @param  
 * @return void
 **/
function dc_init() {
	$labels = array(
		'add_new_item' => 'Add New DC Category',
		'all_items' => 'All Defra DC Categories',
		'edit_item' => 'Edit DC Category',
		'name' => 'DC Taxonomy',
		'new_item_name' => 'New DC Category Name',
		'parent_item' => 'Parent DC Category',
		'parent_item_colon' => 'Parent DC Category:',
		'popular_items' => 'Popular DC Categories in this site',
		'search_items' => 'Search DC Categories',
		'singular_name' => 'DC Category',
		'update_item' => 'Update DC Category',
	);
	// Make up a capability name for managing/editing/deleting the
	// terms, so that most roles can't edit this taxonomy.
	$caps = array(
		'manage_terms' => 'manage_dc',
		'edit_terms'   => 'manage_dc',
		'delete_terms' => 'manage_dc',
		'assign_terms' => 'edit_posts',
	);
	$args = array(
		'capabilities' => $caps,
		'hierarchical' => true,
		'labels' => $labels,
		'public' => true,
		'query_var' => true,
		'rewrite' => true,
		'show_ui' => true,
	 	'update_count_callback' => '_update_post_term_count',
	);
	$taxonomies = apply_filters( 'dc_taxonomies', array() );
	foreach ( $taxonomies as $slug => $tax ) {
		$args[ 'labels' ][ 'name' ] = "DC: " . $tax;
		register_taxonomy( $slug, apply_filters( 'dc_taxonomised_content_types', array( 'post', 'page' ) ), $args );
		
	}
}
add_action( 'init', 'dc_init' );

/**
 * Returns an array of DC taxonomies
 *
 * @return array An array of DC taxonomies in the form slug => Name, e.g 'instructionalmethod' => 'Instructional Method'
 * @author Simon Wheatley
 **/
function dc_taxonomies( $taxonomies ) {
	return $taxonomies + array( 
		'contributor' => 'Contributor',
		'coverage' => "Coverage",
		'format' => 'Format',
		'instructionalmethod' => 'Instructional Method',
		'language' => 'Language',
		'relation' => "Relation",
		'rights' => 'Rights',
		'source' => "Source",
		'type' => "Type",
	);
}
add_filter( 'dc_taxonomies', 'dc_taxonomies' );

?>