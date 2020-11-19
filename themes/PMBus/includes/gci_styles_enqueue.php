<?php
function example_enqueue_styles() {

	// enqueue parent styles
	wp_enqueue_style(
		'parent-theme',
		get_template_directory_uri() . '/style.css'
	);

}
add_action('wp_enqueue_scripts', 'example_enqueue_styles');

  // enqueue divi child styles - dependencies are in array
function divi_child_enqueue() {
	wp_enqueue_style(
		'divi_child_styles',
		get_stylesheet_directory_uri() . '/style.css',
		array(
			'parent-theme',
			'woocommerce-general',
			'woocommerce-smallscreen',
			'woocommerce-layout'),
			'1.0.0',
			'all'
		);
}

add_action('wp_enqueue_scripts', 'divi_child_enqueue', 59);

function theme_enqueue_styles() {
    wp_enqueue_style(
			'parent-style',
			get_template_directory_uri() . '/style.css' );
    wp_enqueue_style(
			'child-style',
      get_stylesheet_directory_uri() . '/style.css',
      array('parent-style')
    );
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 60 );
