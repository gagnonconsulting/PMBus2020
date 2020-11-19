<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

defined( 'ABSPATH' ) || exit;
get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
$page_title = woocommerce_page_title(false);

global $wpdb;
$tableTitle = $wpdb->get_results(
"
SELECT slug FROM `wp_terms` WHERE name = '$page_title'
"
);

$page_title = $tableTitle[0]->slug;

?>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title() ?></h1>
	<?php
	$GLOBALS['gci_table_name'] = $page_title;


		endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
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
			var c = table.querySelectorAll("div.comUp");
	    c[0].style.display="inline";
	    var d = table.querySelectorAll("div.comDown");
	    d[0].style.display="inline";
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
<?php

if ( have_posts() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked wc_print_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
