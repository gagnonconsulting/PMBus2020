<?php
function gci_show_product_info() {
  //$id = get_the_ID();
  //var_dump(get_post($id));
  global $product;

  $url = $product->get_attribute( 'pa_product_link' );
  $clickable_url = "<a style='color: #632262 !important;' target='_blank' href='".$url."'>Visit</a>";
  ?>
    <tr>
      <td class='gci-product-table-td gci_hide'>
        <center><?php echo get_the_post_thumbnail(); ?></center>
      </td>

      <td class='gci-product-table-td'>
        <?php echo $product->get_attribute( 'pa_company' ); ?>
      </td>

      <td class='gci-product-table-td'>
        <a target="_blank" href="<?php echo $url ?>"><?php echo get_the_title(); ?></a>
      </td>

      <td class='gci-product-table-td gci_hide'>
        <?php echo get_the_excerpt(); ?>
      </td>

      <td class='gci-product-table-td'>
        <?php echo $product->get_attribute( 'pa_power-rating' ); ?>
      </td>

      <td class='gci-product-table-td'>
        <?php echo $product->get_attribute( 'pa_input-voltage' ); ?>
      </td>
    </tr>
  <?php

}
