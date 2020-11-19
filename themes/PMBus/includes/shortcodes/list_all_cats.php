<?php
function gci_list_all_cats(){

  $gci_category_contents = '';

  ob_start();
  ?>

  <div>
    <br><?php

    //print all categories and cubcategories
    $args = array(
      'taxonomy' => 'product_cat',
      'hide_empty' => false,
      'parent'   => 0
    );

    $product_cat = get_terms( $args );

    foreach ($product_cat as $parent_product_cat)
    {
      if ($parent_product_cat->name != 'Company' && $parent_product_cat->name != 'Uncategorized' && $parent_product_cat->name != 'Misc' && $parent_product_cat->name != 'product_cat'){
      ?>

        <ul>
          <style>
            li{
              list-style:none;
              background-image:none;
              background-repeat:none;
              background-position:0;
            }
          </style>
          <li><h2><?= $parent_product_cat->name ?></h2>
            <hr align='left' width='50%'><br>

            <ul>

              <?php
              $child_args = array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'parent'   => $parent_product_cat->term_id
              );

              $child_product_cats = get_terms( $child_args );
              foreach ($child_product_cats as $child_product_cat)
              {?>
                <li>
                  <h3><a href='<?= get_term_link($child_product_cat->term_id) ?>'><?= $child_product_cat->name?></a></h3>
                </li>
                <?php
              }
              ?>

            </ul>
          </li>
        </ul>

      <?php
      }
    } ?>
  </div>
  <?php
  $gci_category_contents = ob_get_clean();
  return $gci_category_contents;

  }

add_shortcode('list_all_cats', 'gci_list_all_cats');
