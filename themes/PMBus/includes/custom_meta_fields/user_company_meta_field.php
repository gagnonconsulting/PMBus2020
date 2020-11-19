<?php
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );
add_action( 'user_new_form', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) {

  //note: user_company is now the ID, which is the domain name
  $user_company = get_user_meta( $user->ID, 'user_company' );

  //var_dump ($user_company);
  //echo ("<h2>user_company = ".$user_company[0]."</h2>");
  global $wpdb;
  $cquery = $wpdb->get_results
  ("
  SELECT * FROM wp_term_taxonomy as tx, wp_terms as tm, wp_termmeta as tmm
  WHERE tx.taxonomy = 'companies' AND tm.term_id = tx.term_taxonomy_id AND tm.term_id=tmm.term_id AND tmm.meta_key='membership_type'
  GROUP BY name;
  ");
  ?>

  <h3>PMBus Member Information</h3>
  <table class="form-table">
    <tr>
      <th><label for="User Company">User Company</label></th>
      <td>
        <select name="user_company" id="user_company">
          <option value="----------">---------- </option>
          <?php for($i=0; $i<count($cquery); $i++){?>
            <option value="<?= $cquery[$i]->name ?>"
              <?php if ( $cquery[$i]->name == $user_company[0] ) {
                echo (" selected");
              } ?>
              >
              <?php echo ($cquery[$i]->name." ------ (". $cquery[$i]->meta_value .")</span>"); ?>

              </option>

          <?php }?>
        </select>
      </td>
    </tr>
  </table>
  <?php
}

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
add_action( 'user_register', 'save_extra_user_profile_fields' );
add_action( 'profile_update', 'save_extra_user_profile_fields' );


function save_extra_user_profile_fields( $user_id ) {

  if ( !current_user_can( 'edit_user', $user_id ) ) {
    return false;
  }
  update_user_meta( $user_id, 'user_company', $_POST['user_company'] );

}
