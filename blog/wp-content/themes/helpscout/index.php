<?php get_header(); ?>


<section id="content" class="container" role="main">
    <div class="row">
        <?php
        $args = array(
            'post__not_in' => $exclude_post_id,
        );
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) :
            $cont_post = 0;
            while ($my_query->have_posts()) :
                $my_query->the_post();
                ?>
                <?php if ($cont_post>=1) get_template_part('entry'); ?>
            <?php $cont_post++; endwhile;
        endif; ?>
    </div>
</section>


<?php get_footer(); ?>