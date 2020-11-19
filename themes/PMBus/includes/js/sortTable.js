function sortTable(n, table) {

console.log ("in sortTable");

  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById(table);
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
      //console.log ("i="+i+" n="+n+" x="+(x.innerText.toLowerCase() || x.textContent.toLowerCase())+" y="+(y.innerText.toLowerCase() || y.textContent.toLowerCase()));
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
          if ((x.innerText.toLowerCase() || x.textContent.toLowerCase()) > (y.innerText.toLowerCase() || y.textContent.toLowerCase())) {
            //if so, mark as a switch and break the loop:
            shouldSwitch= true;
            //console.log ("asc Should switch");
            break;
          }
        } else if (dir == "desc") {
          if ((x.innerText.toLowerCase() || x.textContent.toLowerCase()) < (y.innerText.toLowerCase() || y.textContent.toLowerCase())) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            //console.log ("desc Should switch");
            break;

          }
        }
      }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //console.log("asc switching");
      //Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        //DECENDING BREAK
        switching = true;
        console.log("desc switching");

      }
    }
  }
  //console.log ("Done switching");

}

function sortTableNum(n, table) {

  console.log ("in sortTableNum");

  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById(table);
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
      //console.log ('x='+x+' y='+y);
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      //console.log ("i="+i+" n="+n+" x="+(x.innerText || x.textContent)+" y="+(y.innerText || y.textContent));

      var a, b;

      if ((x.innerText || x.textContent) == '-') {
        a = -1;
      }
      else {
        a = parseFloat(x.innerHTML);
      }

      if ((y.innerText || y.textContent) == '-') {
        b = -1;
      }
      else {
        b = parseFloat(y.innerHTML);
      }
//console.log ("a="+a+" b="+b);


      if (dir == "asc") {
        if (a > b) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          //rows[0].getElementsByTagName("TH")[n].innerHTML("&#9650;");

          break;
        }
      }
      else if (dir == "desc") {
          if (a < b) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            //rows[0].getElementsByTagName("TH")[n].innerHTML("&#9660;");

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

        //DECENDING BREAK

        switching = true;
      }
    }
  }

}
