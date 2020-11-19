<?php
  // take related products off of product listing page
  remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

  // remove the thumbnail
  remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

  // remove the product title
  remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

  remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

  remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
  //This snippet will remove the notice that shows the number of results.

  remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering',30 );
