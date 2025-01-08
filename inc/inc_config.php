<?php

// CONFIGURAÇÃO BASICA
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
show_admin_bar(false);
remove_action('wp_head', 'wp_generator');

function setup_theme()
{
    add_theme_support('title-tag');
    add_theme_support( 'post-thumbnails' );

    register_nav_menus();
}

function wpse66093_no_admin_access()
{
    global $current_user;

    $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : home_url('/');

    if (strpos($redirect, 'wp-login.php ') !== false) {
        $redirect = home_url('/');
    }

    if (user_can($current_user, "subscriber") && (!DOING_AJAX || (DOING_AJAX && DOING_AJAX !== true))) {
        exit(wp_redirect($redirect));
    }
}

add_action('after_setup_theme', 'setup_theme');
add_action('admin_init', 'wpse66093_no_admin_access', 100);

add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}