<?php

function gci_show_product_info() {
  //$id = get_the_ID();
  //var_dump(get_post($id));
  global $product;
  $id = $product->get_id();

  //get whether product or company type listing
  $listing_type = $_POST['listing_type'];
  //echo "<h2>In show_products_callback - ".$listing_type."</h2>";

  $nanProductTableLocal = $GLOBALS['nanProductTable'];
  $phaseProductTablesLocal = $GLOBALS['phaseProductTables'];
  $outputProductTablesLocal = $GLOBALS['outputProductTables'];

  $table_id = $GLOBALS['gci_table_name'];
  $localTableId = '</a>' . $table_id . '<a>';

  $url = $product->get_attribute( 'pa_product_link' );
  $clickable_url = "<a style='color: #632262 !important;' target='_blank' href='".$url."'>Visit</a>";
  $company = $product->get_attribute( 'pa_company' );
  // the following does not work as $company is not the same as $slug - it is the actual name with caps an spaces
  $company_directory_url = site_url() . '/directory/' . $company;


  $product_cats = wp_get_post_terms( $id, 'product_cat' );
  //$no_img_src = bloginfo('stylesheet_directory');
  $no_img_src = "/wp-content/uploads/2019/08/no-image-available-150x75.png";
  // If Products by Company
  if ($listing_type == 'company') {
      ?>

      <tr>
        <!-- <td class='gci-product-table-td gci_hide'> -->
        <!-- </td> -->

        <td class='gci-product-table-td gci_hide'>
          <pre><?  //print_r ($product_cats); ?></pre>
          <?php
          foreach ($product_cats as $product_cat) {
              // get the name of the top level parent product category
            if ($product_cat->parent == 0 && $product_cat->slug != 'company' &&
                  $product_cat->name != 'Uncategorized' && $product_cat->name != 'Misc' &&
                  $product_cat->name != 'product_cat') {
                    echo ("<div style='padding-bottom:8px;'>".$product_cat->name."");
                    // get the name of the associated product sub-category
                    $child_product_cats = wp_get_post_terms( $id, 'product_cat' );
                    foreach ($child_product_cats as $child_product_cat) {
                      if (($child_product_cat->parent != 0) && (substr($child_product_cat->slug, 0,8) !== 'company-')) {
                        //echo ("<a href='#');
                        echo ("<span style='font-weight:bold;'> <br/>".$child_product_cat->name."</span></div>");
                        //echo ("</a><br>");
                    }
                }
            }
        }
        ?>
        </td>

        <td class='gci-product-table-td'>
          <?php if($url !== ''){?><a target="_blank" href="<?php echo $url ?>"><?php }?>
            <?php echo get_the_title(); ?><?php if($url !== ''){?></a><?php } ?>
        </td>

        <td class='gci-product-table-td gci_hide' style='padding-left:4px;padding-right:4px;'>
          <?php echo get_the_excerpt(); ?>
        </td>
        <td class='gci-product-table-td'>
            <?php
          if ( has_post_thumbnail() ) {
            echo get_the_post_thumbnail();
          } else {
              echo "<div style='padding:15px;font-size:1.0em;font-weight:normal;' class='gci_product_table_cell-company-name'>";
              // do not show the image if not available
              //echo "<img src='" . $no_img_src ."' width:175px; height:50px;'>";
              echo "</div>";
          }
          ?>
        </td>

      </tr> <?php
  } elseif (in_array($localTableId, $nanProductTableLocal)) {
    //echo $localTableId . ' does not have power or voltage because it is on the array in /product_tables/dynamic_table_display.php<br>';
    ?>

    <tr>
      <!-- <td class='gci-product-table-td gci_hide'> -->
      <!-- </td> -->

      <td class='gci-product-table-td'>
        <?php
        //echo "<div style='font-weight:bold; padding-top:4px;'><a href='#'>".$company_directory_url."</a></div>";
        echo "<div style='font-weight:bold; padding-top:4px;'>$company</div>";
        if ( has_post_thumbnail() ) {
          echo get_the_post_thumbnail();
        } else {
          //echo "<div style='padding:15px;font-size:1.3em;font-weight:bold;' class='gci_product_table_cell-company-name'>".$product->get_attribute( 'pa_company' )."</div>";
          echo "<div style='padding:15px;font-size:1.0em;font-weight:normal;' class='gci_product_table_cell-company-name'>";
          echo "<img src='" . $no_img_src ."'";
          echo " width:'175px' height:'50px'></div>";
        }
        ?>
      </td>

      <td class='gci-product-table-td'>
        <?php if($url !== ''){?><a target="_blank" href="<?php echo $url ?>"><?php }?>
          <?php echo get_the_title(); ?><?php if($url !== ''){?></a><?php } ?>
      </td>

      <td class='gci-product-table-td gci_hide'>
        <?php echo get_the_excerpt(); ?>
      </td>

    </tr> <?php
  }

  elseif (in_array($localTableId, $phaseProductTablesLocal)) {
    ?>

    <tr>
      <!-- <td class='gci-product-table-td gci_hide'> -->
      <!-- </td> -->

      <td class='gci-product-table-td'>
        <?php
        echo "<div style='font-weight:bold; padding-top:4px;'>".$company."</div>";
        if ( has_post_thumbnail() ) {
          echo get_the_post_thumbnail();
        } else {
          echo "<div style='padding:15px;font-size:1.0em;font-weight:normal;' class='gci_product_table_cell-company-name'>";
          echo "<img src='" . $no_img_src ."'";
          echo " width:'175px' height:'50px'></div>";
        }
        ?>
      </td>

      <td class='gci-product-table-td'>
        <a target="_blank" href="<?php echo $url ?>"><?php echo get_the_title(); ?></a>
      </td>

      <td class='gci-product-table-td gci_hide'>
        <?php echo get_the_excerpt(); ?>
      </td>

      <td class='gci-product-table-td gci_hide'>
        <?php
        if ($product->get_attribute( 'pa_phase-channel' ) == '') {
          echo "-";
        } else {
          echo $product->get_attribute( 'pa_phase-channel' );
        }
        ?>
      </td>

    </tr> <?php
  }

  elseif (in_array($localTableId, $outputProductTablesLocal)) {
    ?>

    <tr>
      <!-- <td class='gci-product-table-td gci_hide'> -->
        <center><?php  ?></center>
      <!-- </td> -->

      <td class='gci-product-table-td'>
        <?php
        echo "<div style='font-weight:bold; padding-top:4px;'><a href='#'>".$company."</a></div>";
        if ( has_post_thumbnail() ) {
          echo get_the_post_thumbnail();
        } else {
          echo "<div style='padding:15px;font-size:1.0em;font-weight:normal;' class='gci_product_table_cell-company-name'>";
          echo "<img src='" . $no_img_src ."'";
          echo " width:'175px' height:'50px'></div>";
        }
        ?>
      </td>

      <td class='gci-product-table-td'>
        <a target="_blank" href="<?php echo $url ?>"><?php echo get_the_title(); ?></a>
      </td>

      <td class='gci-product-table-td gci_hide'>
        <?php echo get_the_excerpt(); ?>
      </td>

      <td class='gci-product-table-td gci_hide'>
        <?php
        if ($product->get_attribute( 'pa_phase-channel' ) == '') {
          echo "-";
        } else {
          echo $product->get_attribute( 'pa_phase-channel' );
        }
        ?>
      </td>

      <td class='gci-product-table-td gci_hide'>
        <?php
        if ($product->get_attribute( 'pa_num-outputs' ) == '') {
          echo "-";
        } else {
          echo $product->get_attribute( 'pa_num-outputs' );
        }
        ?>
      </td>

    </tr> <?php
  }

  //Table has Power min, max, units, voltage max, min and units
  else {
  ?>
    <tr>
      <!-- <td class='gci-product-table-td gci_hide'> -->
      <!-- </td> -->

      <td class='gci-product-table-td'>
        <?php
        echo "<div style='font-weight:bold; padding-top:4px;'>".$company."</div>";
        if ( has_post_thumbnail() ) {
          echo get_the_post_thumbnail();
        } else {
          echo "<div style='padding:15px;font-size:1.0em;font-weight:normal;' class='gci_product_table_cell-company-name'>";
          echo "<img src='" . $no_img_src ."'";
          echo " width:'175px' height:'50px'></div>";
        }
        ?>
      </td>

      <td class='gci-product-table-td'>
        <a target="_blank" href="<?php echo $url ?>"><?php echo get_the_title(); ?></a>
      </td>

      <td class='gci-product-table-td gci_hide'>
        <?php echo get_the_excerpt(); ?>
      </td>

      <td style='border-right: 1px solid white; text-align: right; padding:0px'
        class='gci-product-table-td' style="text-align: right;">
        <?php
        if ($product->get_attribute( 'pa_power-rating-min' ) == '') {
          echo "-";
        } else {
          echo $product->get_attribute( 'pa_power-rating-min' );
        }

        ?>
      </td>

      <td style='border-right: 1px solid white; text-align: right; padding:0px'
        class='gci-product-table-td testClass'>
        <?php
        if ($product->get_attribute( 'pa_power-rating-max' ) == '') {
          echo "-";
        } else {
          echo $product->get_attribute( 'pa_power-rating-max' );
        }
        ?>
      </td>

      <td style="font-size:.8em;" class='gci-product-table-td'>
        <?php echo $product->get_attribute( 'pa_power-rating-units' ); ?>
      </td>

      <td style='border-right: 1px solid white; text-align: right;'
        class='gci-product-table-td' style='text-align: right; padding:0px'>
        <?php
        if ($product->get_attribute( 'pa_input-voltage-min' ) == '') {
          echo "-";
        } else {
          echo $product->get_attribute( 'pa_input-voltage-min' );
        }
        ?>
      </td>

      <td style='border-right: 1px solid white; text-align: right;'
        class='gci-product-table-td' style='text-align: right; padding:0px'>
        <?php
        if ($product->get_attribute( 'pa_input-voltage-max' ) == '') {
          echo "-";
        } else {
          echo $product->get_attribute( 'pa_input-voltage-max' );
        }
        ?>
      </td>

      <td style="font-size:.8em" class='gci-product-table-td'>
        <?php echo $product->get_attribute( 'pa_input-voltage-units' ); ?>
      </td>

    </tr>
  <?php
  }

}
?>
<?php
