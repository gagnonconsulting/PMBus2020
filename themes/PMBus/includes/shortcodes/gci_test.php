<?php
function gci_test_list_companies() {
	$pmbus_members_list='';

	ob_start();

  $args = array(
      'post_type' => 'page',
      'tax_query' => array(
          array(
              'taxonomy' => 'companies'
          ),
      ),
  );

$the_query = new WP_Query( $args );

if( $the_query->have_posts() ): ?>

	<ul>

<? while ( $the_query->have_posts() ) : $the_query->the_post();

		?>
		<li>
      <?php
      echo '<hr>';
       the_title();
       echo '<hr>';

				//the_field('company_display_name');
        ?>"
		</li>

	<?php endwhile; ?>

	</ul>


<?php endif;
$pmbus_members_list = ob_get_clean();
return $pmbus_members_list;

}

add_shortcode('gci_test', 'gci_test_list_companies');
