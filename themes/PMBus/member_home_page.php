<?php
/*
Template Name: Member Home Page
*/

get_header();
$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );
?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
				<?php

				while ( have_posts() ) : the_post();

					$post_id = get_the_ID();
					//echo "post_id = ".$post_id;
					?>
					<article id="post-<?$post_id; ?>" <?php post_class(); ?>>
					<?php //if ( ! $is_page_builder_used ) : ?>
					<?php if (  $is_page_builder_used ) : ?>


<?
						$tax = get_taxonomy( 'companies' );
						?><PRE><?
						//print_r( $tax );
						?></PRE>

						<? // get the current taxonomy term
						$term = get_term('companies_company_logo');
						$company_logo = get_field('company_logo', $term->taxonomy . '_' . $term->term_id);

						$image_logo = get_field('companies_company_logo', $term);
						$image = wp_get_attachment_image_src(get_field('$image_logo'), 'full');
						?>
					  <img src="<?php echo $image[0]; ?>" alt="<?= $image ?>" />
						<?php


						$thumb = '';

						$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

						$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
						$classtext = 'et_featured_image';
						$titletext = get_the_title();
						$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
						$thumb = $thumbnail["thumb"];

						if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
							print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
						endif;


						?>
						<div style='border:solid 0px black; height:300px; background-image:url("http://pmbus.staging.wpengine.com/wp-content/uploads/2018/08/wave-graphic.jpg");'>
							<h1 class="entry-title main_title">
							<?
							// get featured image PUT BACK IF WANTING TO USE FEATURED IMAGE INSTEAD OF LARGE LOGO
							echo get_the_post_thumbnail($post_id, 'thumbnail', array( 'class' => 'alignright' ) );
							the_title();
							?>
							</h1>
							<? //var_dump (the_field('company_logo_large')); ?>


							<? the_content(); ?>

						</div>


						<div class="entry-content">
							<!-- pad content -->
							<div style='padding-top:2%;'>

								<?php
								function GetImageUrlsByProductId( $productId){

									$product = new WC_product($productId);
									$attachmentIds = $product->get_gallery_attachment_ids();
									$imgUrls = array();
									foreach( $attachmentIds as $attachmentId )
									{
										$imgUrls[] = wp_get_attachment_url( $attachmentId );
									}

									return $imgUrls;
								}

								GetImageUrlsByProductId( 2330 );

								//build table based on the input of custom field 'Company' in dashboard

								// ------>
								//Note TO DO - Automate product category 'company' to generate from the page's Company Taxonomy
								// ------>
								//echo "<h4>".$post->ID."</h4>";
//$myvals = get_post_meta($post->ID);
//foreach($myvals as $key=>$val) {
//    echo $key . ' : ' . $val[0] . '<br/>';
//}

//echo "<h2>Listing of Products here</h2>";
								$company_custom_field = get_post_meta($post->ID, 'Company', true);
								//echo "company_custom_field= ".$company_custom_field;
								?>
							</div>
							<?php

							global $wpdb;
							//-----------Check current custom company field value ******* V
							//echo (get_post_meta($post->ID, 'Company', true));

							$gci_company_id_query = $wpdb->get_results(
								"SELECT DISTINCT term_id FROM wp_terms WHERE slug = '$company_custom_field'");

							$gci_company_slug_query = $wpdb->get_results(
								"SELECT * FROM wp_terms WHERE slug = '$company_custom_field'");
							//echo ("<h2>company_custom_field = " . $company_custom_field . "</h2>");

							$gci_company_slug = $gci_company_slug_query->slug;
							//echo ("<h2>gci_company_slug_query = " . $gci_company_slug_query . "<h2>");
							//var_dump ($gci_company_slug_query);
