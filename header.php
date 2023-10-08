<?php

/**
 * The Header: Logo and main menu
 */
?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <?php wp_head(); ?>
</head>

<body>

    <div class="<?php echo esc_attr(apply_filters('theme_filter_body_wrap_class', 'body_wrap')); ?>" <?php do_action('theme_action_body_wrap_attributes'); ?>>
        <div class="<?php echo esc_attr(apply_filters('theme_filter_page_wrap_class', 'page_wrap')); ?>" <?php do_action('theme_action_page_wrap_attributes'); ?>>
        <?php
        // Header
        get_template_part( apply_filters( 'theme_filter_get_template_part', "templates/header" ) );
        ?>