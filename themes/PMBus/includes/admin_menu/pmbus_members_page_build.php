<?php

function pmbus_members_page_build() {
  ?>
  <div style='padding-right: 6%; padding-left: 3%;'>
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
      #myTable2 th {
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


    <h2 style='font-size: 2em; text-align: center;'>PMBus Member (Users) List</h2>

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
    </style>

    <input type="text" id="myInput" onkeyup="myFunction(); myFunction2()" placeholder="Search Users By Company.." title="Type in a name">
    <div class='row'>
      <div style='padding-top: 1%; background-color:#f8f8f8;'>
        <h2 style='text-align:center;'>Manage Full Members &emsp;
          <a target='_blank' href='http://pmbus.staging.wpengine.com/wp-admin/users.php?group_ids%5B0%5D=8'>
            <button class='btn_members'>PMBus Full Member Admins</button>
          </a>&emsp;
          <a target='_blank' href='http://pmbus.staging.wpengine.com/wp-admin/users.php?group_ids%5B0%5D=4'>
            <button class='btn_members'>PMBus Full Members</button>
          </a>
        </h2>

        <p>
          <table id='myTable'>
            <tr>
              <th>Company: </th>
              <th>Login: </th>
              <th  class='one'>Email: </th>
              <th  class='one'>Phone: </th>
              <th>PMBus User Type: </th>
            </tr>
            <?php
            echo do_shortcode("[groups_users_list_members group_id='8' /]");
            echo do_shortcode("[groups_users_list_members group_id='4' /]");
            ?>

          </table>
        </p>
      </div>

      <div style='padding-top: 1%; background-color:#f8f8f8;'>
        <h2 style='text-align: center;'>Manage Tools Members  &emsp; <a target='_blank' href='https://pmbus.wpengine.com/wp-admin/users.php?group_ids%5B0%5D=5'><button class='btn_members'>PMBus Tools Members</button></a></h2>
        <table id="myTable2">
          <tr>
            <th>Company: </th>
            <th>Login: </th>
            <th  class='one'>Email: </th>
            <th  class='one'>Phone: </th>
            <th>PMBus User Type: </th>
          </tr>
          <?php
          echo do_shortcode("[groups_users_list_members group_id='5' /]");
          ?>
        </table></p>
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
      function myFunction2() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable2");
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
  </div>
  <?php
}
