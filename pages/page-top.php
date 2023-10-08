<?php
/**
 * Template name: top
 */
$title = "Title top";
get_header();

get_template_part( apply_filters( 'theme_filter_get_template_part', 'templates/top-content' ) );

get_footer();