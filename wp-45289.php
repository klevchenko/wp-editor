<?php
/*
Plugin Name: WP 45289
Plugin URI: https://github.com/CGlingener/wp-45289
Description: Simple setup to reproduce https://core.trac.wordpress.org/ticket/45289. Edit a post type supporting Gutenberg to see the js error.
*/
define( 'WP_45289_URL', plugins_url( basename( __DIR__ ) ) );
add_action( 'admin_init', function() {
	/**
	 * Register our script
	 * Uncomment 'wp-editor' on dependencies to make it work again on WP 5.0
	 */
	wp_register_script(
		'wp-45289',
		WP_45289_URL . '/wp-45289.js',
		array( /* 'wp-editor' */ )
	);
	/**
	 * Should load all editor scripts
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_editor/
	 */
	wp_enqueue_editor();
} );
/**
 * Add meta box with textarea, which will be used by 'wp-45289.js' to init visual editor
 */
add_action( 'load-post.php', 'wp_45289_meta_box');
add_action( 'load-post-new.php', 'wp_45289_meta_box' );
function wp_45289_meta_box() {
	add_action( 'add_meta_boxes', function() {
		add_meta_box(
			'wp_45289',
			'Should contain a Visual Editor',
			function() {
				echo '<textarea id="wp_45289_visual_editor"></textarea>';
			}
		);
	} );
	add_action( 'admin_enqueue_scripts', function() {
		wp_enqueue_script( 'wp-45289' );
	} );
}