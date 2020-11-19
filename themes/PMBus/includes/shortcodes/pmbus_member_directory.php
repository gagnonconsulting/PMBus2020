<?php
function tyler_pmbus_members_directory() {

  $pmbus_members_list='';

  ob_start();
  global $wpdb;
  ?>
  <div class='one' style='background-image:url(""); background-size:94%;'>
    <h2>PMBus&reg Member Directory</h2>
  </div>
  <div class='two' style='background-size:94%;'>
    <center><h2>PMBus Members</h2></center>
  </div>

  <div style=''>

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

      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      td, th {
        border: 1px solid #d3d3d3;
        text-align: left;
        padding: 4px;
      }

      tr:nth-child(even) {

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
            <thead>
              <th class="table_ref">PMBus Member: <span style="font-size:0.8em;font-weight:normal;"><br>click to visit company site</span></th>
              <th class="table_ref">Membership Type:</th>
              <th class="table_ref"><center>SMIF Page:</center></th>
            </thead>
            <tbody>
            <?php
            for($k=0; $k<count($members_list); $k++){
              if($loop_query[0]->option_value != 'Drafted Member'){
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

                  if($companies_url !== ''){ ?>
                    <td><a class="table_item" target='_blank' href='<?= $companies_url ?>'><?= $members_list[$k]->name; ?></a></td> <?php
                  }

                  else { ?>
                    <td><?= $members_list[$k]->name; ?></td> <?php
                  }

                  $loop_member =
                  "
                  SELECT * FROM `wp_options`
                  WHERE option_name = 'companies_";
                  $loop_member .= $loop_member_id;
                  $loop_member .=  "_membership_type'
                  ";
                  $loop_query = $wpdb->get_results($loop_member);
                  ?><pre><?php // print_r($loop_query); ?></pre>

                  <td><?= $loop_query[0]->option_value; ?></td>

                  <?php

                  $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    							$arr = explode("/", $url, 2);
    							$first = $arr[0];

                  if($loop_query[0]->option_value != 'SMIF Tools Member'){
                    $member_url = '<center><a class="table_item" target="_blank" href="http://' . $first . '/' . $members_list[$k]->slug . '">PMBus page</a></center>';
                    ?>
                    <td><?= $member_url; ?></td><?php
                  }
                  else { ?>
                    <td><a style="color: #5E2663" href="http://pmbus.staging.wpengine.com/resources/tools/"><center><em><strong>Tools page</em></strong></center></a></td><?php
                  }
                  ?>

                </tr>
              <?php
              }
            }
            //echo do_shortcode("[groups_users_list_members group_id='8' /]");
            //echo do_shortcode("[groups_users_list_members group_id='4' /]");
            ?>
          </tbody>
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

    function sortTable(n) {
      var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      table = document.getElementById("myTable");
      switching = true;
      //Set the sorting direction to ascending:
      dir = "asc";
      /*Make a loop that will continue until
      no switching has been done:*/
      while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
          //start by saying there should be no switching:
          shouldSwitch = false;
          /*Get the two elements you want to compare,
          one from current row and one from the next:*/
          x = rows[i].getElementsByTagName("TD")[n];
          y = rows[i + 1].getElementsByTagName("TD")[n];
          /*check if the two rows should switch place,
          based on the direction, asc or desc:*/
          if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              //if so, mark as a switch and break the loop:
              shouldSwitch= true;
              break;
            }
          } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              //if so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          }
        }
        if (shouldSwitch) {
          /*If a switch has been marked, make the switch
          and mark that a switch has been done:*/
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          //Each time a switch is done, increase this count by 1:
          switchcount ++;
        } else {
          /*If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again.*/
          if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
          }
        }
      }
    }


  </script>

  <?php
  $pmbus_members_list = ob_get_clean();
  return $pmbus_members_list;
}
add_shortcode('pmbus_members_directory_tyler', 'tyler_pmbus_members_directory');
