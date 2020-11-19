<?php
function gci_list_smif_members()
{
  $pmbus_members_list='';
  ob_start();
  global $wpdb;
?>
  <div class='one' style='background-image:url(""); background-size:100%;'>
    <h2>SMIF Member Directory</h2>
  </div>
  <div class='two' style='background-size:100%;'>
    <center><h2 >SMIF Member Directory</h2></center>
  </div>


<?php
    $members_list = $wpdb->get_results(
      "SELECT * FROM wp_term_taxonomy as tx, wp_terms as tr, wp_termmeta as tm
        WHERE tx.taxonomy = 'companies' AND
          tr.term_id = tx.term_id AND
          tm.term_id = tx.term_id AND
          tm.meta_key = 'membership_type' AND
          tm.meta_value != 'Draft'");
?>

<?php
    $terms = get_terms( array(
      'taxonomy' => 'companies',
      'hide_empty' => false
    ) );
?>
    <input type="text" id="myInput" onkeyup="myFunction();" placeholder="Search Member By Company Name.." title="Type in a name">
    <div id="table-container" style="overflow-x:auto;">
      <div>
          <table id='membersTable'>
            <tr>
              <th colspan="2" class="table_ref" style="width:40%;">SMIF Member</br>
                <span style="font-size:0.8em;font-weight:normal;" >(click to visit PMBus member page)</span></th>
              <th class="table_ref" style="width:15%;">Member Type</th>
              <th class="table_ref" style="width:20%;">Company Website</br>
                <span style="font-size:0.8em; font-weight:normal;" >(opens in new window)</span></th>
              <th class="table_ref" style="width:15%;">Additional Info</th>
            </tr>
<?php
            for ($k=0; $k < count($members_list); $k++)
            {
              // get the member ID
              $loop_member_id = $members_list[$k]->term_id;
?>
              <tr align=center>
<?php
              // get the member type
              $loop_member_type_value = $members_list[$k]->meta_value;
              // get the Company Logo
              $loop_company_logo =
                "SELECT * FROM `wp_termmeta`
                  WHERE term_id = $loop_member_id AND
                  meta_key = 'company_logo'";
              $loop_company_logo_query = $wpdb->get_results($loop_company_logo);
              $company_logo = $loop_company_logo_query[0]->meta_value;
              $company_logo_id=  $company_logo;

              $company_logo_src = wp_get_attachment_image_src($company_logo_id, $small_image,'thumbnail', true)[0];
                                $PMBusLogo = site_url() . "/wp-content/uploads/pmbus_logo_92x46-trans.png";
              // get the company member type
              $company_directory_url = site_url() . '/directory/' . $loop_slug;
              $company_tools_url = site_url() . '/category/tools/';

              if ($loop_member_type_value == "PMBus Adopter") {
                  // they are a PMBus Adopter
                  // build the Company internal URL from the slug
                  $loop_slug = $members_list[$k]->slug;
?>
                  <td style:"align-center;"><a href="<? echo $company_directory_url ?>"><img width=75px height=25px src="<?=$company_logo_src ?>" alt="<?= $members_list[$k]->name ?>"/></a></td>
                  <td style:"align-center;"><a href="<? echo $company_directory_url ?>"><span style="font-weight:bold;text-decoration:none;"> <?= $members_list[$k]->name ?></span></td>
                  <td style:"align-center;"><img width="46" height="21" src="<?= $PMBusLogo ?>" alt="PMBus Adoptor"/><span style="color: #6b3064; font-size:1em; font-weight:bold;">Adopter</span></td>
<?php
              } else {
                  // not a PMBus Adopter
?>
                  <td style:"align-center;"><img width=75px height=25px src="<?=$company_logo_src ?>" alt="<?= $members_list[$k]->name ?>"/></td>
                  <td style:"align-center;"><a href="<?= $company_tools_url ?>" ><span style="font-weight:bold;text-decoration:none;"> <?= $members_list[$k]->name ?></span></a></td>
                  <td style:"align-center;"><span style="font-weight:bold;"><?= $loop_member_type_value ?></span></td>
<?php
              }
                  $loop_company_website_url =
                    "SELECT * FROM `wp_termmeta`
                      WHERE term_id = $loop_member_id AND
                      meta_key = 'company_website_url'";
                  $loop_company_website_url_query = $wpdb->get_results($loop_company_website_url);
                  $company_website_url = $loop_company_website_url_query[0]->meta_value;
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
            </tr>
<?php
            } // end for loop
?>
          </table>
      </div>
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
add_shortcode('gci_list_members', 'gci_list_smif_members');
