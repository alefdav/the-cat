<?php

include_once('inc/inc_config.php');
include_once('inc/inc_scripts.php');
include_once('inc/inc_request.php');

add_action('wp_ajax_favoritar_gato', 'handle_favoritar_gato');
add_action('wp_ajax_nopriv_favoritar_gato', 'handle_favoritar_gato');
add_action('wp_ajax_nopriv_toggle_favorite', 'redirect_to_login');

add_action('wp_ajax_adicionar_favorito', 'adicionar_favorito_callback');
add_action('wp_ajax_remover_favorito', 'remover_favorito_callback');

function adicionar_favorito_callback() {
    $cat_api = new CatAPI(API_KEY);
    $image_id = $_POST['image_id'];
    
    $result = $cat_api->addFavorite($image_id);
    error_log('Resultado da API: ' . print_r($result, true));
    if ($result) {
        wp_send_json_success($result);
    } else {
        wp_send_json_error('Não foi possível adicionar aos favoritos');
    }
}

function remover_favorito_callback() {
    $cat_api = new CatAPI(API_KEY);
    $favorite_id = $_POST['favorite_id'];
    
    $result = $cat_api->removeFavorite($favorite_id);
    
    if ($result) {
        wp_send_json_success();
    } else {
        wp_send_json_error('Não foi possível remover dos favoritos');
    }
}

function redirect_to_login() {
    wp_send_json_error([
        'redirect' => wp_login_url(home_url())
    ]);
}



