<?php
add_action( 'add_meta_boxes', 'cd_meta_box_add_company' );
function cd_meta_box_add_company() {
    add_meta_box( 'my-meta-box-id', 'Company Name:', 'cd_meta_box_cb', 'page', 'normal', 'high' );
}
function cd_meta_box_cb( $post ) {
    $values = get_post_custom( $post->ID );
    $text = isset( $values['Company'] ) ? esc_attr( $values['Company'][0] ) : '';
    wp_nonce_field( 'company_nonce', 'meta_box_nonce' );
    ?>
    <p>
        <label for="Company"></label>
        <input type="text" name="Company" id="Company" value="<?php echo $text; ?>" />
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

function user_membership_field( $user ) {
    $membership_status = get_the_author_meta( 'membership', $user->ID);
		?>
    <h3><?php _e('PMBus User Information'); ?></h3>
    <table class="form-table">
        <tr>
            <th>
            <label for="Membership Type"><?php _e('PMBus User Type'); ?>
            </label></th>
            <td><span class="description"></span><br>
            <label><input type="radio" name="membership" <?php if ($membership_status == 'Full-Member-Admin' ) { ?>checked="checked"<?php }?> value="Full-Member-Admin">Full Member Admin<br /></label>
            <label><input type="radio" name="membership" <?php if ($membership_status == 'Full-Member' ) { ?>checked="checked"<?php }?> value="Full-Member">Full Member<br /></label>
						<label><input type="radio" name="membership" <?php if ($membership_status == 'Tools-Member' ) { ?>checked="checked"<?php }?> value="Tools-Member">Tools Member<br /></label>
            </td>

				</tr>

				<tr>
        		<th>
            <label for="company_name"><?php _e('Company'); ?>
            </label></th>
          	<td>
            <span class="description"><?php _e('Insert Your Company name'); ?></span><br>
            <input type="text" name="company_name" id="company_name" value="<?php echo esc_attr( get_the_author_meta( 'company_name', $user->ID ) ); ?>" class="regular-text" /><br />
          	</td>
        </tr>



    </table>
		<?php
}


function my_save_custom_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return FALSE;

    update_usermeta( $user_id, 'membership', $_POST['membership'] );
		update_usermeta( $user_id, 'company_name', $_POST['company_name'] );


}
