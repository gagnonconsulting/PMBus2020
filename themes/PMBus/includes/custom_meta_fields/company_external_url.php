<?php

function external_url_taxonomy_add_new_meta_field() {
  // this will add the custom meta field to the add new term page
  ?>
  <div class="form-field">
    <label for="term_meta[custom_term_meta]"><?php _e( 'External URL:', 'external_url' ); ?></label>
    <input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="">
    <p class="description"><?php _e( 'Enter a value for this field','external_url' ); ?></p>
  </div>
<?php
}

// Edit term page
function external_url_taxonomy_edit_meta_field($term) {

// put the term ID into a variable
$t_id = $term->term_id;

// retrieve the existing value(s) for this meta field. This returns an array
$term_meta = get_option( "taxonomy_$t_id" ); ?>
<tr class="form-field">
<th scope="row" valign="top"><label for="term_meta[custom_term_meta]"><?php _e( 'External URL:', 'external_url' ); ?></label></th>
  <td>
    <input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="<?php echo esc_attr( $term_meta['custom_term_meta'] ) ? esc_attr( $term_meta['custom_term_meta'] ) : ''; ?>">
    <p class="description"><?php _e( 'Enter a value for this field','external_url' ); ?></p>
  </td>
</tr>
<?php
}

// Save extra taxonomy fields callback function.
function save_taxonomy_custom_meta( $term_id ) {
if ( isset( $_POST['term_meta'] ) ) {
  $t_id = $term_id;
  $term_meta = get_option( "taxonomy_$t_id" );
  $cat_keys = array_keys( $_POST['term_meta'] );
  foreach ( $cat_keys as $key ) {
    if ( isset ( $_POST['term_meta'][$key] ) ) {
      $term_meta[$key] = $_POST['term_meta'][$key];
    }
  }
  // Save the option array.
  update_option( "taxonomy_$t_id", $term_meta );
}
}

//foreach ($terms as $term) {
   // $external_url will be "P Elena" or "P Andrea" in your case
   //$external_url = get_field('external_url', $term->taxonomy.'_'.$term->term_id);
//}
