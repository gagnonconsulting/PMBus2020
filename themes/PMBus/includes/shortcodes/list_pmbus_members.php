<?php
function list_pmbus_members() {

  $pmbus_members_list='';

  ob_start();
  global $wpdb;
  ?>
  <div class='one' style='background-image:url(""); background-size:94%;'>
    <h2>PMBus&reg Member Directory</h2>
  </div>
  <div class='two' style='background-size:94%;'>
    <center><h2>PMBus Members</h2></center>
  </div><br><br>

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
        cursor: pointer;
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
          <table id='myTable' class='sortable'>
            <thead>
              <th class="table_ref">PMBus Member: </th>
              <th class="table_ref">Membership Type:</th>
              <th class="table_ref"><center>SMIF Page:</center></th>
            </thead>
            <tbody id="people">
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
                  if($loop_query[0]->option_value != 'SMIF Tools Member'){
                    $member_url = '<center><a class="table_item" target="_blank" href="http://pmbus.staging.wpengine.com/' . $members_list[$k]->slug . '">PMBus page</a></center>';
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

    const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

    const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
        v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
        )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

    // do the work...
    document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
        const table = th.closest('table');
        Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
            .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
            .forEach(tr => table.appendChild(tr) );
    })));
  </script>

  <?php
  $pmbus_members_list = ob_get_clean();
  return $pmbus_members_list;
}
add_shortcode('list_members', 'list_pmbus_members');
