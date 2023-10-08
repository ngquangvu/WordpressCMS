<?php

/**
 * The main template file
 */
$title = 'Title Name';

get_header();

get_template_part(apply_filters('theme_filter_get_template_part', 'pages/page-top'));

get_footer();
?>
