<?php

// enqueue styles for child theme
// @ https://digwp.com/2016/01/include-styles-child-theme/
function enqueue_styles() {

	// enqueue parent styles
  wp_enqueue_style('Divi', get_template_directory_uri() .'/style.css');

	// enqueue child styles
	wp_enqueue_style('PMBus', get_stylesheet_directory_uri() .'/style.css', array('Divi'));

}
add_action('wp_enqueue_scripts', 'enqueue_styles');
//require_once( get_stylesheet_directory() . '/includes.php');
require_once( get_stylesheet_directory() . '/includes.php');

// Override theme default specification for product # per row
// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');

//Display products in tabular format on customer pages
remove_action ('woocommerce_template_loop_rating', 5);
remove_action ('woocommerce_template_loop_price', 10);
add_action('woocommerce_after_shop_loop_item_title', 'gci_show_product_info');

// Add custom taxonomy of type Company
add_action('init', 'wpshout_register_taxonomy');

// Add custom Company field to 'Edit Page' in dashboard
add_action( 'add_meta_boxes', 'cd_meta_box_add_company' );

// Save custom fields to user meta when update is pressed
add_action( 'save_post', 'cd_meta_box_save_company' );

// Add menu item PMBus Manager and correlating pages
add_action( 'admin_menu', 'add_pmbus_manager_menu' );

add_action( 'companies_edit_form_fields', 'external_url_taxonomy_edit_meta_field', 10, 2 );
add_action( 'edited_companies', 'save_taxonomy_custom_meta', 10, 2 );
add_action( 'create_companies', 'save_taxonomy_custom_meta', 10, 2 );
//add_action( 'admin_menu', 'companies_menu_link' );

// Set default page template as member home page
add_action('add_meta_boxes', 'set_default_page_template', 1);

add_action( 'after_setup_theme', 'example_insert_category' );

// Enable Gravity Forms field label visibility
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// Allow shortcodes on pages (not tested, but should work)
add_filter('the_content','do_shortcode');

// replace WordPress Howdy in WordPress 3.3 and up
function replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Howdy,', 'Hi', $my_account->title );
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle
    ) );
}
add_filter( 'admin_bar_menu', 'replace_howdy', 25 );

// replace footer credits
function et_get_footer_credits() {
  $developed_by = 'Website by <a href="https://gagnonconsulting.com" target="_blank">Gagnon Consulting, Inc.</a>'; // Developer info
 // $terms = '<br><a href="/privacy-policy">Privacy Policy</a> | <a href="/terms-and-conditions">Terms and Conditions</a>'; // Privacy and Terms of Condition links (comment to remove)
  $beg_year = 2017;
  $cur_year = intval(date('Y'));
  $display_year = $cur_year;
  $footer_credits = 'Copyright &copy;'. $display_year . " SMIF. ". $developed_by ;
  $credits_format = '<%2$s id="footer-info">%1$s</%2$s>';
  return et_get_safe_localization( sprintf( $credits_format, $footer_credits, 'div' ) );
}

