<?php
function gci_list_all_products_by_category(){

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
    if ($parent_product_cat->name != 'Company' && $parent_product_cat->name != 'Uncategorized'){
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
      <li><h2><a href='<?= get_term_link($parent_product_cat->term_id) ?>'><?= $parent_product_cat->name ?></a></h2>
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
          { ?>
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
<script>
	const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

	const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
	v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
	)(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

	// do the work...
	document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
	const table = th.closest('table');
	Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
	.sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
	.forEach(tr => table.appendChild(tr) );
	})));
</script>
<?php
$gci_category_contents = ob_get_clean();
return $gci_category_contents;

}

add_shortcode('gci_list_all_products_by_category', 'list_all_products_by_category');
