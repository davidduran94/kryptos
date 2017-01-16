<?php get_header(); ?>
<a href="<?php the_permalink() ?>">
    <div class="valign-wrapper center"  style=" height: 400px; background: url(<?php echo (has_post_thumbnail() ? wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())) : ''); ?>) no-repeat center bottom; background-size:cover">
        <div class="valign" style="width:100%;">  
            <div class="row">
                <div class="col s12 m8 offset-m2" style="border: 2px solid white; letter-spacing: 4px; ">
                    <h1 class="feature-title white-text"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </div>
</a>
<section id="main-article" role="main">
    <div class="container flow-text">
        <div class="row">          
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
                <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>