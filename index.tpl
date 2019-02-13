//= inc/header.tpl

        <section class="breadcrumb">
            <div class="container">
            </div>
        </section>

        <div id="content" class="site-content container">
            <div class="row">
                <aside id="secondary" class="sidebar col-12 col-lg-3 order-lg-2" role="complementary">
                    <h3 class="sidebar__title">Sidebar title</h3>

                    <div class="sidebar__body">
                        <div class="sidebar__text">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>
                    </div>
                </aside>

                <main id="primary" class="main content col-12 col-lg-9" role="main"> <!-- <?php echo ( is_show_sidebar() ) ? "col-9" : "col-12"; ?> -->
                    <h1 class="archive-title">Archive name</h1>
                    <div class="archive-description mb-2">Some any description text here.</div>

                    <div class="row">
                        <article id="post-ID" class="col">
                            <div class="media post">
                                <div class="post__thmb">
                                    <img src="/img/placeholder.png" width="200" height="200" class="pr-3">
                                </div>

                                <div class="media-body article-content">
                                    <h4 class="post__name">Post name</h4>
                                    <div class="post__text">
                                        <div class="two-columns">
                                            <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat.</div>
                                            <div>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                        </div>
                                        <br><a href="#" class="more meta-nav">More..</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div><!-- .row -->

                    <!-- the_template_pagination() -->

                </main><!-- main#primary.col -->

            </div><!-- .row -->

            <div class="slider mt-5">
                <div><a href="/img/placeholder.png" data-fancybox="gallery"><img src="/img/placeholder.png" width="150" class="ac"></a></div>
                <div><a href="/img/placeholder.png" data-fancybox="gallery"><img src="/img/placeholder.png" width="150" class="ac"></a></div>
                <div><a href="/img/placeholder.png" data-fancybox="gallery"><img src="/img/placeholder.png" width="150" class="ac"></a></div>
                <div><a href="/img/placeholder.png" data-fancybox="gallery"><img src="/img/placeholder.png" width="150" class="ac"></a></div>
                <div><a href="/img/placeholder.png" data-fancybox="gallery"><img src="/img/placeholder.png" width="150" class="ac"></a></div>
            </div>
        </div><!-- #content -->

//= inc/footer.tpl
//= inc/end.tpl
