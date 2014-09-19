<?php
if (!function_exists('add_action')) {
  die('Please don\'t open this file directly!');
}

class wn_ajax extends wf_wn {
  // create dialog content
  function dialog() {
    if (!$_POST || !isset($_POST['params'])) {
      die('Bad request.');
    }

    // prevent browsers from caching the request
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

    // Fetch posted params
    $conditional = explode(':', @$_POST['params']);
    $dialog_name = @$_POST['dialog_name'];
    $selected = explode(',', $conditional[1]);

    call_user_func(array('wn_ajax', $dialog_name), $selected);

    // WP bug workaround
    die();
  } // dialog

  // Function for marking selected items
  function is_selected($item, $haystack) {
    // If item is in array then it's selected
    if (is_array($haystack)) {
      if (in_array($item, $haystack)) {
        // Item is selected
        $selected['class'] = 'wn-selected';
        return $selected;
      } else {
        // Item isn't selected
        return '';
      }
    }
  } // function is_selected

  // list categories
  function categories($params) {
      // Set categories arguments
      $categories_args = array('hide_empty' => '0');
      $out .= '<ul id="wn_selectable_categories" title="Select categories you want to attach">';

      // Get categories from table
      $categories = get_categories($categories_args);

      if ($categories) {
        foreach ($categories as $category) {
          $selected = self::is_selected($category->cat_ID, $params);
          $out .= '<li class="' . $selected['class'] . '">';
          $out .= '<a href="#" id="' . $category->cat_ID . '">' . $category->cat_name . '</a>' . $selected['img'];
          $out .= '</li>';
         } // end foreach $categories
      } else {
          $out .= '<li>';
          $out .= 'Sorry there are no categories available!';
          $out .= '</li>';
      }

      $out .= '</ul>';
      echo $out;

  } // categories

  // list tags
  function tags($params) {
    $out .= '<ul id="wn_selectable_tag" title="Select tags you want to attach">';

    // Fetch all tags
    $tags = get_tags(array('hide_empty'=>'0'));

    if ($tags) {
      foreach ($tags as $tag ) {
        $selected = self::is_selected($tag->slug, $params);
        $out .= '<li class="' . $selected['class'] . '">';
        $out .= '<a href="#" id="' . $tag->slug . '">' . $tag->name . '</a>' . $selected['img'];
        $out .= '</li>';
      }
    } else {
      $out .= '<li>';
      $out .= 'Sorry there are no tags available!';
      $out .= '</li>';
    }

    $out .= '</ul>';
    echo $out;
  } // tags

  // list pages
  function pages($params) {
    $out .= '<ul id="wn_selectable_pages" title="Select pages you want to attach">';
    // Fetch all pages
    $pages = get_pages();

    if ($pages) {
      foreach ($pages as $page) {
        $selected = self::is_selected($page->ID, $params);
        $out .= '<li class="' . $selected['class'] . '">';
        $out .= '<a href="#" id="' . $page->ID . '">' . $page->post_title . '</a>' . $selected['img'];
        $out .= '</li>';
      }
    } else {
      $out .= '<li>';
      $out .= 'Sorry there are no pages available!';
      $out .= '</li>';
    }

    $out .= '</ul>';
    echo $out;
  } // pages

  // list posts
  function posts($params) {
    $out .= '<ul id="wn_selectable_posts" title="Select posts you want to attach">';

    // Fetch all posts
    $posts = get_posts();

    if ($posts) {
      foreach ($posts as $post) {
        $selected = self::is_selected($post->ID, $params);
        $out .= '<li class="' . $selected['class'] . '">';
        $out .= '<a href="#" id="' . $post->ID . '">' . $post->post_title . '</a>' . $selected['img'];
        $out .= '</li>';
      }
    } else {
      $out .= '<li>';
      $out .= 'Sorry there are no posts available!';
      $out .= '</li>';
    }

    $out .= '</ul>';
    echo $out;
  } // list_posts

  // list authors
  function authors($params) {
    global $wpdb;
    $out .= '<ul id="wn_selectable_authors" title="Select authors you want to attach">';

    // Fetch all authors
    $args = array('echo' => '0', 'exclude_admin' => false, 'style'=>'none');
    $authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY display_name");

    if ($authors) {
      foreach ($authors as $author) {
        $selected = self::is_selected($author->ID, $params);
        $out .= '<li class="' . $selected['class'] . '">';
        $out .= '<a href="#" id="' . $author->ID . '">' . $author->user_nicename . '</a>' . $selected['img'];
        $out .= '</li>';
      }
    } else {
      $out .= '<li>';
      $out .= 'Sorry there are no authors available!';
      $out .= '</li>';
      }

    $out .= '</ul>';
    echo $out;
  } // list_authors

  // list post types
  function post_types($params) {
    $out .= '<ul id="wn_selectable_post_types" title="Select post types you want to attach">';

    // Fetch all post types
    $post_types = get_post_types('','objects');
    // Array of post types to exclude
    $exclude = array('nav_menu_item', 'revision');

    if ($post_types) {
      foreach ($post_types as $post_type) {
        $selected = self::is_selected($post_type->name, $params);
        if (!in_array($post_type->name, $exclude)) {
          $out .= '<li class="' . $selected['class'] . '">';
          $out .= '<a href="#" id="' . $post_type->name . '">' . $post_type->name . '</a>' . $selected['img'];
          $out .= '</li>';
        }
      }
    } else {
      $out .= '<li>';
      $out .= 'Sorry there are no post types available!';
      $out .= '</li>';
    }

    $out .= '</ul>';
    echo $out;
  } // pages

  // list page templates
  function page_templates($params) {
    $out .= '<ul id="wn_selectable_page_templates" title="Select page templates you want to attach">';

    // Fetch templates list
    $templates = get_page_templates();
    ksort($templates);

    if ($templates) {
      foreach ($templates as $template_name => $template_file) {
        $selected = self::is_selected($template_file, $params);
          $out .= '<li class="' . $selected['class'] . '">';
          $out .= '<a href="#" id="' . $template_file . '">' . $template_name . '</a>' . $selected['img'];
          $out .= '</li>';
      }
    }

    $out .= '</ul>';
    echo $out;
  } // page_templates
} // class wn_ajax
?>