<?php
function create_woo_product_cat() {

  global $wpdb;
  // Pulls all woocommerce Company Product Categories
  $companies = $wpdb->get_results(
    "
    SELECT slug FROM `wp_terms` t, `wp_term_taxonomy` x
    WHERE x.term_taxonomy_id = t.term_id
    AND taxonomy = 'companies'
    GROUP BY name
    "
  );

  $woo_products = $wpdb->get_results(
    "
    SELECT * FROM `wp_terms` r, wp_term_taxonomy tx
    WHERE tx.parent = 667 and tx.taxonomy = 'product_cat'
    AND tx.term_taxonomy_id = r.term_id
    GROUP BY name
    "
  );
  ?>
  <pre><?php // print_r($woo_products); ?></pre>
  <?php

  // Select all Companies taxonomy terms

  ?>
  <pre><?php // print_r($companies); ?></pre>
  <?php


  for($i=0; $i<count($woo_products); $i++){

    $woo_slug = $woo_products[$i]->slug;
    $exists = 'n';

    for($k=0; $k<count($companies); $k++){
      if('company-' . $companies[$k]->slug .'' == $woo_slug){
        $exists = 'y';
      }
    }

    if($exists == 'n'){
      echo $woo_slug . ' <br> does not exist.<br><br>';

      /* wp_insert_term( '' . $companies->name . '', 'product_cat',
        array(
        'parent' => 667, // optional
        'slug' => '' . $woo_slug . '' // optional
        )
      ); */
    }

    else{

    }
  }

}

add_action('created_term', 'create_woo_product_cat');
