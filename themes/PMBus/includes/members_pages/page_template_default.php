<?php

function set_default_page_template() {
    global $post;
    if ( 'page' == $post->post_type
        && 0 != count( get_page_templates( $post ) )
        && get_option( 'page_for_posts' ) != $post->ID // Not the page for listing posts
        && '' == $post->page_template // Only when page_template is not set
    ) {
        $post->page_template = 'member_home_page.php';
    }
}
add_action('add_meta_boxes', 'set_page_template_default', 1);

function set_page_template_default() {
  
}
