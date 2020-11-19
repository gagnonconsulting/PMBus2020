<?php

//Removed Woocommerce functionality
require_once( get_stylesheet_directory() . '/includes/gci_woocommerce_removals.php');

// Custom User fields functions
require_once( get_stylesheet_directory() . '/includes/custom_meta_fields/company_meta_page_field.php');

// PMBus admin custom pages and menu
require_once( get_stylesheet_directory() . '/includes/admin_menu/add_pmbus_manager_menu.php');
require_once( get_stylesheet_directory() . '/includes/admin_menu/pmbus_members_page_build.php');
require_once( get_stylesheet_directory() . '/includes/admin_menu/pmbus_admin_add_new_member.php');
// Display Membership types and user information on admin page
require_once( get_stylesheet_directory() . '/includes/admin_menu/groups_users_list_members.php');
require_once( get_stylesheet_directory() . '/includes/shortcodes/gci_list_all_products_by_category.php');
require_once( get_stylesheet_directory() . '/includes/shortcodes/gci_list_all_products_by_company.php');
require_once( get_stylesheet_directory() . '/includes/shortcodes/list_all_cats.php');

require_once( get_stylesheet_directory() . '/includes/gci_show_product_info.php');

require_once( get_stylesheet_directory() . '/includes/admin_menu/dev_testing/pmbus_dev_testing_page.php');

// Single Column product display
require_once( get_stylesheet_directory() . '/includes/single_column_product_display.php');

require_once( get_stylesheet_directory() . '/includes/company_taxonomy/company_taxonomy.php');

// Group Memberships
require_once( get_stylesheet_directory() . '/includes/user_group_memberships.php');
// Products by Category Shortcode
//require_once( get_stylesheet_directory() . '/includes/shortcodes/products_by_category.php');
// List Companies with Products Shortcode
//require_once( get_stylesheet_directory() . '/includes/shortcodes/list_companies.php');
// List active PMBus Members [Companies taxonomy] shortcode
require_once( get_stylesheet_directory() . '/includes/shortcodes/pmbus_member_directory.php');
require_once( get_stylesheet_directory() . '/includes/shortcodes/pmbus_smif_page_directory.php');
require_once( get_stylesheet_directory() . '/includes/shortcodes/list_adopters.php');
require_once( get_stylesheet_directory() . '/includes/shortcodes/gci_list_members.php');
require_once( get_stylesheet_directory() . '/includes/shortcodes/gci_test.php');

// Custom User Meta 'Company'
require_once( get_stylesheet_directory() . '/includes/custom_meta_fields/user_company_meta_field.php');

require_once( get_stylesheet_directory() . '/includes/admin_menu/training_resources/training_resources_page_build.php');

// Enqueue custom styles and load after themes
require_once( get_stylesheet_directory() . '/includes/gci_styles_enqueue.php');

require_once( get_stylesheet_directory() . '/includes/shortcodes/revolving_slider.php');

require_once( get_stylesheet_directory() . '/includes/members_pages/page_template_default.php');
require_once( get_stylesheet_directory() . '/includes/members_pages/set_parent_default.php');

require_once( get_stylesheet_directory() . '/includes/shortcodes/gravity_forms_styling.php');

require_once( get_stylesheet_directory() . '/includes/product_tables/dynamic_table_display.php');

require_once( get_stylesheet_directory() . '/includes/company_taxonomy/smif_member_status.php');
