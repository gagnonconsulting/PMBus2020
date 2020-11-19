<?php
// Import necessary wordpress functions
require_once("../../../../../wp-load.php");
require_once("../../../../plugins/advanced-custom-fields/acf.php");
require_once("../../../../plugins/woocommerce/woocommerce.php");

$term_id = ($_GET["id"]);     // Term ID (passed in url)
$action = ($_GET["action"]);  // Action (passed in url)
// The term we are dealing with
$term22 = get_term_by('id', $term_id, 'companies');
$companies_smif_member_slug = $term22->slug; // SMIF Member slug
// Building the SMIF members product category company slug (prepend company slug with 'company-')
$product_category_smif_slug = 'company-' . $companies_smif_member_slug;
$companies_smif_member_name = $term22->name; // SMIF Member name

// Wordpress global DB variable
global $wpdb;
// Get the post ID of the page belonging to the selected SMIF member
$product_results = $wpdb->get_results("SELECT post.ID FROM `wp_posts` post, `wp_postmeta` meta WHERE post.ID = meta.post_id AND meta.meta_key = 'Company' AND meta.meta_value = '$product_category_smif_slug'");

$results = $wpdb->get_results("SELECT * FROM `wp_posts` post, `wp_term_relationships` term_rel, `wp_terms` term WHERE post.post_name = '$companies_smif_member_slug' AND post.post_type = 'page'AND term_rel.object_id = post.ID AND term.term_id = term_rel.term_taxonomy_id GROUP BY ID");

$page_id = $results[0]->ID;

// Activate Member and Publish Page Function
function activate_smif_member_and_publish_page($term22, $page_id, $companies_smif_member_name){

  $term22 = $term22;
  $page_id = $page_id;
  $companies_smif_member_name = $companies_smif_member_name;

  // 'Activate Toggled on SMIF member
  update_field('membership_status', 'Active', $term22);

  // If there is a page associated with this member
  if($page_id){
    // Change status of page related to this company to published
    $post = array( 'ID' => $page_id, 'post_status' => 'publish' );
    wp_update_post( $post );

    $message = $companies_smif_member_name . ' Successfully Activated!';

    echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('$message');
        window.location.replace(\"../../../../../wp-admin/edit-tags.php?taxonomy=companies&post_type=page\");
    </SCRIPT>";
    mysql_close();
  }
  else {
    $message = $companies_smif_member_name . ' Successfully Deactivated!\n\nThere Were No Pages or Products Associated with this SMIF Member';

    echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('$message');
        window.location.replace(\"../../../../../wp-admin/edit-tags.php?taxonomy=companies&post_type=page\");
    </SCRIPT>";
    mysql_close();
  }
}
// Deactivate Member and Publish Page Function
function deactivate_smif_member_and_draft_page($term22, $page_id, $companies_smif_member_name){

  $term22 = $term22;
  $page_id = $page_id;
  $companies_smif_member_name = $companies_smif_member_name;

  // Deactivate Toggled on SMIF member
  update_field('membership_status', 'Inactive', $term22);

  // If there is a page associated with this member
  if($page_id){
    // Change the status of the SMIF member page to private
    $post = array( 'ID' => $page_id, 'post_status' => 'private' );
    wp_update_post($post);

    $message = $companies_smif_member_name . ' Successfully Deactivated!';

    echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('$message');
        window.location.replace(\"../../../../../wp-admin/edit-tags.php?taxonomy=companies&post_type=page\");
    </SCRIPT>";
    mysql_close();
  }
  else {
    $message = $companies_smif_member_name . ' Successfully Deactivated!\n\nThere Were No Pages or Products Associated with this SMIF Member';

    echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('$message');
        window.location.replace(\"../../../../../wp-admin/edit-tags.php?taxonomy=companies&post_type=page\");
    </SCRIPT>";
    mysql_close();
  }
}

// Information for products --- --- --- --- --- --- --- ---
// Get the company product category information
$company_results = $wpdb->get_results("SELECT * FROM wp_terms WHERE name = 'Company'");
// Company product categories ID
$parent_id = $company_results[0]->term_id;
$smif_member_product_cat_sql = "SELECT * FROM `wp_term_taxonomy` termtax, `wp_terms` term
                            WHERE termtax.taxonomy = 'product_cat' AND term.term_id = termtax.term_id
                            AND termtax.parent = $parent_id AND term.slug = '$product_category_smif_slug'";
$smif_member_product_cat_result = $wpdb->get_results($smif_member_product_cat_sql);
$smif_product_category_id = $smif_member_product_cat_result[0]->term_id;
$smif_product_category_slug = $smif_member_product_cat_result[0]->slug;

// Set all products assigned to SMIF member to private
function draft_smif_member_products($product_category_smif_member_slug, $product_category_smif_member_id){
  $cat_id = $product_category_smif_member_id;
  $cat_slug = $product_category_smif_member_slug;

  $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'product_cat'    => $cat_slug,
    );

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;
        //echo '<br /><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().'</a>';
        $product_id = $product->id;
        $post = array( 'ID' => $product_id, 'post_status' => 'private' );
        wp_update_post( $post );
    endwhile;

    wp_reset_query();
}

// Set all products assigned to SMIF member to publish
function publish_smif_member_products($product_category_smif_member_slug, $product_category_smif_member_id){
  $cat_id = $product_category_smif_member_id;
  $cat_slug = $product_category_smif_member_slug;

  $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'product_cat'    => $cat_slug,
    );

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;
        //echo '<br /><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().'</a>';
        $product_id = $product->id;
        $post = array( 'ID' => $product_id, 'post_status' => 'publish' );
        wp_update_post( $post );
    endwhile;

    wp_reset_query();
}


// Activate/Publish the SMIF member and its content
if($action == 'activate'){
  if($product_results){
    publish_smif_member_products($smif_product_category_slug, $smif_product_category_id);
  }
  activate_smif_member_and_publish_page($term22, $page_id, $companies_smif_member_name);
}
// Deactivate/Draft the SMIF member and its content
elseif ($action == 'deactivate'){
  if($product_results){
    draft_smif_member_products($smif_product_category_slug, $smif_product_category_id);
  }
  deactivate_smif_member_and_draft_page($term22, $page_id, $companies_smif_member_name);
}
// else {
//   echo 'Insufficient Parameters';
//   header("Location: ../../../../../wp-admin/edit-tags.php?taxonomy=companies&post_type=page");
//   die;
// }

// $post = array( 'ID' => 9997, 'post_status' => 'publish' );
// wp_update_post( $post );
