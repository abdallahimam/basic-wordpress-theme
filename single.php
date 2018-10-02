<?php get_header(); ?>
<?php include(get_template_directory() . '/includes/breadcrumb.php'); ?>
<div class="container post-page">
    <div class="row mt-2">
        <?php
        if (have_posts()) {
            while (have_posts()) { 
                the_post(); ?>
                <div class="col-sm-12 col-md-8 col-lg-9">
                    <div class="main-post single-post">
                        <?php edit_post_link('Edit <i class="fa fa-pencil"></i>'); ?>
                        <?php edit_post_link('Edit <i class="fa fa-pencil"></i>'); ?>
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
                        <p class="lead post-content"><?php the_content('Read more...'); ?></p>
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
                    <div class="clearfixr"></div>
                    <div class="random-posts">
                        <?php
                            $random_posts_per_page = count_user_posts(get_the_author_meta('ID')) < $random_posts_per_page ? count_user_posts(get_the_author_meta('ID')) : 8;
                            $author_random_posts_args = array(
                                'catagory__in'      => wp_get_post_categories(get_queried_object_id()),
                                'post__not__in'     => array(get_queried_object_id()),
                                'orderby'           => 'rand',
                                'posts_per_page'    => $random_posts_per_page
                            );
                            $author_posts = new WP_Query($author_random_posts_args);
                            if ($author_posts->have_posts()) { ?>
                            <h4 class="random-posts-header">See also</h4>
                            <div class="row">
                                <?php
                                    while ($author_posts->have_posts()) { 
                                        $author_posts->the_post(); ?>
                                        <div class="col-md-3 mb-4">
                                            <div class="single-post">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="post-image">
                                                            <?php the_post_thumbnail('', ['class' => 'img-responsive img-thumbnail d-block mx-auto']); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <h4 class="post-title">
                                                            <a href="<?php the_permalink(); ?>">
                                                                <?php the_title(); ?>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php } ?>
                            </div>
                        <?php }
                        wp_reset_postdata();
                        ?>
                    </div>
                    <div class="clearfixr"></div>
                    <div class="about-author">
                        <div class="row">
                            <div class="col-md-2">
                                <?php
                                echo get_avatar(get_the_author_meta('ID'), 96, '', 'User avatar', array('class' => 'img-responsive img-thumbnail'));
                                ?>
                            </div>
                            <div class="col-md-10">
                                <h5 class="post-author-name">
                                    <?php
                                    if (!get_the_author_meta('first_name') && !get_the_author_meta('last_name')) {
                                        if (get_the_author_meta('nickname')) {
                                            the_author_posts_link();
                                        } else {
                                            echo 'No name';
                                        }
                                    } else {
                                    ?>
                                    <?php
                                        the_author_meta('first_name');
                                    ?>
                                    <?php the_author_meta('last_name'); ?>
                                    <span class="nickname">
                                        <?php
                                        if (get_the_author_meta('nickname')) {
                                            echo '( ';
                                            the_author_posts_link();
                                            echo ' )';
                                        }
                                    }
                                        ?>
                                    </span>
                                </h5>
                                <?php if (get_the_author_meta('description')) { ?>
                                    <p class="post-author-bio"><?php the_author_meta('description'); ?></p>
                                <?php } else { ?>
                                    <p class="post-author-bio"><?php echo 'No bio for the user'; ?></p>
                                <?php } ?>
                                <hr />
                                <div class="author-stats">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="author-posts-count mt-2 mb-1"><span><?php echo count_user_posts(get_the_author_meta('ID')); ?></span> Posts.</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="author-posts-count mt-2 mb-1"><span><?php echo ps_count_user_comments(); ?></span> Comments.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="posts-paginator">
                        <?php
                            echo '<div class="pull-left">';
                            if (get_previous_post_link()) {
                                previous_post_link('%link', '<i class="fa fa-chevron-left fa-fl m-1"></i> %title');
                            } else {
                                echo '<span>back</span>';
                            }
                            echo '</div>';
                            echo '<div class="pull-right">';
                            if (get_next_post_link()) {
                                next_post_link('%link', '%title <i class="fa fa-chevron-right fa-fl m-1"></i>');
                            } else {
                                echo '<span>next</span>';
                            }
                            echo '</div>';
                            ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="comment-separator" />
                    <div class="w-100">
                        <?php comments_template(); ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <?php get_sidebar(); ?>
                </div>
            <?php
            }
        }
        ?>
    </div>
</div>
<?php get_footer(); ?>