<?php get_header(); ?>
<section id="content" role="main">
    <div class="category-featured valign-wrapper"">
            <h1  class="white-text valign center-align"><?php single_cat_title(); ?></h1>
    </div>
    <div class="container">
        <div class="row">          
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part('entry'); ?>
                <?php endwhile;
            endif;
            ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>