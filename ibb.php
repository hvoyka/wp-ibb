<?php

/**
 * Plugin Name:       Insert banner block
 * Description:       Add block to post with name and link from other post.
 * Version:           1.0
 * Author:            Stanislav Lavrentev
 * Author URI:        https://github.com/hvoyka
 */

//add css
function ibb_css()
{
  $plugin_url = plugin_dir_url(__FILE__);

  wp_enqueue_style('ibb-style', $plugin_url . 'css/ibb-style.css');
}
add_action('wp_enqueue_scripts', 'ibb_css');

//Create shorcode ibb

function inline_banner_func($atr)
{
  shortcode_atts(
    array(
      'posts' => 1,
      'name' => "Inline banner title"
    ),
    $atr
  );
  $postLink = get_permalink($atr['id']);

  $block = "
  <div class='ibb'>
    <div class='ibb__inner'>
      <h3 class='ibb__title'>READ</h3>
      <a class='ibb__link' href='$postLink' />$atr[name]</a>
    </div>
</div>";

  return $block;
}
add_shortcode('ibb', 'inline_banner_func');

// Filter Functions with Hooks
function ibb_mce_button()
{
  // Check if user have permission
  if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
    return;
  }
  // Check if WYSIWYG is enabled
  if ('true' == get_user_option('rich_editing')) {
    add_filter('mce_external_plugins', 'ibb_tinymce_plugin');
    add_filter('mce_buttons', 'ibb_register_mce_button');
  }
}
add_action('admin_head', 'ibb_mce_button');

// Function for new button
function ibb_tinymce_plugin($plugin_array)
{
  $plugin_array['ibb_mce_button'] = plugin_dir_url(__FILE__) . 'js/ibb_editor_plugin.js';
  return $plugin_array;
}

// Register new button in the editor
function ibb_register_mce_button($buttons)
{
  array_push($buttons, 'ibb_mce_button');
  return $buttons;
}


//IBB plugin settings page

function ibb_plugin_page()
{
  $page_title = 'Inline banner block options';
  $menu_title = 'IBB';
  $capatibily = 'manage_options';
  $slug = 'ibb_plugin';
  $callback = 'ibb_page_html';
  $icon = 'dashicons-schedule';
  $position = 60;

  add_menu_page($page_title, $menu_title, $capatibily, $slug, $callback, $icon, $position);
}
add_action('admin_menu', 'ibb_plugin_page');
