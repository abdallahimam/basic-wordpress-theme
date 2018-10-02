<?php
/**
 * functions page that contains the function that be needed to build the favourite theme.
 */

require_once('class-wp-bootstrap-navwalker.php');

/**
 * Function add_styles
 * this function is used to add stylesheets of my template.
 * by using helper function which is wp_enququ_style(?, ?, ?, ?, ?)
 */
function add_styles() {
    wp_enqueue_style('bootstarp-css', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/css/font-awesome.min.css');
    wp_enqueue_style('main-css', get_template_directory_uri() . '/css/main.css');
}

/**
 * Function add_scripts
 * this function is used to add scripts of my template.
 * by using helper function which is wp_enququ_script(?, ?, ?, ?, ?)
 */
function add_scripts() {
    /// remove jquery from the registration in the wordpress to change its position to end of page.
    wp_deregister_script('jquery');

    /// register the jquery to new position at the buttom ot the page.
    wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), array(), false, true);

    /// enqueue the scripts that you need.
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstarp-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), false, true);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/js/main.js', array(), false, true);

    /// add in case of IE less than 9.
    wp_enqueue_script('html5shiv', get_template_directory_uri() . '/js/html5shiv.min.js');
    wp_enqueue_script('respond', get_template_directory_uri() . '/js/respond.min.js');
    wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');
    wp_script_add_data('respond', 'conditional', 'lt IE 9');
}

/**
 * Function add custom menu to theme.
 * this function allows you to add your custom manu to the theme.
 * by using register_nav_menu(?, ?).
 */
function add_custom_menu() {
    register_nav_menus(array(
        'navbar-menu' => 'Navbar navigation menu',
        'sidebar-menu' => 'Sidebar navigation menu'
    ));
}

/**
 * Function add navbar of wordpress.
 * this function allows you to add your navbar to the theme.
 * by using wp_nav_menu(?).
 */
function include_navbar_template_menu() {
    wp_nav_menu(array(
        'theme_location'    => 'navbar-menu',
        'menu_class'        => 'navbar-nav ml-auto',
        'container'         => false,
        'depth'             => 2,
        'walker'            => new WP_Bootstrap_Navwalker(),
    ));
}

/**
 * Function get number od comments for a specific user.
 * by using get_var(?).
 */
function ps_count_user_comments() {
    global $wpdb, $current_user;
    get_currentuserinfo();
    $userId = $current_user->ID;

    $count = $wpdb->get_var('
             SELECT COUNT(comment_ID) 
             FROM ' . $wpdb->comments. ' 
             WHERE user_id = "' . $userId . '"');
    return $count;
}

/**
 * customize the excerpt length of the docs words
 * by using add_filter(?, ?)
 */
function extend_excerpt_length($length) {
    if (is_author()) {
        return 20;
    } else {
        return 20;
    }
}

/**
 * customize the excerpt dots ... of the docs words
 * by using the add_filter(?, ?)
 */
function change_excerpt_dots($more) {
    return ' <a class="read-more" href="' . get_permalink() . '"> Show...</a>';
}

/**
 * create custom pagination.
 * by using paginate_liks(?).
 */
function get_custom_pagination() {
    global $wp_query;
    $all_pages = $wp_query->max_num_pages;
    $current_page = max(1, get_query_var('paged'));
    if ($all_pages > 1) {
        $custome_paginate = paginate_links(array(
            'base'      => get_pagenum_link() . '%_%',
            'format'    => 'page/%#%',
            'current'   => $current_page
        ));
        echo $custome_paginate;
    }
}

/**
 * function redister sidebar
 * using register_sidebar(array())
 */
function add_main_sidebar() {
    register_sidebar(array(
        'name'              => 'Main sidebar',
        'description'       => 'This is the main sidebar that may used in every where in the template.',
        'id'                => 'main-sidebar',
        'class'             => 'main-sidebar',
        'before_widget'     => '<div class="widget">',
        'after_widget'      => '</div></div>',
        'before_title'      => '<h3 class="widget-title">',
        'after_title'       => '</h3><div class="widget-body">',

    ));
}

/**
 * count posts for each category.
 */
function category_posts_count($category = null) {
    $all_categories = null;
    if (is_category()) {
        $all_categories = get_categories();
        return $all_categories;
    }
    return null;
}

/**
 * function add filter
 * this helper function is used to filter the wordpress as you need
 * using add_filter(?, ?)
 */
add_filter('excerpt_length', 'extend_excerpt_length');
add_filter('excerpt_more', 'change_excerpt_dots');

/**
 * Function add action
 * this function is used to add scripts and styles which are in above two functions by calling theme
 * by using add_action(?, ?, ?, ?)
 */
add_action('wp_enqueue_scripts', 'add_styles');
add_action('wp_enqueue_scripts', 'add_scripts');
add_action('init', 'add_custom_menu');
add_action('widgets_init', 'add_main_sidebar');

/**
 * add featured image to post.
 * by using add_theme_support(?).
 */
add_theme_support('post-thumbnails');
