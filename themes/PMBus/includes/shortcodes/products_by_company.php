<?php
function list_pmbus_adopters() {

  $pmbus_members_list='';

  ob_start();
  global $wpdb;
  ?>
  <div class='one' style='background-image:url(""); background-size:100%;'>
    <h2>PMBus® SMIF Page Directory</h2>
    <h5> (For a list of all SMIF member companies, see the <a class="table_item" style="text-decoration: underline" href='http://pmbus.staging.wpengine.com/members-directory/'>SMIF Members List</a>)</h5>
  </div>
  <div class='two' style='background-size:100%;'>
    <center><h2 >PMBus Members</h2></center>
  </div><br><br>

  <div>



    <?php
    $members_list = $wpdb->get_results(
      "
        SELECT * FROM wp_term_taxonomy as tx, wp_terms tm
        WHERE tx.taxonomy = 'companies' AND tm.term_id = tx.term_taxonomy_id
        GROUP BY name;
      "
    );
    ?>
    <pre><?php // print_r($members_list) ?></pre>
    <?php
    $member_data = get_userdata( $custom_term_meta[734] );
    echo $member_data;
    $terms = get_terms( array(
      'taxonomy' => 'companies',
      'hide_empty' => false,
    ) );
    ?>


    <input type="text" id="myInput" onkeyup="myFunction();" placeholder="Search Members By Company Name.." title="Type in a name">
    <div class='row'>
      <div>
          <h1><?php get_field('membership_type', 810); ?></h1>
          <table id='myTable'>
            <tr>
              <th class="table_ref">PMBus Member: </th>
              <th class="table_ref" style="width:30%;">Additional Info:</th>
              <th class="table_ref">SMIF Page:</th>
            </tr>
            <?php
            for($k=0; $k<count($members_list); $k++){
              ?>
              <tr>
                <?php
                $loop_member_id = $members_list[$k]->term_id;

                $loop_url =
                  "
                  SELECT * FROM `wp_options`
                  WHERE option_name = 'companies_";
                  $loop_url .= $loop_member_id;
                  $loop_url .=  "_company_website_url'
                  ";
                  $loop_url_query = $wpdb->get_results($loop_url);
                $companies_url = $loop_url_query[0]->option_value;

                $loop_info =
                  "
                  SELECT * FROM `wp_options`
                  WHERE option_name = 'companies_";
                  $loop_info .= $loop_member_id;
                  $loop_info .=  "_additional_information'
                  ";
                $loop_info_query = $wpdb->get_results($loop_info);

                $loop_member =
                  "
                  SELECT * FROM `wp_options`
                  WHERE option_name = 'companies_";
                  $loop_member .= $loop_member_id;
                  $loop_member .=  "_membership_type'
                  ";
                $loop_query = $wpdb->get_results($loop_member);

                if(($loop_query[0]->option_value == 'PMBus Adopter') or ($loop_query[0]->option_value == 'SMIF Full Member')){
                  ?>
                  <td><a class="table_item" target='_blank' href='<?= $companies_url ?>'><?= $members_list[$k]->name; ?></a></td>
                  <td><?= $loop_info_query[0]->option_value;?></td>
                  <?php
                  if($loop_query[0]->option_value != 'SMIF Tools Member'){
                    $member_url = '<center><a class="table_item" target="_blank" href="http://pmbus.staging.wpengine.com/' . $members_list[$k]->slug . '">PMBus page</a></center>';
                    ?>
                    <td><?= $member_url; ?></td><?php
                  }
                  else { ?>
                    <td><center>N/A</center></td><?php
                  }
                } ?>
              </tr>
              <?php
            }
            //echo do_shortcode("[groups_users_list_members group_id='8' /]");
            //echo do_shortcode("[groups_users_list_members group_id='4' /]");
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

  <style>
    * {
      box-sizing: border-box;
    }

    #myInput {
      background-position: 10px 10px;
      background-repeat: no-repeat;
      width: 100%;
      padding: 12px 20px 12px 40px;
      border: 1px solid #ddd;
      margin-bottom: 12px;
    }

    #myTable {
      border-collapse: collapse;
      width: 100%;
      border: 1px solid #ddd;
    }

    #myTable th, #myTable td {
      text-align: left;
      padding: 12px;
    }

    #myTable th {
      background-color: #6b3064;
      color: white;
    }

    #myTable tr {
      border-bottom: 1px solid #ddd;
    }

    #myTable tr.header, #myTable tr:hover {
      background-color: #f1f1f1;
    }
  </style>


  <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td, th {
      border: 1px solid #d3d3d3;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #d7d7d7;
    }

    .btn_members {
      -webkit-border-radius: 0;
      -moz-border-radius: 0;
      border-radius: 0px;
      font-family: Arial;
      color: #ffffff;
      background: #692f68;
      padding: 10px 20px 10px 20px;
      text-decoration: none;
      font-size: .7em;
    }

    .btn_members:hover {
      background: #F18631;
      text-decoration: none;
    }

    @media only screen and (max-width: 900px) {
      .one{
        display: none;
      }
    }

    @media only screen and (min-width: 900px) {
      .two{
        display: none;
      }
    }

  </style>

  <?php
  $pmbus_members_list = ob_get_clean();
  return $pmbus_members_list;
}
add_shortcode('list_product_pages', 'list_pmbus_adopters');
