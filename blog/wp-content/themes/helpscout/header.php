<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/images/favicon.ico" type="image/x-icon">
        <meta name="google-site-verification" content="54RN4PNA6FaWwSarF3Tl0zgRokY3K6j3r-r0LlTxRgc" />
        <?php wp_head(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,300,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=PT+Serif:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
        <!--  Scripts-->
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri() ?>/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="<?php echo get_template_directory_uri() ?>/css/estilos.css" type="text/css" rel="stylesheet"/>
      <script src="http://www.fuga-de-cerebros.com.mx/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="http://www.fuga-de-cerebros.com.mx/js/amcharts/serial.js" type="text/javascript"></script>
        <script src="http://www.fuga-de-cerebros.com.mx/js/amcharts/pie.js" type="text/javascript"></script>
   
    </head>
    <body>
        <style type="text/css">
            @font-face {
                font-family: Avenir;
                src: url(Fonts/Avenir.ttf);
                font-weight: bold;
            }

            @font-face {
                font-family: AvenirB;
                src: url(Fonts/AvenirB.ttc);
                font-weight:400;
            }

            @font-face {
                font-family: AvenirL;
                src: url(Fonts/BLANCH_CAPS_LIGHT.otf);
                font-weight:400;
            }

            @font-face {
                font-family: Myriad;
                src: url(Fonts/MiriadPro-Regular.otf);
                font-weight:400;
            }


            .sabias{
                padding: 40px; 
                font-size: 7em; 
                opacity: 1 !important;
            }

            @media only screen (max-width: 1040px){
                .sabias{
                    font-size: 2em; 
                }
            }


            .share_controls{
                display: none;
            }
        </style>
    
        <header>
            <div class="navbar-fixed">
                <nav id="main-nav" class="white z-depth-0">
                    <div class="container">
                        <div class="nav-wrapper">
                            <a href="/" class="brand-logo"><img src="<?php echo get_template_directory_uri() ?>/images/kryptoslogo.png" height="53px"/></a>
                            <div class="right hide-on-med-and-down"> 
                                <ul class="tabs transparent" style="width: 100%; margin-top: -5px;">
                                    <!-- <li class="tab login"><a class="white-text active" href="/login">Login</a></li> -->
                                    <!-- <li class="tab register"><a class="white-text" href="/register">Registro</a></li> -->
                                    <div class="indicator" style="right: 125.5px; left: 0px; background-color: rgb(241,88,42);"></div>
                                    <div class="indicator" style="right: 125.5px; left: 0px;"></div>
                                </ul>
                                <div class="row" style="display: inline; z-index: 80;" >
                                    <a style="color: rgb(241,88,42); display: inline-table;" href="#" data-activates="slide-out" class="button-collapse right"><i class="material-icons">menu</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <?php
            if (is_home()) {
                $args = array(
                    'post__not_in' => $exclude_post_id,
                );
                $my_query = new WP_Query($args);
                $cont = 0;
                if ($my_query->have_posts()) :
                    while ($my_query->have_posts()) :
                        $my_query->the_post();
                        $post = get_post();
                        $thumb_id = get_post_thumbnail_id($post->ID);
                        $thumb_url = wp_get_attachment_url($thumb_id);
                        if (empty($thumb_url)) {
                            if (get_the_post_thumbnail($post->ID) != '') {
                                $thumb_url = the_post_thumbnail();
                            } else {
                                $thumb_url = catch_that_image();
                            }
                            $thumb_url = empty($thumb_url) ? "https://dummyimage.com/562x315/ffffff/43caf7.png&text=Ulama+Labs" : $thumb_url;
                        }
                        if ($cont == 0) {
                            ?>
                            <a href="<?php the_permalink() ?>">
                                <div class="valign-wrapper center" style=" height: 400px; background: url(<?php echo $thumb_url ?>) no-repeat center bottom; background-size:cover;">
                                    <div class="valign" style="width:100%;">  
                                        <div class="row">
                                            <div class="col s12 m8 offset-m2" style="border: 2px solid white; letter-spacing: 4px; ">
                                                <h1 class="feature-title white-text"><?php the_title(); ?></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php
                        } $cont++;
                    endwhile;
                endif;
            }
            ?>
            <script>
                $(document).ready(function () {
                    $(".button-collapse").sideNav();
                })
            </script>
        </header>