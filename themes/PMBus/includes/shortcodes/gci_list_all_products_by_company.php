<?php
function gci_list_all_products_by_company()
{
  $gci_company_contents = '';
  $pmbus_members_list='';
  $allowed_members_list='';
  ob_start();
  global $wpdb;
?>
<div id="companyListBoxWrapper" style="float:left; width: 27%;">
  <h2>PMBus Adopter Companies</h2>
  <div id='companyListBox' style="position: relative; overflow: auto; background-color: white; padding: 10px 20px 20px 10px; height: 400px; width: 100%; float:left; border: 1px solid gray;">
      <p style="font-size:0.9em;margin-bottom:10px;">(select a PMBus Adopter to view products)</p>
<?php

// get a list of all the Companies so we can check if they are allowed to show their products
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


//get all product categories that are of type Company
  $args = array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
    'parent'   => 0
  );

  $company_cat = get_terms( $args );
?>
  <ul class="<?= $company_cat->name?>">
<?php
  foreach ($company_cat as $parent_company_cat)
  {

    // looing for product_cat->name - this is a Company name with parent category of Company
    if ($parent_company_cat->name == 'Company' &&
        $parent_company_cat->name != 'Uncategorized') {

        $child_args = array(
          'taxonomy' => 'product_cat',  // this is only for the company category, so product_cat is a mismoner
          'hide_empty' => false,
          'parent'   => $parent_company_cat->term_id
        );

        $child_product_cats = get_terms( $child_args );
        if ( ! empty( $child_product_cats ) && ! is_wp_error( $child_product_cats ) ) {
          foreach ($child_product_cats as $child_product_cat) {
            //var_dump ($child_product_cat);
            $name = $child_product_cat->name;
            $slug = $child_product_cat->slug;
            $term_id = $child_product_cat->term_id;
            $prod_count = $child_product_cat->count;
            // et the ACF new field 'company_logo' for display
            the_field ('company_logo');
            //echo "<h3>Member in question = ".$slug."</h3>";
            //echo "<p>product belongs to <strong>".$slug."</strong></p>";
            foreach ($allowed_members_list as $allowed_member) {
              $allowed_member_company_slug = "company-".$allowed_member->slug;
              //echo "<p>allowed member slug = ".$allowed_member_company_slug."</p>";
              if ($allowed_member_company_slug == $slug ) {
                $found = true;
                break;
              } else {
                $found = false;
              }
            }
 // see if the slug of the company we are working with here is in the $allowed_members_list

         //if (($prod_count > 0) AND (in_array($allowed_members_list=>$slug == $slug)){
          if (($found) AND ($prod_count > 0)) {
?>
              <li id='categoryLI-<?= $slug ?>'>
              <a id='<?= $term_id ?>' class='<?= $child_product_cat->name ?>' href='#'>
<?php
                echo "$child_product_cat->name ($child_product_cat->count)";
?>
              </a>
              </li>

<?php
            } else {
              // no products for this company
              //echo "$child_product_cat->name";
            }
?>
<?php
          } // end FOREACH CHILD
        } else {

        }
?>
<?php
    }  // end if category = Company
  } // end foreach
?>
  </ul>
  </div>
</div>


  <div id="productBoxWrapper" style="float:right; width:70%;">
    <h2>Products</h2>
    <div id="productBox" style="width:100%; border:1px solid gray; padding:10px;">
      <p style="font-size:0.9em;margin-bottom:10px;">(choose a PMBus Adopter company to view their products)</p>
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
      // jQuery('#companyListBox').css('top', jQuery(this).scrollTop() + "px");
  // });
</script>

<?php
  $gci_category_contents = ob_get_clean();
  return $gci_category_contents;
} // end function



add_shortcode('list_all_products_by_company', 'gci_list_all_products_by_company');