// Rename "home" in breadcrumb
function wcc_change_breadcrumb_home_text( $defaults ) {
    // Change the breadcrumb home text from 'Home' to 'blank'
	$defaults['home'] = '';
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_home_text' );

// for custom search.php in PMBus child theme
add_action( 'pre_get_posts', function( $query ) {

    // Check that it is the query we want to change: front-end search query
    if( $query->is_main_query() && ! is_admin() && $query->is_search() ) {
        // Change the query parameters
        $query->set( 'posts_per_page', 3 );
    }
} );

// used to keep a div at the same place on a page while scrolling the content
function enqueue_floating_window_scripts () {
  // get the javascript file and enqueue it, then ad it to the wp_print_scripts action
  $script_location = get_stylesheet_directory_uri() . "/includes/js/floating_window.js";
  wp_enqueue_script( 'floatingwindow_script', $script_location);
}
add_action('wp_enqueue_scripts','enqueue_floating_window_scripts');

// used to keep a div at the same place on a page while scrolling the content
function enqueue_sortTable_script () {
  // get the javascript file and enqueue it, then ad it to the wp_print_scripts action
  $script_location = get_stylesheet_directory_uri() . "/includes/js/sortTable.js";
  wp_enqueue_script( 'sortTable_script', $script_location);
}
add_action('wp_enqueue_scripts','enqueue_sortTable_script');


// AJAX STUFF
// for displaying products in a div on category listing
function enqueue_show_products_scripts () {
  // get the javascript file and enqueue it, then ad it to the wp_print_scripts action
  $script_location = get_stylesheet_directory_uri() . "/includes/js/show_products.js";
    wp_enqueue_script( 'ajax-script', $script_location, array ('jquery') );
    wp_localize_script( 'ajax-script', 'ajax', array('url' => admin_url( 'admin-ajax.php' )) );
}
add_action ('wp_print_scripts', 'enqueue_show_products_scripts');

// this is the function that the Ajax request is running
function show_products_callback() {
      // Get the request data
      global $wpdb;
      // get_the_data
      $term_id = $_POST['term_id'];
      //echo "<h2>term_id = ".$term_id."</h2>";
      $listing_type = $_POST['listing_type'];
      //echo "<h2>In show_products_callback - ".$listing_type."</h2>";

      echo do_shortcode('[product_category category='.$term_id.' limit=-1 ]');
      die();
}

// and this adds the actions on init to register the function with the Ajax and
add_action ( 'wp_ajax_nopriv_show_products', 'show_products_callback' );
add_action ( 'wp_ajax_show_products', 'show_products_callback' );

// END AJAX STUFF

add_filter( 'woocommerce_get_price_html', function( $price ) {
	//if ( is_admin() ) return $price;
	return '';
} );

// ROLE STUFF
add_role(
  "member_admin",
  __( "Member Admin" ),
  array("read" => true, "edit_posts" => true)
);

// EXTRA FIELD GROUP (EFG)
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5d95075a2df33',
	'title' => 'Company Additional Info',
	'fields' => array(
		array(
			'key' => 'field_5d9b9e9328bc2',
			'label' => 'Company Display Name',
			'name' => 'company_display_name',
			'type' => 'text',
			'instructions' => 'This is the name that will appear on the website.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d950760cc899',
			'label' => 'Membership Type',
			'name' => 'membership_type',
			'type' => 'radio',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'Inactive' => 'Inactive',
				'PMBus Adopter Company' => 'PMBus Adopter Company',
				'Full SMIF Member Company' => 'Full SMIF Member Company',
				'Tools Member' => 'Tools Member',
				'PMBus Adopter Individual' => 'PMBus Adopter Individual',
				'Full SMIF Member Individual' => 'Full SMIF Member Individual',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'Inactive',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_5d950797cc89a',
			'label' => 'Company Domain',
			'name' => 'company_domain',
			'type' => 'text',
			'instructions' => 'This is the domain of the company (no http://www, etc.) Used as primary key.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d9507fdcc89c',
			'label' => 'Company URL',
			'name' => 'company_url',
			'type' => 'url',
			'instructions' => 'Actual web URL - may be different than Company Domain Name',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
		array(
			'key' => 'field_5d9507ebcc89b',
			'label' => 'Company Notes',
			'name' => 'company_notes',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
    array(
			'key' => 'field_5d950812cc89d',
			'label' => 'Company Logo',
			'name' => 'company_logo',
			'type' => 'image',
			'instructions' => '150px square recommended',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'thumb',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
			'key' => 'field_5f860c0b72729',
			'label' => 'Company Logo Large',
			'name' => 'company_logo_large',
			'type' => 'image',
			'instructions' => 'Larger company logo or other image used for display of Member Homepage. Should be able to be viewed in a 400x300px box',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),    array(
    			'key' => 'field_5f860c0b72729',
    			'label' => 'Company Logo Large',
    			'name' => 'company_logo_large',
    			'type' => 'image',
    			'instructions' => '500px wide by 300px tall recommended',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '',
    				'class' => '',
    				'id' => '',
    			),
    			'return_format' => 'array',
    			'preview_size' => 'medium',
    			'library' => 'all',
    			'min_width' => '',
    			'min_height' => '',
    			'min_size' => '',
    			'max_width' => '',
    			'max_height' => '',
    			'max_size' => '',
    			'mime_types' => '',
    		),
    array(
      'key' => 'field_5eda4e641875d',
      'label' => 'SBS',
      'name' => 'sbs_flag',
      'type' => 'true_false',
      'instructions' => 'Used for admin purposes.',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'return_format' => 'array',
      'preview_size' => 'medium',
      'library' => 'all',
      'min_width' => '',
      'min_height' => '',
      'min_size' => '',
      'max_width' => '',
      'max_height' => '',
      'max_size' => '',
      'mime_types' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'companies',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5da5c27515346',
	'title' => 'User Additional Info',
	'fields' => array(
		array(
			'key' => 'field_5da5c2af7395b',
			'label' => 'Internal Notes',
			'name' => 'internal_notes',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'user_form',
				'operator' => '==',
				'value' => 'edit',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
