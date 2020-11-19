<?php
function gci_list_all_products_by_category()
{

$gci_category_contents = '';

ob_start();
?>
<div id='categoryListBox' style='width:20%;float:left;'>
  <h2>Product Categories</h2>
  <p style="font-size:0.9em;margin-bottom:10px;">(select a subcategory to view products)</p>
<?php

  $args = array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
    'parent'   => 0
  );
  $product_cat = get_terms( $args );

  foreach ($product_cat as $parent_product_cat)
  {
    if ($parent_product_cat->name != 'Company' &&
        $parent_product_cat->name != 'Uncategorized' &&
        $parent_product_cat->name != 'product_cat' &&
        $parent_product_cat->name != 'Misc'
        )
    {
    $parentslug=$parent_product_cat->slug;
?>
      <div id="parentCatSlug-<?= $parentslug ?> >
        <span style="text-size:1.4em;font-weight:bold;"><?= $parent_product_cat->name ?></span>
<?php
            $child_args = array(
                      'taxonomy' => 'product_cat',
                      'hide_empty' => false,
                      'parent'   => $parent_product_cat->term_id
            );
?>
          <ul class="<?= $parent_product_cat->name?>">
<?php
            $child_product_cats = get_terms( $child_args );
            foreach ($child_product_cats as $child_product_cat)
            {
                $name = $child_product_cat->name;
                $slug = $child_product_cat->slug;
                $term_id = $child_product_cat->term_id;
?>
                <li id='categoryLI-<?= $slug ?>'>
                  <a id='<?= $term_id ?>' class='<?= $child_product_cat->name?>' href='#'><?= $child_product_cat->name?></a>
                </li>
<?php
                // the id is the slug of the subcategory, and the action is performed in the jQuery event
            } // end FOREACH CHILD
?>
            </ul>
      </div>
<?php
      } // end if
    }  // end foreach parent category
?>
  </div>

  <div id="productBoxWrapper" style="float:right; width:70%;">
    <h2>Products</h2>
    <div id="productBox" style="width:100%; border:1px solid gray; padding:10px;">
      <p style="font-size:0.9em;margin-bottom:10px;">(choose a subcategory to view products)</p>
    </div>
  </div>

  <div style="display:block;float:none;">
  </div>

<script type="text/javascript">

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
} // end function



add_shortcode('list_all_products_by_category', 'gci_list_all_products_by_category');
