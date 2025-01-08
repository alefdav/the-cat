<?php

function head_styles()
{
    wp_deregister_script('jquery');
    wp_deregister_style('newsletter');
    wp_deregister_script('wp-embed');

    $assets = array(
        'bootstrap-css' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        'bootstrap-js' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        'js' => get_template_directory_uri() . '/dist/js/scripts.js',
    );

    // Registrar e enfileirar o CSS do Bootstrap
    wp_enqueue_style('bootstrap-css', $assets['bootstrap-css'], array(), null);
    
    // Registrar e enfileirar o JS do Bootstrap
    wp_enqueue_script('bootstrap-js', $assets['bootstrap-js'], array(), null, true);
    
    // Seu arquivo de scripts original
    wp_enqueue_script('js', $assets['js'], array('bootstrap-js'), date('YmdHis'), true);
}

function disable_embeds_tiny_mce_plugin($plugins)
{
    return array_diff($plugins, array('wpembed'));
}

function disable_embeds_rewrites($rules)
{
    foreach ($rules as $rule => $rewrite) {
        if (false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }

    return $rules;
}

function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }

    return array();
}

function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
    if ('dns-prefetch' == $relation_type) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

        $urls = array_diff($urls, array($emoji_svg_url));
    }

    return $urls;
}

function disable_items()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
    remove_action('rest_api_init', 'wp_oembed_register_route');
    add_filter('embed_oembed_discover', '__return_false');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    add_filter('tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin');
    add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
    remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
}

/**
 * Automatically set the image Title, Alt-Text, Caption & Description upon upload
 *
 * @param $post_ID
 *
 * @return void
 */
function my_set_image_meta_upon_image_upload( $post_ID )
{
	// Check if uploaded file is an image, else do nothing
	if ( wp_attachment_is_image( $post_ID ) ) {

		$my_image_title = get_post( $post_ID )->post_title;

		// Sanitize the title:  remove hyphens, underscores & extra spaces:
		$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );

		// Sanitize the title:  capitalize first letter of every word (other letters lower case):
		$my_image_title = ucwords( strtolower( $my_image_title ) );

		// Create an array with the image meta (Title, Caption, Description) to be updated
		// Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
		$my_image_meta = array(
			'ID'		=> $post_ID,			// Specify the image (ID) to be updated
			'post_title'	=> $my_image_title,		// Set image Title to sanitized title
			 //'post_excerpt'	=> $my_image_title,		// Set image Caption (Excerpt) to sanitized title
			 //'post_content'	=> $my_image_title,		// Set image Description (Content) to sanitized title
		);

		// Set the image Alt-Text
		update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );

		// Set the image meta (e.g. Title, Excerpt, Content)
		wp_update_post( $my_image_meta );

	}
}

add_action('wp_enqueue_scripts', 'head_styles', 100);
add_action('add_attachment', 'my_set_image_meta_upon_image_upload');
add_action('init', 'disable_items');

