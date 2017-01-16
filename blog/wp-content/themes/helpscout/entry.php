<?php
$category = "";
$post_categories = wp_get_post_categories(get_the_ID());

foreach ($post_categories as $c) {
    $cat = get_category($c);
    $category = $cat->cat_name;
    break;
    //$cats[] = array('name' => $cat->name, 'slug' => $cat->slug);
}
$thumb_id = get_post_thumbnail_id(get_the_ID());
$thumb_url = wp_get_attachment_url($thumb_id);
if (empty($thumb_url)) {
    if (get_the_post_thumbnail(get_the_ID()) != '') {
        $thumb_url = the_post_thumbnail();
    } else {
        $thumb_url = catch_that_image();
    }
    $thumb_url = empty($thumb_url) ? $thumb_url = "https://dummyimage.com/562x315/ffffff/43caf7.png&text=Fuga+De+Cerebros" : $thumb_url;
}
?>

<style type="text/css">    
  
</style>

<div class="container flow-text">
    <a href="<?php the_permalink() ?>" class="link feature-link black-text" title="Read this post">
        <div class="row" style="margin-left: 15%; margin-top: 1em; font-size: .8em; ">
            <div class="col s10 m10 l10 left">
                <h1 class="black-text"><?php the_title(); ?></h1>
                <p class="black-text">
                <?php the_excerpt() ?>
                </p>
            </div>
        </div>
    </a>

</div>



