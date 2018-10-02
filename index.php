<?php get_header(); ?>

<div class="container home-page">
    <div class="row mt-2">
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="row">
                    <?php
                        if (have_posts()) {
                            while (have_posts()) { 
                                the_post(); ?>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="main-post">
                                        <h4 class="post-title">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h4>
                                        <span class="post-author mr-2"><i class="fa fa-user fa-fw fa-lg"></i><?php the_author_posts_link(); ?>,</span>
                                        <span class="post-date mr-2"><i class="fa fa-calendar fa-fw fa-lg"></i><?php the_time('F j, Y');?>,</span>
                                        <span class="post-comments">
                                            <i class="fa fa-comments fa-fw fa-lg"></i>
                                            <?php comments_popup_link('0 comments', '1 comments', '% comments', 'comments-url', 'comments disabled'); ?>.
                                        </span>
                                        <div class="post-image">
                                            <?php the_post_thumbnail('', ['class' => 'img-responsive img-thumbnail']); ?>
                                        </div>
                                        <p class="lead post-content"><?php /*the_content('Read more...');*/ the_excerpt(); ?></p>
                                        <hr />
                                        <p class="post-categories"><i class="fa fa-tags fa-fw fa-lg"></i>Categories: <?php the_category(', '); ?></p>
                                        <p class="post-tags"><i class="fa fa-key fa-fw fa-lg"></i>
                                            <?php 
                                                if (has_tag()) {
                                                    the_tags();
                                                } else {
                                                    echo 'Tags: no tags.';
                                                }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            <?php
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <?php
                    /*
                    if (is_active_sidebar('main-sidebar')) {
                        dynamic_sidebar('main-sidebar');
                    }
                    */
                    get_sidebar();
                ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <hr class="line-separator" />
    <div class="text-center posts-paginator">
        <?php
            /*
            if (get_previous_posts_link()) {
                previous_posts_link('<i class="fa fa-chevron-left fa-fl"></i> back');
            } else {
                echo '<span>back</span>';
            }

            if (get_next_posts_link()) {
                next_posts_link('next <i class="fa fa-chevron-right fa-fl"></i>');
            } else {
                echo '<span>next</span>';
            }
            */
            get_custom_pagination();
        ?>
    </div>
    <hr class="line-separator" />
</div>

<?php get_footer(); ?>