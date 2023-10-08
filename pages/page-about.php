<?php
/**
 * Template name: about
 */
$title = "Title about";
get_header();

get_template_part( apply_filters( 'theme_filter_get_template_part', 'templates/about-content' ) );

get_footer();