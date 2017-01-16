<?php get_header(); ?>
<section id="content" role="main">
    <div class="row">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                $tags = wp_get_post_tags(get_the_ID());
                $cat_rel_name = "";
                foreach (get_the_category() as $obj) {
                    $cat_rel_name = $obj->name;
                    $cat_rel_slug = $obj->slug;
                    break;
                }
                ?>
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

                <section id="main-article">
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m10 offset-m1">
                                <article id="post-<?php the_ID(); ?>" class="flow-text">       
                                    <section class="entry-content">
                                        <?php
                                        $nota_contenido = preg_replace_callback('~<iframe.*?src="([^"]+).*><\/iframe>~', "materialize_iframe", get_the_content());
                                        echo apply_filters('the_content', $nota_contenido);
                                        ?>
                                        <div class="entry-links"><?php wp_link_pages(); ?></div>
                                    </section>
                                </article>
                                <script type="text/javascript">
                            $(document).ready(function () {
                                prepare_menu();
                                $(window).scrollTop(0);
                                $(window).scroll(function () {
                                    prepare_menu();
                                });


                                function prepare_menu() {

                                    if ($(window).scrollTop() > ($("#main-article").offset().top - 30)) {
                                        if (!$(".share_controls").hasClass("fixed")) {
                                            $(".share_controls").addClass("fixed");
                                        }
                                    } else {
                                        if ($(".share_controls").hasClass("fixed")) {
                                            $(".share_controls").removeClass("fixed");
                                        }
                                    }
                                }


                            });
                                </script>

                            </div>
                        </div>
                      
                    </div>
                </section>
                <?php
            endwhile;
        endif;
        ?>
    </div>
</section>
<?php get_footer(); ?>