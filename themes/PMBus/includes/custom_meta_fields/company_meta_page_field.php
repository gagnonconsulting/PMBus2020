<?php
add_action( 'add_meta_boxes', 'cd_meta_box_add_company' );
function cd_meta_box_add_company() {
  add_meta_box( 'my-meta-box-id', '1. Select the company below to display the corresponding products.<br>2. Select the featured image (Company Logo) for the page.<br>3. Select the PMBus SMIF Member the page belongs to.', 'cd_meta_box_cb', 'page', 'normal', 'high' );
}
function cd_meta_box_cb( $post ) {

  global $wpdb;
  $woo_commerce_company = $wpdb->get_results("
  SELECT * FROM `wp_terms` WHERE name = 'Company'
  ");
  $woo_commerce_company_id = $woo_commerce_company[0]->term_id;

  $cquery = $wpdb->get_results
  ("
  SELECT * FROM
  (
    SELECT * FROM
    (SELECT name, slug FROM wp_terms
    WHERE slug LIKE 'company-%') AS term,
    (SELECT * FROM wp_term_taxonomy
    WHERE parent = ".$woo_commerce_company_id.") AS tax
    ) AS t2
    GROUP BY name
    ");


    $values = get_post_custom( $post->ID );
    //$text = isset( $values['Company'] ) ? esc_attr( $values['Company'][0] ) : '';
    //wp_nonce_field( 'company_nonce', 'meta_box_nonce' );
    $selected = isset( $values['Company'] ) ? esc_attr( $values['Company'][0] ) : '';
      wp_nonce_field( 'company_nonce', 'meta_box_nonce' );
    ?>
    <p>

      <label for="Company"></label>
      <select name="Company" id="Company">
        <option value="" selected> --- No Products ---</option>
        <?php
          for($i=0; $i<count($cquery); $i++){?>
            <option value="<?= $cquery[$i]->slug ?>" <?php selected( $selected, $cquery[$i]->slug ); ?>><?= $cquery[$i]->name ?></option><?php
          }?>
      </select>
    </p>
    <?php
  }

  add_action( 'save_post', 'cd_meta_box_save_company' );
  function cd_meta_box_save_company( $post_id ) {
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'company_nonce' ) ) return;
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
    // now we can actually save the data
    $allowed = array(
      'a' => array( // on allow a tags
        'href' => array() // and those anchords can only have href attribute
      )
    );
    // Probably a good idea to make sure your data is set
    if( isset( $_POST['Company'] ) )
    update_post_meta( $post_id, 'Company', wp_kses( $_POST['Company'], $allowed ) );
  }

  /* function user_membership_field( $user ) {
    $membership_status = get_the_author_meta( 'membership', $user->ID);

    ?>
    <table class="form-table">
      <tr>
        <th>
          <label for="Membership Type"><?php _e('PMBus User Type'); ?></label>
        </th>
        <td><span class="description"></span><br>
          <label><input type="radio" name="membership" <?php if ($membership_status == 'Full-Member-Admin' ) { ?>checked="checked"<?php }?> value="Full-Member-Admin">Full Member Admin<br /></label>
          <label><input type="radio" name="membership" <?php if ($membership_status == 'Full-Member' ) { ?>checked="checked"<?php }?> value="Full-Member">Full Member<br /></label>
          <label><input type="radio" name="membership" <?php if ($membership_status == 'Tools-Member' ) { ?>checked="checked"<?php }?> value="Tools-Member">Tools Member<br /></label>
        </td>
      </tr>
    </table>
    <?php
  }


      function my_save_custom_user_profile_fields( $user_id ) {
        if ( !current_user_can( 'edit_user', $user_id ) )
        return FALSE;

        update_usermeta( $user_id, 'membership', $_POST['membership'] );

        if ($membership_status == 'Full-Member'){
          $u = new WP_User( $user_id );
          // Remove role
          $u->remove_role( 'subscriber' );

          // Add role
          $u->add_role( 'author' );
        }



      }

      add_action( 'personal_options_update', 'my_save_custom_user_profile_fields' );
      add_action( 'edit_user_profile_update', 'my_save_custom_user_profile_fields' ); */
