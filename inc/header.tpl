<!DOCTYPE html>
<html class="no-js" lang="ru-RU">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <!-- <link rel="apple-touch-icon" href="icon.png"> -->
    <!-- Place favicon.ico in the root directory -->

    <!-- include function or replace to footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/assets/jquery.min.js"><\/script>')</script>

    <!-- bootstrap -->
    <link rel="stylesheet" type="text/css" href="/assets/bootstrap.min.css">
    <script src="/assets/bootstrap.min.js"></script>
    <!-- / -->

    <!-- slick -->
    <script type="text/javascript" src="/assets/slick/slick.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/slick/slick.css">
    <!-- / -->

    <!-- fancybox -->
    <script type="text/javascript" src="/assets/fancybox/jquery.fancybox.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/fancybox/jquery.fancybox.min.css">
    <!-- / -->

    <script src="/assets/main.js"></script>
    <link rel="stylesheet" href="/template_styles.css">

    <!-- IE compatibility -->
    <!--[if lt IE 9]>
    <script data-skip-moving="true" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <script data-skip-moving="true">var isIE = true;</script>
    <![endif]-->
    <script data-skip-moving="true">
        var isIE = false /*@cc_on || true @*/;
        if( isIE ) {
            document.createElement( "picture" );
            document.write('<script src="https:\/\/cdnjs.cloudflare.com\/ajax\/libs\/picturefill\/3.0.3\/picturefill.min.js" async><\/script>');
        }

        // if( isIE || /Edge/.test(navigator.userAgent) ) {
        //     document.write(\'<script src="\/assets\/polyfill-svg-uri\/polyfill-svg-uri.min.js" async><\/script>\');
        // }
    </script>
</head>
<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">Вы используете <strong>устаревший</strong> браузер. Пожалуйста <a href="https://browsehappy.com/">обновите ваш браузер</a> для лучшего отображения и безопасности.</p>
    <![endif]-->
    <div id="page" class="site">

        <header class="site-header">
            <!-- <div itemscope itemtype="http://schema.org/LocalBusiness"> -->
                <div class="container">
                    <div class="row head-info">
                        <div class="col-4 logotype">
                            <div class="navbar-brand"></div>
                        </div>
                        <div class="col-4 contacts">
                            <!-- Contacts -->
                        </div>
                        <div class="col-4 callback">
                            <!-- <a href="#" id="get-callback"></a> -->
                        </div>
                    </div><!--.row head-info-->
                </div>

                <!-- <div class="hidden-xs-up">
                    <span itemprop="priceRange">RUB</span>
                </div> -->
            <!-- </div> -->
        </header><!-- .site-header -->

        <section class="site-navigation navbar-default">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <div class="navbar-brand hidden-lg-up text-center text-primary"><a href="/">Brand name</a></div>

                    <!-- <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#site-nav" aria-controls="site-nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button> -->
                    <button class="navbar-toggler hamburger hamburger--elastic" type="button" data-toggle="collapse" data-target="#site-nav" aria-controls="site-nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>

                    <div class="collapse navbar-collapse" id="site-nav">
                        //= ./navbar.tpl

                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </nav>
        </section>