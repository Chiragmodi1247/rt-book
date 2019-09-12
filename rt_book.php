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