<?php
/**
 * The template to display the 404 page
 */

get_header();

get_template_part( apply_filters( 'theme_filter_get_template_part', 'templates/content-404') );

get_footer();