<!doctype html>
<html lang="es" prefix="op: http://media.facebook.com/op#">
    <head>
        <title><?php the_title(); ?></title>
        <meta charset="utf-8">
        <link rel="canonical" href="<?php the_permalink(); ?>?fb_ia"/>
        <link rel="stylesheet" title="default" href="#">
        <meta property="op:markup_version" content="v1.0">
        <meta property="fb:article_style" content="default">
        <meta property="fb:use_automatic_ad_placement" content="true">
    </head>
    <body>
        <article>
            <figure class="op-tracker">
                <iframe>
                <script>
                    (function (w, d, s, l, i) {
                        w[l] = w[l] || [];
                        w[l].push({'gtm.start':
                                    new Date().getTime(), event: 'gtm.js'});
                        var f = d.getElementsByTagName(s)[0],
                                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                        j.async = true;
                        j.src =
                                '//www.googletagmanager.com/gtm.js?id=' + i + dl;
                        f.parentNode.insertBefore(j, f);
                    })(window, document, 'script', 'dataLayer', 'GTM-MN3SRB');
                </script>
                </iframe>
            </figure>
            <header>
                <h1><?php echo esc_html(get_the_title()); ?></h1>
                <h2><?php echo esc_html(get_the_excerpt()); ?></h2>
                <figure>
                    <img src="<?php echo $thumb_url; ?>"/>
                </figure>
                <h3 class="op-kicker"><?php echo $category ?></h3>
                <address>
                    <a title="Staff"><?php the_author(); ?></a>
                </address>
                <!--figure class="op-ad">
                    <iframe>
                    <div>
                        <script type='text/javascript' src='https://www.googletagservices.com/tag/js/gpt.js'>
                    googletag.pubads().definePassback('/60262050/box-banner-2-300x250', [300, 250]).display();
                        </script>
                    </div>
                    </iframe>
                </figure-->
                <time class="op-published" dateTime="<?php echo gmdate("Y-m-d\TH:i:s\Z", strtotime($instant_article_post->post_date)); ?>"><?php echo strftime("%a, %d %b %Y %H:%M:%S %z", strtotime($instant_article_post->post_date)); ?></time>
                <time class="op-modified" dateTime="<?php echo gmdate("Y-m-d\TH:i:s\Z", get_post_modified_time('U', false, $instant_article_post->ID)) ?>"><?php echo strftime("%a, %d %b %Y %H:%M:%S %z", get_post_modified_time('U', false, $instant_article_post->ID) ); ?></time>
            </header>
            <div class="content">
                <?php
                $nota_contenido = (string) get_the_content();
                $nota_contenido = strip_tags($nota_contenido, "<iframe><blockquote><ul><ol><li><p><a><br><img><table>");
                $nota_contenido = str_replace('style="text-align: justify;"', "", $nota_contenido);
                $nota_contenido = str_replace('style="text-align: left;"', "", $nota_contenido);
                $nota_contenido = str_replace('style="text-align: right;"', "", $nota_contenido);
                $nota_contenido = str_replace("style", "style2", $nota_contenido);
                $nota_contenido = preg_replace_callback('~<iframe.*?src="([^"]+).*><\/iframe>~', "if2if", $nota_contenido);
                $nota_contenido = preg_replace_callback('~\[gallery.*?ids="([^"]+).*\]~', "galtogal", $nota_contenido);
                $nota_contenido = preg_replace_callback('~<blockquote class="twitter-tweet" lang="(.*)">.*?</blockquote>~s', 'bq2if', $nota_contenido, 1);
                $nota_contenido = preg_replace_callback('~<blockquote class="twitter-video" lang="(.*)">.*?</blockquote>~s', 'bq2if', $nota_contenido, 1);
                $nota_contenido = preg_replace_callback('~<img.*?src="([^"]+).*?\/>~', "img2ia", $nota_contenido);
                $nota_contenido = str_replace("<p><figure", "<figure", $nota_contenido);
                $nota_contenido = str_replace("</figure></p>", "</figure>", $nota_contenido);
                $nota_contenido = str_replace("<p ><figure", "<figure", $nota_contenido);
                $nota_contenido = str_replace("<p></p>", "", $nota_contenido);
                $nota_contenido = str_replace("<p> </p>", "", $nota_contenido);
                ?>
                <?php echo $nota_contenido ?>
            </div>                    
            <footer>
                <?php
                $tags = wp_get_post_tags($instant_article_post->ID);
                $tag_ids = array();
                foreach ($tags as $individual_tag)
                    $tag_ids[] = $individual_tag->term_id;
                $args = array(
                    'tag__in' => $tag_ids,
                    'post__not_in' => array($post->ID),
                    'posts_per_page' => 3,
                    'caller_get_posts' => 1
                );
                $my_query = new WP_Query($args);
                if ($my_query->have_posts()) {
                    ?>
                    <ul class="op-related-articles" data-title="Te recomendamos">
                        <?php
                        for ($rel = 0; $my_query->have_posts() && $rel < 3; $rel++) {
                            $my_query->the_post();
                            $post = get_post();
                            ?>
                            <li class="relatedNewsItem">
                                <a href="<?php the_permalink() ?>">
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <aside><?php bloginfo_rss('name'); ?></aside>
            </footer>
        </article>
    </body>
</html>