<?php
function gci_list_companies() {

  $gci_companies_list='';

  ob_start();
  global $wpdb;

  $woo_commerce_company = $wpdb->get_results("
  SELECT * FROM `wp_terms` WHERE name = 'Company'
  ");
  $woo_commerce_company_id = $woo_commerce_company[0]->term_id;

  $companies_list = $wpdb->get_results(
    "
    SELECT * FROM
        (
          SELECT company.object_id, name, slug, parent, terms.term_id FROM
          (SELECT * FROM wp_term_relationships r) AS company,
          (SELECT * FROM wp_term_relationships r1) AS category,
          (SELECT * FROM wp_terms) AS terms,
          (SELECT * FROM wp_term_taxonomy) AS taxonomy
          WHERE company.object_id = category.object_id AND terms.term_id = category.term_taxonomy_id
          AND terms.slug NOT LIKE 'http%' AND terms.name != 'simple'
          AND terms.name != 'featured' AND taxonomy.term_taxonomy_id = terms.term_id
          AND taxonomy.taxonomy NOT LIKE 'pa_company'
          ) as categories
          WHERE parent = ".$woo_commerce_company_id."
          GROUP BY name
    "
  );
  ?>
  <div style='width:80%; background-image:url("http://localhost:8889/divi_child_pmbus/wp-content/uploads/2018/05/PMBus-Banner.jpeg;"); background-size:100%;'>
    <center><h2 style='margin-left:-30%;'>Company <br class='rwd-break'>Products <br>Directory:</h2></center>
  </div>
  <hr align='left' width='80%'>
  <div style="width: 50%; float:left">

  <?php
  $count = count($companies_list);
  $p2 = $count/2;
  $p1 = $count - $p2;?>

  <ul style='float:left'><?php
  for ($k = 0; $k < $p1; $k++) {

    $company_slug = $companies_list[$k]->slug;
    $company_slug = substr($company_slug, 8);
    $link = 'http://localhost:8888/divi_child_pmbus/direcotry/products-by-company/' . $company_slug;
    ?>
    <li>
    <?php
    echo '<a target="_blank" href="' . $link .'">' . $companies_list[$k]->name . '</a>';
    ?>
    </br>
    </li>
    <?php
  }?>
  </div>

  <div style="width: 50%; float:left">
  <ul style='float:left'><?php
  for ($k = $p2; $k < $count; $k++) {

    $company_slug = $companies_list[$k]->slug;
    $company_slug = substr($company_slug, 8);
    $link = 'http://localhost:8888/divi_child_pmbus/direcotry/products-by-company/' . $company_slug;
    ?>
    <li>
    <?php
    echo '<a target="_blank" href="' . $link .'">' . $companies_list[$k]->name . '</a>';
    ?>
    </br>
    </li>
    <?php
  }?>
  </ul>
  </div>
  <?php
  $gci_companies_list = ob_get_clean();
  return $gci_companies_list;
}

add_shortcode('list_companies', 'gci_list_companies');