//echo "<h3>$gci_company_slug: ".$gci_company_slug."</h3>";
							$gci_company_product_list_for_page = $wpdb->get_results(
								"select * from wp_terms t, wp_term_relationships r where t.slug = '$company_custom_field' AND
									r.term_taxonomy_id = t.term_id");

							if($gci_company_product_list_for_page == null){
								//echo "<h4 style='text-align:center'><hr><em>No PMBus products have been submitted for display here.</em></h4>";
							}
							else{
								$gci_company_id = $gci_company_id_query[0]->term_id;
							?>
							<br>
							<div style="padding-left:10%; padding-bottom:5%; padding-right:10%">
								<?php

								$woo_commerce_company = $wpdb->get_results("
								SELECT * FROM `wp_terms` WHERE name = 'Company'
								");
								$woo_commerce_company_id = $woo_commerce_company[0]->term_id;
								$gci_featured_products = $wpdb->get_results("
									SELECT * FROM
											(
												SELECT company.object_id, name, slug, parent, terms.term_id FROM
												(SELECT * FROM wp_term_relationships r WHERE r.term_taxonomy_id =".$gci_company_id.") AS company,
												(SELECT * FROM wp_term_relationships r1) AS category,
												(SELECT * FROM wp_terms) AS terms,
												(SELECT * FROM wp_term_taxonomy) AS taxonomy
												WHERE company.object_id = category.object_id AND terms.term_id = category.term_taxonomy_id
												AND terms.slug NOT LIKE 'http%' AND terms.name != 'simple'
												AND terms.slug NOT LIKE 'Company' AND terms.slug NOT LIKE 'company-%'
												AND terms.name = 'featured'
												AND taxonomy.taxonomy NOT LIKE 'pa_company' AND parent != 0
											) as categories
                                            WHERE parent=".$woo_commerce_company_id."
                                            GROUP BY object_id
									");
										if($gci_featured_products != null){ ?>
											<h1>Featured Products</h1><br> <?php
											echo do_shortcode('[products limit="4" category="'.$company_custom_field.'" visibility="featured"]');
										}?>
							</div>
							<?php


							$parent = $wpdb->get_results(
								"
									SELECT * FROM
									(
										SELECT company.object_id, name, slug, parent, terms.term_id FROM
										(SELECT * FROM wp_term_relationships r WHERE r.term_taxonomy_id = " . $gci_company_id . ") AS company,
										(SELECT * FROM wp_term_relationships r1) AS category,
										(SELECT * FROM wp_terms) AS terms,
										(SELECT * FROM wp_term_taxonomy WHERE taxonomy != 'pa_product_link') AS taxonomy
										WHERE company.object_id = category.object_id AND terms.term_id = category.term_taxonomy_id
										AND terms.slug NOT LIKE 'http%' AND terms.name != 'simple'
										AND terms.slug NOT LIKE 'Company' AND terms.slug NOT LIKE 'company-%'
										AND terms.name != 'featured' AND taxonomy.term_taxonomy_id = terms.term_id
										AND taxonomy.taxonomy NOT LIKE 'pa_company'
									) as categories
									WHERE parent = 0 AND slug != 'generic'
									GROUP BY name
								"
							);



							for ($pa = 0; $pa < count($parent); $pa++) {
								$parent_loop_id = $parent[$pa]->term_id;
								$categories = get_term_children( $parent_loop_id, 'product_cat' );


								?>
								<div style='padding-left:10%; padding-right:10%;'>
									<p><?php  if($categories[0] != null){ ?>
										<h1 style='color:#5C2961'><?= $parent[$pa]->name ?></h1>
										<hr style="color:#5C2961" width="30%" align="left">
									<?php } ?>
									</p>

									<?php
									$gci_company_products_query = $wpdb->get_results(
									"
										SELECT * FROM
										(
											SELECT company.object_id, name, slug, parent, terms.term_id FROM
											(SELECT * FROM wp_term_relationships r WHERE r.term_taxonomy_id = " . $gci_company_id . ") AS company,
											(SELECT * FROM wp_term_relationships r1) AS category,
											(SELECT * FROM wp_terms) AS terms,
											(SELECT * FROM wp_term_taxonomy) AS taxonomy
											WHERE company.object_id = category.object_id AND terms.term_id = category.term_taxonomy_id
											AND terms.slug NOT LIKE 'http%' AND terms.name != 'simple'
											AND terms.slug NOT LIKE 'Company' AND terms.slug NOT LIKE 'company-%'
											AND terms.name != 'featured' AND taxonomy.term_taxonomy_id = terms.term_id
											AND taxonomy.taxonomy NOT LIKE 'pa_company'
										) as categories
										WHERE parent = ".$parent_loop_id."
										GROUP BY name
									"
									);

									for ($i = 0; $i < count($gci_company_products_query); $i++) {
										?>

										<h2 style='color:#013087'><?= $gci_company_products_query[$i]->name ?></h2>

										<?php

										// Setting the member's product table ID within the loop
										$gci_table_name = $gci_company_products_query[$i]->name;
										$gci_table_name = preg_replace('/\s+/', '_', $gci_table_name);?><br><?php


										$cat_id = $gci_company_products_query[$i]->term_id;
										$pq = $wpdb->get_results(
										"
											SELECT * FROM
											(
												SELECT company.object_id, name, slug, parent, terms.term_id FROM
												(SELECT * FROM wp_term_relationships r WHERE r.term_taxonomy_id = " . $gci_company_id . ") AS company,
												(SELECT * FROM wp_term_relationships r1) AS category,
												(SELECT * FROM wp_terms) AS terms,
												(SELECT * FROM wp_term_taxonomy) AS taxonomy
												WHERE company.object_id = category.object_id AND terms.term_id = category.term_taxonomy_id
												AND terms.slug NOT LIKE 'http%' AND terms.name != 'simple'
												AND terms.slug NOT LIKE 'Company' AND terms.slug NOT LIKE 'company-%'
												AND terms.name != 'featured' AND taxonomy.term_taxonomy_id = terms.term_id
												AND taxonomy.taxonomy NOT LIKE 'pa_company' AND parent != 0
											) as categories
											WHERE term_id = " . $cat_id . "
										"
										);
//echo $cat_id ." - ";
										//Child Category Loop Run list of product IDs variable
										$pid = '';
										//Running through array of products in child category and adding IDs $pid seperated by a comma
										for ($k = 0; $k < count($pq); $k++) {
											$product_loop_id = $pq[$k]->object_id;
											$pid = $pid . $product_loop_id . ', ';
											//echo $pid;
										}
										//Trimming the last comma in the $pid variable
										$p2id = rtrim($pid,", ");
										//Running shop loop based on IDs variable and retrieving products in child category
										$_POST['term_id'] = $cat_id;
										echo do_shortcode("[products ids='$p2id']");

										?>

										<?php

									}
									?>

								</div>

								<?php


								continue;
							}
						}
						?>
					</article> <!-- .et_pb_post -->
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
