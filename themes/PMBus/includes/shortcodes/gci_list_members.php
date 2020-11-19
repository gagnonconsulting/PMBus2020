<?php

function gci_list_members()
{
  $pmbus_members_list='';
  ob_start();
  global $wpdb;
?>
  <div class='one' style='background-image:url(""); background-size:100%;'>
    <h2>SMIF Members - Company Directory</h2>
  </div>
  <div class='two' style='background-size:100%;'>
    <center><h2 >SMIF Members - Company Directory 1</h2></center>
  </div>


<?php
    $members_list = $wpdb->get_results(
      "SELECT * FROM wp_term_taxonomy as tx, wp_terms as tr, wp_termmeta as tm
        WHERE tx.taxonomy = 'companies' AND
          tx.term_id = tr.term_id AND
          tx.term_id = tm.term_id AND
          tm.meta_key = 'membership_type' AND
          (tm.meta_value != 'Draft' AND tm.meta_value != 'Inactive') AND
          (tm.meta_value = 'PMBus Adopter Company' OR tm.meta_value = 'FULL SMIF Member Company' OR
            tm.meta_value = 'Tools Member')
        ORDER BY name ASC");
?>

    <div id="table-container" style="overflow-x:auto;">
      <div>
          <table id='membersTable'>
            <tr>
              <th colspan="2">SMIF Member Company</br>
                <span style="font-size:0.8em;font-weight:normal;" >(click to visit PMBus Adopter or Tools page)</span></th>
              <th>Member Type</th>
              <th >Company Website</br>
                <span style="font-size:0.8em; font-weight:normal;" >(opens in new window)</span></th>
              <th >Additional Info</th>
            </tr>
<?php

            // get the PMBus adopter logo
            $PMBusLogo = site_url() . "/wp-content/uploads/pmbus_logo_92x46-trans.png";

            for ($k=0; $k < count($members_list); $k++)
            {
              // get the member ID
              $loop_member_id = $members_list[$k]->term_id;
              ?>
<p>Member_id = <?p= $loop_member_id</p>
<?
              // Get the member info (array)
              $member_info = $wpdb->get_results(
                  "SELECT * FROM `wp_termmeta` WHERE term_id = $loop_member_id"
              );
?>
              <tr align=center>
<?php
              // get the member type
              /* Member Types - defined in Advanced Custom Fields  - is $loop_member_type_value
                Inactive
                PMBus Adopter Company
                Full SMIF Member Company
                Tools Member
                PMBus Adopter Individual
                Full SMIF Member Individual
              */
              $loop_member_type_value = $members_list[$k]->meta_value;

              // get the Company Logo
              $loop_company_logo =
                "SELECT * FROM `wp_termmeta`
                  WHERE term_id = $loop_member_id AND
                  meta_key = 'company_logo'";

              $loop_company_logo_query = $wpdb->get_results($loop_company_logo);
              $company_logo = $loop_company_logo_query[0]->meta_value;
              $company_logo_id =  $company_logo;
              $company_logo_src = wp_get_attachment_image_src($company_logo_id,)[0];

              // get the Company Name
              $loop_company_name =
                "SELECT * FROM `wp_termmeta`
                  WHERE term_id = $loop_member_id AND
                  meta_key = 'company_display_name'";
              $loop_company_name_query = $wpdb->get_results($loop_company_name);
              $company_display_name = $loop_company_name_query[0]->meta_value;

              // build the Company internal URL from the slug
              $loop_slug = $members_list[$k]->slug;

              if ( $loop_member_type_value == "PMBus Adopter Company") {
                  // they are a PMBus Adopter or SMIF Member so get the Company Page URL
                  $company_directory_url = site_url() . '/directory/' . $loop_slug;
?>
                  <td><a href="<?= $company_directory_url ?>"><img width='100px' height='50px' src="<?=$company_logo_src ?>" alt="<?= $members_list[$k]->name ?>"/></a></td>
                  <td><a href="<?= $company_directory_url ?>"><?= $company_display_name ?></a></td>
                  <td><img width="46" height="21" src="<?= $PMBusLogo ?>" alt="<?= $loop_member_type_value ?>"/><span style="color: #6b3064; font-size:1em; font-weight:bold;">Adopter</span></td>
<?php
              } elseif ($loop_member_type_value == "Full SMIF Member Company") {
                  $company_directory_url = site_url() . '/directory/' . $loop_slug;
?>
                  <td><img width='100px' height='50px' src="<?= $company_logo_src ?>" alt="<?= $members_list[$k]->name ?>"/></td>
                  <td><?= $company_display_name ?></td>
                  <td><span style="font-weight:bold;"><?= $loop_member_type_value ?></span></td>
<?php
              } elseif ($loop_member_type_value == "Tools Member") {
                  // they are a Tools Member so get the id to anchor in the tools page Page URL
                  $tools_directory_url = site_url() . '/recources/tools/#tools-' . $loop_slug;
?>
                  <td><a href="<?= $tools_directory_url ?>"><img width='100px' height='50px' src="<?=$company_logo_src ?>" alt="<?= $members_list[$k]->name ?>"/></a></td>
                  <td><a href="<?= $tools_directory_url ?>"><?= $company_display_name ?></a></td>
                  <td><span style="font-weight:bold;"><?= $loop_member_type_value ?></span></td>
<?php          }

              // get the Company Website URL
              $loop_url =
                "SELECT * FROM `wp_termmeta`
                  WHERE term_id = $loop_member_id AND
                  meta_key = 'company_url'";
              $loop_url_query = $wpdb->get_results($loop_url);
              $company_url = $loop_url_query[0]->meta_value;
?>

              <td>
                  <a class="table_item" target="_blank" href="<?= $company_url ?>"><?= $company_url ?></a>
              </td>
<?php
              // get any additional info about PMBus Adopter company
              $loop_additional_info =
                    "SELECT * FROM `wp_termmeta`
                      WHERE term_id = $loop_member_id AND
                      meta_key = 'additional_info'";
              $loop_additional_info_query = $wpdb->get_results($loop_additional_info);
              $company_additional_info = $loop_additional_info_query[0]->meta_value;
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

<?php
  $pmbus_members_list = ob_get_clean();
  return $pmbus_members_list;
}

add_shortcode('gci_list_members', 'gci_list_members');
