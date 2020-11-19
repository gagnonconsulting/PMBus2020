<?php

// Create a function that adds a new column
function my_custom_taxonomy_columns( $columns ){
	$columns['status'] = __('Current Status');
  $columns['toggle_status'] = __('Toggle Status');

	return $columns;
}
// Call tis function when the 'companies' taxonomy columns are being built
add_filter('manage_edit-companies_columns' , 'my_custom_taxonomy_columns');

function my_custom_taxonomy_columns_content( $content, $column_name, $term_id ){
  if('status' == $column_name){
    $term22 = get_term_by('id', $term_id, 'companies');
    if(get_field('membership_status', $term22)){
      $status = strip_tags(get_field('membership_status', $term22));
      if($status == 'Active'){
        echo '<span style="color:green">'.$status.'</span>';
      }
      else{
        echo '<span style="color:red">'.$status.'</span>';
      }
    }
    else {
      echo '<span style="color:gray"><em>Not Set</em></span>';
    }
  }
	return $content;
}
add_filter( 'manage_companies_custom_column', 'my_custom_taxonomy_columns_content', 10, 3 );

function my_custom_taxonomy_columns_content2( $content, $column_name, $term_id ){
  if('toggle_status' == $column_name){
    // Get the current term
    $term2 = get_term_by('id', $term_id, 'companies');
    // Get the status of the current term
    $status = strip_tags(get_field('membership_status', $term2));

    if($status == 'Inactive'){?>
        <a href="<?php echo get_stylesheet_directory_uri() ?>/includes/company_taxonomy/toggle_status.php?id=<?= $term_id?>&action=activate"><span style="padding: 10px; color: white; background-color: gray">Activate</span></a>
      <?php
    }
    elseif($status == 'Active') { ?>
        <a href="<?php echo get_stylesheet_directory_uri() ?>/includes/company_taxonomy/toggle_status.php?id=<?= $term_id?>&action=deactivate"><span style="padding: 10px; color: white; background-color: gray">Deactivate</span></a>
        <?php
    }
  }
	return $content;
}
add_filter( 'manage_companies_custom_column', 'my_custom_taxonomy_columns_content2', 10, 3 );


function my_enqueue($hook) {
    // Only add to the edit.php admin page.
    // See WP docs.
    if ('edit.php' !== $hook) {
        return;
    }
    wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . '/toggle_status_function.js');
}

add_action('admin_enqueue_scripts', 'my_enqueue');
