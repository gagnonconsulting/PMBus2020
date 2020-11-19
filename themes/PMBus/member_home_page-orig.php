<?php
/*
Template Name: Member Home Page
*/

get_header();
$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );
//echo "page_build_used = ".$is_page_builder_used;
?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
				<?php
				while ( have_posts() ) : the_post();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php //if ( ! $is_page_builder_used ) : ?>
					<?php //if (  $is_page_builder_used ) :
?>

						<?php
						$thumb = '';

						$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

						$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
						$classtext = 'et_featured_image';
						$titletext = get_the_title();
						$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
						$thumb = $thumbnail["thumb"];


					<?php
				endwhile;
				?>

			</div> <!-- #left-area -->
			<?php
			//get_sidebar();
			?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
	<script type="text/javascript">

	function sortTable(n, table) {

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

					//DECENDING BREAK

	        switching = true;
	      }
	    }
	  }

		//Product ID Sort
		if(n == 2){
			if (dir == "asc") {
				var c = table.querySelectorAll("div.IdUp");
		    c[0].style.display="inline";
		    var d = table.querySelectorAll("div.IdDown");
		    d[0].style.display="none";
				var c1 = table.querySelectorAll("div.comUp");
		    c1[0].style.display="inline";
		    var d1 = table.querySelectorAll("div.comDown");
		    d1[0].style.display="inline";
				var x = table.querySelectorAll("div.powUp");
		    x[0].style.display="none";
			}
			if (dir == "desc") {
				var c = table.querySelectorAll("div.IdUp");
		    c[0].style.display="none";
		    var d = table.querySelectorAll("div.IdDown");
		    d[0].style.display="inline";
				var c = table.querySelectorAll("div.comUp");
		    c[0].style.display="inline";
		    var d = table.querySelectorAll("div.comDown");
		    d[0].style.display="inline";
				var x = table.querySelectorAll("div.powUp");
		    x[0].style.display="none";
			}
		}

		//Comapany Sort
		if(n == 1){
			if (dir == "asc") {
				var c = table.querySelectorAll("div.comUp");
		    c[0].style.display="inline";
		    var d = table.querySelectorAll("div.comDown");
		    d[0].style.display="none";
				var c = table.querySelectorAll("div.IdUp");
		    c[0].style.display="inline";
		    var d = table.querySelectorAll("div.IdDown");
		    d[0].style.display="inline";
			}
			if (dir == "desc") {
				var c = table.querySelectorAll("div.comUp");
		    c[0].style.display="none";
		    var d = table.querySelectorAll("div.comDown");
		    d[0].style.display="inline";
				var c = table.querySelectorAll("div.IdUp");
		    c[0].style.display="inline";
		    var d = table.querySelectorAll("div.IdDown");
		    d[0].style.display="inline";
			}
		}

	}

	</script>

</div> <!-- #main-content -->

<?php
get_footer();
