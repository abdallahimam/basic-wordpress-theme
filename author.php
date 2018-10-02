<?php get_header(); ?>
<div class="container">
    <div class="author-page">
        <h1 class="text-center profile-header">
            <?php
                if (get_the_author_meta('nickname')) {
                    the_author_meta('nickname');
                } else {
                    echo 'Author';
                }
                echo ' Page';
            ?>
        </h1>
        <div class="author-info">
            <div class="row">
                <div class="col-md-4">
                    <?php
                        echo get_avatar(get_the_author_meta('ID'), 256, '', 'User avatar', array('class' => 'img-responsive img-thumbnail d-block mx-auto'));
                        ?>
                </div>
                <div class="col-md-8">
                    <h5 class="post-author-name mt-2">
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
                    <div class="last-action">
                        <p class="last-post">Last Post: <span></span></p>
                        <p class="last-comment">Last Comment: <span></span></p>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="author-stats">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat">
                        Posts count
                        <span><?php echo count_user_posts(get_the_author_meta('ID')); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat">
                        Comments count
                        <span><?php echo get_comments(array('user_id' => get_the_author_meta('ID'), 'count' => true)) ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat">
                        Total Posts Views
                        <span>0</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat">
                        Else
                        <span>0</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="author-posts">
            <?php
                $posts_per_page = count_user_posts(get_the_author_meta('ID')) < $posts_per_page ? count_user_posts(get_the_author_meta('ID')) : 5;
                $author_posts_args = array(
                    'author'    => get_the_author_meta('ID'),
                    'posts_per_page'    => $posts_per_page
                );
                $author_posts = new WP_Query($author_posts_args);
                if ($author_posts->have_posts()) { ?>
                <h4 class="author-posts-header">Latest [ <?php echo $posts_per_page; ?> ] Posts</h4>
                <?php
                    while ($author_posts->have_posts()) { 
                        $author_posts->the_post(); ?>
                        <div class="author-single-post">
                            <div class="row">
                                <div class="col-sm-12 col-md-3 col-lg-2">
                                    <div class="post-image">
                                        <?php the_post_thumbnail('', ['class' => 'img-responsive img-thumbnail d-block mx-auto']); ?>
                                    </div>
                                </div>
                                <div class="col-md-9 col-lg-10">
                                    <div class="author-main-post">
                                        <h4 class="post-title">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h4>
                                        <span class="post-date mr-2"><i class="fa fa-calendar fa-fw fa-lg"></i><?php the_time('F j, Y');?>,</span>
                                        <span class="post-comments">
                                            <i class="fa fa-comments fa-fw fa-lg"></i>
                                            <?php comments_popup_link('0 comments', '1 comments', '% comments', 'comments-url', 'comments disabled'); ?>.
                                        </span>
                                        <p class="lead post-content"><?php /*the_content('Read more...');*/ the_excerpt(); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php } ?>
            <?php }
            wp_reset_postdata();
            ?>
        </div>
        <?php
            $comments_per_page = 20;
            $author_comments_args = array(
                'user_id' => get_the_author_meta('ID'),
                'status'  => 'approve',
                'number'  => $comments_per_page,
                'post_type' => 'post',
                'post_status' => 'publish'
            );
            $author_comments = get_comments($author_comments_args);
            if ($author_comments) { ?>
                <div class="author-comments">
                    <h3 class="author-comments-header">
                        <?php
                            $all_comments_count = get_comments(array('user_id' => get_the_author_meta('ID'), 'count' => true));
                            $comments_per_page = $all_comments_count < $comments_per_page ? $all_comments_count : 20;
                            echo 'Latest [ ' . $comments_per_page . ' ] comments.';
                        ?>
                    </h3>
                    <?php
                        foreach ($author_comments as $comment) { ?>
                            <div class="author-single-comment">
                                <a class="d-block" href="<?php get_permalink($comment->comment_post_ID); ?>"><?php echo get_the_title($comment->comment_post_ID); ?></a>
                                <span class="d-block"><i class="fa fa-calendar"></i> commented on <?php echo mysql2date('l, F j, Y', $comment->comment_date); ?></span>
                                <p class="comment-content"><?php echo $comment->comment_content; ?></p>
                            </div>
                    <?php } ?>
                </div>
        <?php } ?>
    </div>
</div>
<?php get_footer(); ?>