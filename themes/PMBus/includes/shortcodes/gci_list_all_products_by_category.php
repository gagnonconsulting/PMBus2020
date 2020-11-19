<?php
function gci_list_all_products_by_category()
{

$gci_category_contents = '';
$allowed_members_list = '';
global $wpdb;

ob_start();
?>
<div id="categoryListBoxWrapper" style="float:left; width: 27%;">
  <h2>Product Categories</h2>
  <div id='categoryListBox' style="position: relative; overflow: scroll; background-color: white; padding: 10px 20px 20px 10px; height: 400px; width: 100%; float:left; border: 1px solid gray;">
  <p style="font-size:0.9em;margin-bottom:10px;">(select a Category to view Products)</p>
<?php

// get a list of all the Companies so we can check if they are allowed to show their products
// THIS IS BROKEN - NEED TO GET LIST OF ALL ALLOWED MEMBERS SO AS NOT TO INCLUDE PRODUCTS BELOING TO THEM
$allowed_members_list = $wpdb->get_results(
  "SELECT * FROM wp_term_taxonomy as tx, wp_terms as tr, wp_termmeta as tm
    WHERE tx.taxonomy = 'companies' AND
      tx.term_id = tr.term_id AND
      tx.term_id = tm.term_id AND
      tm.meta_key = 'membership_type' AND
      (tm.meta_value != 'Draft' AND tm.meta_value != 'Inactive') AND
      (tm.meta_value = 'PMBus Adopter Company' OR tm.meta_value = 'FULL SMIF Member Company')
    ORDER BY name ASC");
    //var_dump ($allowed_members_list);


  $args = array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
    'parent'   => 0
  );
  $product_cat = get_terms( $args );

?>
<?php

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
      <div id="parentCatSlug-<?= $parentslug ?>" >
        <h4><strong><?= $parent_product_cat->name ?></strong></h4>
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
                $parent_name = $parent_product_cat->name;
                $prod_count = $child_product_cat->count;
?>
              <li id='categoryLI-<?= $slug ?>'>
                <a id='<?= $term_id ?>' class='<?= $child_product_cat->name ?>' href='#'>
<?php
                 echo "$child_product_cat->name ($child_product_cat->count)";
?>
                </a>
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
</div>

  <div id="productBoxWrapper" style="float:right; width:70%;">
    <h2>Products</h2>
    <div id="productBox" style="width:100%; border:1px solid gray; padding:10px;">
      <p style="font-size:0.9em;margin-bottom:10px;">(choose a PMBus product category to view products)</p>
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
// this jQuery script is also used in the gci_list_all_products_by_category
// should be moved to a common js file
?>
<script>
// Do not hold the postion of the box to the top, since it scrolls off the bottom
  // jQuery(window).scroll(function() {
      // jQuery('#categoryListBox').css('top', jQuery(this).scrollTop() + "px");
  // });
</script>

<?php
  $gci_category_contents = ob_get_clean();
  return $gci_category_contents;
} // end function



add_shortcode('list_all_products_by_category', 'gci_list_all_products_by_category');
