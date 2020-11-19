<?php
function gci_list_pmbus_adopters()
{
  $pmbus_members_list='';
  ob_start();
  global $wpdb;
?>
  <div class='one' style='background-image:url(""); background-size:100%;'>
    <h2>PMBus Adopters List</h2>
    <!-- <h5> (For a list of all SMIF member companies,
    see the <a class="table_item" style="text-decoration: underline"
    href='http://pmbus.wpengine.com/members-directory/'>SMIF Members List</a>)</h5> -->
  </div>
  <div class='two' style='background-size:100%;'>
    <center><h2 >PMBus Adopters</h2></center>
  </div>


<?php
    $members_list = $wpdb->get_results(
      "SELECT * FROM wp_term_taxonomy as tx, wp_terms as tm
        WHERE tx.taxonomy = 'companies' AND tm.term_id = tx.term_id
        GROUP BY name;");
?>

<?php
    //$member_data = get_userdata( $custom_term_meta[734] );
    // echo count($members_list);
    $terms = get_terms( array(
      'taxonomy' => 'companies',
      'hide_empty' => false
    ) );
?>

    <input type="text" id="myInput" onkeyup="myFunction();" placeholder="Search Adopter By Company Name.." title="Type in a name">
    <div id="table-container" style="overflow-x:auto;">
      <div>
          <table id='membersTable'>
            <tr>
              <th colspan="2" class="table_ref" style="width:40%;">SMIF Member</br>
                <span style="font-size:0.8em;font-weight:normal;" >(click to visit PMBus member page)</span></th>
              <th class="table_ref" style="width:30%;">Company Website</br>
                <span style="font-size:0.8em; font-weight:normal;" >(opens in new window)</span></th>
              <th class="table_ref" style="width:20%;">Additional Info</th>
            </tr>
<?php
            for ($k=0; $k < count($members_list); $k++)
            {
              // get any additional info about PMBus Adopter company
?>
<?php
              // get the member ID
              $loop_member_id = $members_list[$k]->term_id;
              //echo "loop_member_id = ".$loop_member_id."</br> ";

              // check the member type
              $loop_member_type =
                "SELECT * FROM `wp_termmeta`
                  WHERE term_id = $loop_member_id AND
                  meta_key = 'membership_type'";
              $loop_member_type_query = $wpdb->get_results($loop_member_type);
              $loop_member_type_value = $loop_member_type_query[0]->meta_value;
              //echo "loop_member_type_value = ".$loop_member_type_value."<br>";
              if (
                ($loop_member_type_value == 'PMBus Adopter')
                //or ($loop_member_type_value == 'Full Member (SMIF)')
                //or ($loop_member_type_value == 'Tools Member')
                ) // end if
              {
?>
                <tr align=center>
<?php
                  // get the Company internal URL
                  $loop_slug = $members_list[$k]->slug;
                  //echo "loop_slug = ".$loop_slug."</br> ";

                  // get the Company logo
                  $company_internal_url = site_url() . '/directory/' . $loop_slug;
                  //echo "Internal_url = ".$company_internal_url."</br>";
                  $loop_company_logo =
                    "SELECT * FROM `wp_termmeta`
                      WHERE term_id = $loop_member_id AND
                      meta_key = 'company_logo'";
                  $loop_company_logo_query = $wpdb->get_results($loop_company_logo);
                  $company_logo = $loop_company_logo_query[0]->meta_value;
                  $company_logo_id=  $company_logo;

                  $company_logo_src = wp_get_attachment_image_src($company_logo_id, $small_image,'thumbnail', true)[0];
?>
                  <td style:"align-center;"><a href="<? echo $company_internal_url ?>"><img width=75px height=25px src="<?=$company_logo_src ?>" alt="<?= $members_list[$k]->name ?>"/></a></td>

                  <td><a href="<? echo $company_internal_url ?>"><span style="font-weight:bold;text-decoration:none;"> <?= $members_list[$k]->name ?></span></td>

<?php
                  // get the Company web URL
                  $loop_company_website_url =
                    "SELECT * FROM `wp_termmeta`
                      WHERE term_id = $loop_member_id AND
                      meta_key = 'company_website_url'";
                  $loop_company_website_url_query = $wpdb->get_results($loop_company_website_url);
                  $company_website_url = $loop_company_website_url_query[0]->meta_value;
                  //echo "Company website url = ".$company_website_url."<br>";
?>
                  <td>
                    <a class="table_item" target="_blank" href="<?= $company_website_url ?>"><span style="font-decoration:none;"><?= $company_website_url; ?></span></a>
                  </td>
<?php
                  // get any additional info about PMBus Adopter company
                  $loop_additional_info =
                    "SELECT * FROM `wp_termmeta`
                      WHERE term_id = $loop_member_id AND
                      meta_key = 'additional_info'";
                  $loop_additional_info_query = $wpdb->get_results($loop_additional_info);
                  $company_additional_info = $loop_additional_info_query[0]->meta_value;
                  //echo "Company website url = ".$company_website_url."<br>";
?>
                  <td><?= $company_additional_info ?></td>
<?php
} //end of member type PMBus Adopter
?>
            </tr>
<?php
            }
            //echo do_shortcode("[groups_users_list_members group_id='8' /]");
            //echo do_shortcode("[groups_users_list_members group_id='4' /]");
?>
          </table>
      </div> //end of table container
    </div>
  </div>

  <script>
    function myFunction() {
      var input, filter, table, tr, td, i;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          }
          else {
          tr[i].style.display = "none";
          }
        }
      }
    }
  </script>

<?php
  $pmbus_members_list = ob_get_clean();
  return $pmbus_members_list;
}
add_shortcode('list_adopters', 'gci_list_pmbus_adopters');
