<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Rt_Book
 *
 * @wordpress-plugin
 * Plugin Name:       Rt_Book
 * Description:       A plugin to handle information about a book.
 * Version:           1.0.0
 * Author:            Chirag Modi
 * Text Domain:       rt-book
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RT_BOOK_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_rt_book() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rt-book-activator.php';
	Rt_Book_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_rt_book() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rt-book-deactivator.php';
	Rt_Book_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rt_book' );
register_deactivation_hook( __FILE__, 'deactivate_rt_book' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rt-book.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rt_book() {

	$plugin = new Rt_Book();
	$plugin->run();

}
run_rt_book();

function rt_book_custom_post_type()
{

	$labels = array(
		'name'               => _x( 'Books', 'post type general name' ),
		'singular_name'      => _x( 'Book', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Book' ),
		'edit_item'          => __( 'Edit Book' ),
		'new_item'           => __( 'New Book' ),
		'all_items'          => __( 'All Books' ),
		'view_item'          => __( 'View Book' ),
		'search_items'       => __( 'Search Books' ),
		'not_found'          => __( 'No Books found' ),
		'not_found_in_trash' => __( 'No Books found in the Trash' ), 
		// 'parent_item_colon'  => ’,
		'menu_name'          => 'Books'
	  );
	  $args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Books and Book specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true,
	  );
	  register_post_type( 'Book', $args );
}
add_action('init', 'rt_book_custom_post_type');

function rt_book_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Genres', 'textdomain' ),
		'all_items'         => __( 'All Genres', 'textdomain' ),
		'parent_item'       => __( 'Parent Genre', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
		'edit_item'         => __( 'Edit Genre', 'textdomain' ),
		'update_item'       => __( 'Update Genre', 'textdomain' ),
		'add_new_item'      => __( 'Add New Genre', 'textdomain' ),
		'new_item_name'     => __( 'New Genre Name', 'textdomain' ),
		'menu_name'         => __( 'Genre', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);

	register_taxonomy( 'genre', array( 'book' ), $args );

	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Writers', 'taxonomy general name', 'textdomain' ),
		'singular_name'              => _x( 'Writer', 'taxonomy singular name', 'textdomain' ),
		'search_items'               => __( 'Search Writers', 'textdomain' ),
		'popular_items'              => __( 'Popular Writers', 'textdomain' ),
		'all_items'                  => __( 'All Writers', 'textdomain' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Writer', 'textdomain' ),
		'update_item'                => __( 'Update Writer', 'textdomain' ),
		'add_new_item'               => __( 'Add New Writer', 'textdomain' ),
		'new_item_name'              => __( 'New Writer Name', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separate writers with commas', 'textdomain' ),
		'add_or_remove_items'        => __( 'Add or remove writers', 'textdomain' ),
		'choose_from_most_used'      => __( 'Choose from the most used writers', 'textdomain' ),
		'not_found'                  => __( 'No writers found.', 'textdomain' ),
		'menu_name'                  => __( 'Writers', 'textdomain' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'writer' ),
	);

	register_taxonomy( 'writer', 'book', $args );
}

add_action('init' , 'rt_book_taxonomies');

function rt_book_html($post)
{
	wp_nonce_field( 'rt_book_save_meta_data', 'rt_book_meta_box_nonce' );

	$book_meta = get_post_meta( $post->ID ,'_book_meta_key',true);

echo '<label for="book_meta_fields"> Author: ';
echo '<input type="text" id="author_name" name="author_name" value="'.esc_attr($book_meta).'" required ><br/>';

}

function rt_book_custom_meta_box()
{
    $screen = 'book';
        add_meta_box(
            'rt_book_id',           // Unique ID
            'Book Meta Details',  	// Box title
            'rt_book_html',  		// Content callback, must be of type callable
			$screen				// Post type
		);
}
add_action('add_meta_boxes', 'rt_book_custom_meta_box');

add_action('edit_form_after_title', function() {
    global $post, $wp_meta_boxes;
    do_meta_boxes(get_current_screen(), 'advanced', $post);
    unset($wp_meta_boxes[get_post_type($post)]['advanced']);
});


function rt_book_save_meta_data( $post_id) {
	if( ! isset( $_POST['rt_book_meta_box_nonce'] ) ) {
		return;
	}
	if( ! wp_verify_nonce( $_POST['rt_book_meta_box_nonce'], 'rt_book_save_meta_data' ) ) {
		return;
	}
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return;
	}
	if( ! current_user_can( 'edit_post' , $post_id ) ) {
		return;
	}
	if( ! isset( $_POST['author_name'] ) ){
		return;
	}

	$my_data = sanitize_text_field( $_POST['author_name']);
		update_post_meta( $post_id , '_book_meta_key' , $my_data );
}
add_action( 'save_post', 'rt_book_save_meta_data');