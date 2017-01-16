<?php
add_action('after_setup_theme', 'blankslate_setup');

function blankslate_setup() {
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    global $content_width;
    if (!isset($content_width))
        $content_width = 640;
    register_nav_menus(
            array('main-menu' => __('Main Menu', 'blankslate'))
    );
}

add_action('wp_enqueue_scripts', 'blankslate_load_scripts');

function blankslate_load_scripts() {
    wp_enqueue_script('jquery');
}

add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');

function blankslate_enqueue_comment_reply_script() {
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_filter('the_title', 'blankslate_title');

function blankslate_title($title) {
    if ($title == '') {
        return '&rarr;';
    } else {
        return $title;
    }
}

add_filter('wp_title', 'blankslate_filter_wp_title');

function blankslate_filter_wp_title($title) {
    return $title . esc_attr(get_bloginfo('name'));
}

add_action('widgets_init', 'blankslate_widgets_init');

function blankslate_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar Widget Area', 'blankslate'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => "</li>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

function blankslate_custom_pings($comment) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
    <?php
}

add_filter('get_comments_number', 'blankslate_comments_number');

function blankslate_comments_number($count) {
    if (!is_admin()) {
        global $id;
        $comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}

function materialize_iframe($matches) {
    $block = "";
    foreach ($matches as $k => $v) {
        if ($k == 0) {
            $block = $v;
        } else {
            $domain = parse_url($v);
            switch ($domain["host"]) {
                case "www.youtube.com":
                case "www.dailymotion.com":
                case "www.vimeo.com":
                case "player.vimeo.com":
                    return "<div class=\"video-container\">{$block}</div>";
                    break;
                default:
                    return $block;
            }
        }
    }
}

function catch_that_image() {
    global $post, $posts;
    $first_img = '';
    //ob_start();
    //ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches[1][0];

    if (empty($first_img)) {
        $output = preg_match_all('/<iframe.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $domain = parse_url($matches[1][0]);
        switch ($domain["host"]) {
            case "www.youtube.com": {
                    return "http://img.youtube.com/vi/" . str_replace("/embed/", "", $domain["path"]) . "/0.jpg";
                    break;
                }
            case "www.dailymotion.com": {
                    return "http://www.dailymotion.com/thumbnail/video/" . str_replace("/embed/", "", $domain["path"]);
                }
        }

        $first_img = "https://dummyimage.com/562x315/ffffff/43caf7.png&text=Fuga+de+Cerebros";
    }
    return $first_img;
}
