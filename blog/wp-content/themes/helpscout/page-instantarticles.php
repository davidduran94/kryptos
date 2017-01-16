<?php

use Aws\S3\S3Client;

/* $page = empty($_GET["offset"]) ? 1 : intval($_GET["offset"]);
  $order = empty($_GET["order"]) ? "DESC" : "ASC"; */
$limit = empty($_GET["limit"]) ? 10 : intval($_GET["limit"]);
if ($limit > 50) {
    $limit = 50;
}
ob_start();
echo '<?xml version="1.0" encoding="' . esc_attr(get_option('blog_charset')) . '"?' . '>';

function img2ia($matches) {
    foreach ($matches as $k => $v) {
        if ($k > 0) {
            preg_match('#title=[\'|"](.*.)[\'|"]#Ui', $matches[0], $match_alts);
            $alt = "";
            if (count($match_alts) > 1) {
                if ($match_alts[1] != "")
                    $alt = "<figcaption>" . $match_alts[1] . "</figcaption>";
            }
            //list($w, $h, $t, $attr) = getimagesize($v);
            return "<figure data-feedback=\"fb:likes,fb:comments\"><img src=\"{$v}\"\/>{$alt}</figure>";
        }
    }
}

function galtogal($matches) {
    foreach ($matches as $k => $v) {
        if ($k > 0) {
            $gallery = "<figure class=\"op-slideshow\">";
            $ids = explode(",", $v);
            foreach ($ids as $id) {
                $alt = trim(str_replace("\n", " ", get_post(intval($id))->post_excerpt));
                $gallery.= "<img title=\"" . $alt . "\" src=\"" . wp_get_attachment_url(intval($id)) . "\"/>";
            }
            $gallery.= "</figure>";
            return $gallery;
        }
    }
}

function if2if($matches) {
    foreach ($matches as $k => $v) {
        if ($k > 0) {
            return "<figure class=\"op-social\"><iframe class=\"no-margin\" width=\"100%\"  frameborder=\"0\"  height=\"220\" src='{$v}'></iframe></figure>";
        }
    }
}

function bq2if($matches) {
    $block = "";
    foreach ($matches as $k => $v) {
        if ($k == 0) {
            $block = $v;
        } else {
            return "<figure class=\"op-social\"><iframe>{$block}<script async src=\"//platform.twitter.com/widgets.js\" charset=\"utf-8\"></script></iframe></figure>";
        }
    }
}

$last_modified = null;
?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title><?php bloginfo_rss('name'); ?> - <?php esc_html_e('Instant Articles', 'instant-articles'); ?></title>
        <link><?php bloginfo_rss('url') ?></link>
        <description><?php bloginfo_rss('description') ?></description>
        <?php
        $args = array(
            'post_status' => 'publish',
            'posts_per_page' => $limit,
            'ignore_sticky_posts' => true,
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => array('post-format-gallery'),
                'operator' => 'NOT IN'
            )
        );

        $the_query = new WP_Query($args);
        $i = 0;
        while ($the_query->have_posts()) :
            $the_query->the_post();
            $instant_article_post = get_post();
            $category = "";
            $post_categories = wp_get_post_categories($instant_article_post->ID);

            foreach ($post_categories as $c) {
                $cat = get_category($c);
                $category = $cat->cat_name;
                break;
                //$cats[] = array('name' => $cat->name, 'slug' => $cat->slug);
            }
            $thumb_id = get_post_thumbnail_id($instant_article_post->ID);
            $thumb_url = wp_get_attachment_url($thumb_id);
            if (empty($thumb_url)) {
                if (get_the_post_thumbnail($post->ID) != '') {
                    $thumb_url = the_post_thumbnail();
                } else {
                    $thumb_url = catch_that_image();
                }
                $thumb_url = empty($thumb_url) ? "https://dummyimage.com/562x315/ffffff/43caf7.png&text=Fuga+de+Cerebros" : $thumb_url;
            }
            ?>

            <item>
                <title><?php echo esc_html(get_the_title()); ?></title>
                <link><?php echo esc_html(get_the_permalink()); ?></link>
                <content:encoded>
                    <![CDATA[<?php include("ia_template.php") ?>]]>
                </content:encoded>
                <guid isPermaLink="false"><?php esc_html(the_guid()); ?></guid>
                <description><![CDATA[<?php the_excerpt() ?>]]></description>
                <pubDate><?php echo strftime("%a, %d %b %Y %H:%M:%S %z", strtotime($instant_article_post->post_date)); ?></pubDate>
                <modDate><?php echo strftime("%a, %d %b %Y %H:%M:%S %z", get_post_modified_time('U', false, $instant_article_post->ID)); ?></modDate>
                <author><?php the_author(); ?></author>
            </item>
        <?php endwhile; ?>
        <lastBuildDate><?php echo strftime("%a, %d %b %Y %H:%M:%S %z", strtotime("now")); ?></lastBuildDate>
    </channel>
</rss>
<?php

$xml = ob_get_contents();
$file_path = tempnam("/tmp", "rss");
ob_end_clean();
$file = '/instantarticles.xml';

if ($fp = fopen($file_path, 'w')) {
    if (is_writable($file_path)) {
        fwrite($fp, $xml);
        fclose($fp);

        $bucket = 'ulama';
        $secret = 'Qt5UKoOl8SL0tCnC7k9pHiLodgekGYIeGolayCdr';
        $keyname = 'AKIAJSPXFZQTXSRJPCGA';

        $s3 = S3Client::factory(
                        array(
                            'key' => $keyname,
                            'secret' => $secret,
                            'region' => 'us-west-2'
                        )
        );

        $result = $s3->putObject(array(
            'Bucket' => $bucket,
            'Key' => $file,
            'SourceFile' => $file_path,
            'ContentType' => 'text/xml',
            'ACL' => 'public-read',
            'StorageClass' => 'REDUCED_REDUNDANCY'
        ));

        echo $result['ObjectURL'];
    } else {
        echo "File $file_path is not writable";
    }
}