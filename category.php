<?php get_header(); ?>
<?php
    global $wpdb;

    $cat_ID = get_queried_object()->cat_ID;

    // this query to get the number of comments in the current category.
    $query = "SELECT SUM(p.comment_count) AS count, t.name, t.term_id FROM wp_posts p
    JOIN wp_term_relationships tr ON tr.object_id = p.ID
    JOIN wp_term_taxonomy tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
    JOIN wp_terms t ON t.term_id = tt.term_id
    WHERE t.term_id = $cat_ID
    AND p.post_status = 'publish'
    GROUP BY t.term_id";

    $categories = $wpdb->get_results($query);
    $comments_count = $categories[0]->count;
    $posts_count    = get_queried_object();
?>
<div class="container home-page category-page">
    <?php if (is_category()) { ?>
        <div class="text-center category-info">
            <h1 class="category-title"><?php single_cat_title(); echo ' Category.' ?></h1>
            <div class="category-desc"><?php echo category_description(); ?></div>
            <div class="category-stats">
                <div class="row">
                    <div class="col-md-6">
                        <div class="stat">
                            <p class="category-posts-count">Posts count
                                <span><?php echo get_queried_object()->count;?></span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat">
                            <p class="category-comments-count">Comments count <span><?php echo $comments_count; ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row mt-4">
        <div class="colo-md-8 col-lg-9">
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
        <div class="colo-md-4 col-lg-3">
            <?php get_sidebar(); ?>
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