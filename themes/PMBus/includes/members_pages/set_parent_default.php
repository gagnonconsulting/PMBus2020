<?php

add_filter( 'wp_insert_post_data', 'wpse_59007_set_default_page_parent' );

function wpse_59007_set_default_page_parent( $data )
{
    if ( $data['post_status'] == 'auto-draft' && $data['post_type'] == 'page' ){
        $data['post_parent'] = 206;
        global $post;
        $post->page_template = "member_home_page.php";
    }
    return $data;
}

function example_insert_category(){
  
}
