<?php get_header(); ?>
<section id="content" role="main">
    <div class="category-featured valign-wrapper">
            <h1 class="white-text valign center-align"><?php echo get_search_query(); ?></h1>
    </div>
    <div class="container">
        <div class="row">          
            <?php if ('' != category_description()) echo apply_filters('archive_meta', '<div class="archive-meta">' . category_description() . '</div>'); ?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part('entry'); ?>
                <?php endwhile;
            endif;
            ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>