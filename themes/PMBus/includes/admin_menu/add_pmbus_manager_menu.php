<?php
function add_pmbus_manager_menu() {
  // MAIN PMBUS ADMIN MENU
  add_menu_page(
    'PMBus Manager',
    'PMBus Manager',
    'manage_options',
    'pmbus_company_submenu-slug',
    'wpsites_company_menu_link',
    'dashicons-id',
    3);

  // ADD/MODIFY/DEACTIVATE/DELTET  MEMBER COMPANIES
  add_submenu_page(
    'pmbus_company_submenu-slug',
    'SMIF Member Companies',
    'SMIF Member Companies',
    'manage_options',
    'pmbus_company_submenu-slug',
    'wpsites_company_menu_link');

  // ADD/MODIFY/DEACTIVATE/DELTET  MEMBER COMPANIES
  add_submenu_page(
      'pmbus_company_submenu-slug',
      'SMIF Members',
      'SMIF Members',
      'manage_options',
      'pmbus_member_submenu-slug',
      'wpsites_member_menu_link');

  // TRAINING RESOURCES
	add_submenu_page(
    'pmbus_company_submenu-slug',
    'Training Resources',
    'Training Resources',
  	 'manage_options',
  		'training_resources-submenu-slug',
  		 'training_resources_page_build');
}

// Below is the code to remove admin menu tabs for a specified email (user)
add_action('admin_menu', 'remove_manager_menu_links', '999');
function remove_manager_menu_links(){
  $user = wp_get_current_user();
  //var_dump ($user);

  if ( $user && isset($user->user_roles) &&  $user->user_roles == "editor") {
    echo "<h1>Editor</h1>";
   remove_submenu_page('index.php','update-core.php');
   remove_menu_page('tools.php');
    remove_menu_page('themes.php');
    remove_menu_page('projects.php');
    remove_menu_page('options-general.php');
    remove_menu_page('plugins.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('page.php');
		remove_menu_page('upload.php');
		remove_menu_page('edit.php?post_type=videos' );
		remove_menu_page('edit.php' );
		remove_menu_page('groups-admin');
		remove_menu_page('gf_edit_forms');
		remove_menu_page('revslider');
		remove_menu_page('maintenance');
		remove_menu_page('et_divi_options');
		remove_menu_page('aws-options');
		remove_menu_page('tablepress');
		remove_menu_page('woocommerce');
		remove_menu_page('edit.php?post_type=project' );
		remove_menu_page('wpengine-common' );
    remove_menu_page('wppusher');
    remove_menu_page('edit.php?post_type=acf' );
    remove_menu_page('edit.php?post_type=acf-field-group' );
    remove_submenu_page('users.php','capsman');
    remove_submenu_page('users.php','view-guest-authors');
    remove_submenu_page ('edit.php?post_type=product','tm-global-epo');

  }
}

//if ( $user ) {
//     if( $user && isset($user->user_email) && '3Yadmin@gagnonconsulting.com' == $user->user_email )
// 			show_admin_bar( true );
//}


function wpsites_company_menu_link(){
  $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  $arr = explode("/", $url, 2);
  $first = $arr[0];
  $smifUrl = home_url().'/wp-admin/edit-tags.php?taxonomy=companies&post_type=page';
  wp_redirect( $smifUrl, 301 );
	exit;
}
function wpsites_member_menu_link(){
  $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  $arr = explode("/", $url, 2);
  $first = $arr[0];
  $smifUrl = home_url().'/wp-admin/users.php';
  wp_redirect( $smifUrl, 301 );
	exit;
}
