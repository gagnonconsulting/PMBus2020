<?php

function wpshout_register_taxonomy() {
  $args = array(
      'hierarchical' => true,
      'label' => 'Companies',
  );
  $labels = array(
      'company_name' => 'Company Name',
      'external_url' => 'External URL'
  );
  register_taxonomy( 'companies', array( 'post', 'page', 'company' ), $args );
}
