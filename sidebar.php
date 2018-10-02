<?php
    /**
     * get some statistics about blog.
     */
    global $wpdb;

    $comments_count = 0;
    $posts_count    = 0;

    $recent_posts = null;

    if (is_category()) {
        /*
        $categories = get_categories(array(
        'hide_empty'   => 0,
        'hierarchical' => 0,
        'exclude' => '1' //exclude uncategorised
        ));

        // create a comma separated string of category ids
        // used for SQL `WHERE IN ()`
        $category_ids = implode(',', array_map(function($cat) {
        return $cat->term_id;
        }, $categories));

        // this query to get the number of comments in all categories.
        $query_all = "SELECT SUM(p.comment_count) AS count, t.name FROM wp_posts p
        JOIN wp_term_relationships tr ON tr.object_id = p.ID
        JOIN wp_term_taxonomy tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
        JOIN wp_terms t ON t.term_id = tt.term_id
        WHERE t.term_id in ($category_ids)
        AND p.post_status = 'publish'
        GROUP BY t.term_id";
        */

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

        // get latest posts.
        $args = array( 'numberposts' => '5', 'category' => $cat_ID );
        $recent_posts = wp_get_recent_posts( $args );
        
        // get hot posts.
        $hot_posts_args = array(
            'posts_per_page'    => 5,
            'cat'               => $cat_ID,
            'orderby'           => 'comments_count'
        );
        $hot_posts = new WP_query($hot_posts_args);

    } else {
        $comments_count = get_comments(array('count' => true));
        $posts_count = wp_count_posts();

        $args = array( 'numberposts' => '5');
        $recent_posts = wp_get_recent_posts( $args );
        
        // get hot posts.
        $hot_posts_args = array(
            'posts_per_page'    => 5,
            'orderby'           => 'comments_count'
        );
        $hot_posts = new WP_query($hot_posts_args);
    }
?>

<div class="my-sidebar">
    <div class="widgets">
        <div class="widget">
            <h4 class="widget-title">Search</h4>
            <div class="widget-body">
                <?php get_search_form(); ?>
            </div>
        </div>
        <?php if (is_category()) { ?>
            <div class="widget">
                <h4 class="widget-title"><?php echo single_cat_title(); ?> Statistics.</h4>
                <div class="widget-body">
                    <div class="row">
                        <div class="col-6"><p><span><?php echo $posts_count->count; ?></span> posts</p></div>
                        <div class="col-6"><p><span><?php echo $comments_count; ?></span> comments</p></div>
                    </div>
                </div>
            </div>
            <?php if ($recent_posts) { ?>
                <div class="widget">
                    <h4 class="widget-title">Latest <?php echo single_cat_title() ?> Posts.</h4>
                    <div class="widget-body">
                        <ul>
                            <?php foreach($recent_posts as $post) { ?>
                                <li>
                                    <a target="_blank" href="<?php get_permalink($post['ID']) ?>"><?php echo $post['post_title']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php wp_reset_query(); ?>
            <?php } ?>
            <?php if ($hot_posts->have_posts()) { ?>
                <div class="widget">
                    <h4 class="widget-title">Hot <?php echo single_cat_title() ?> Posts.</h4>
                    <div class="widget-body">
                        <ul>
                            <?php while($hot_posts->have_posts()) { ?>
                                <?php $hot_posts->the_post(); ?>
                                <li>
                                    <a target="_blank" href="<?php the_permalink() ?>"><?php echo the_title() ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php wp_reset_query(); ?>
            <?php } ?>
        <?php } else { ?>
            <div class="widget">
                <h4 class="widget-title">Statistics.</h4>
                <div class="widget-body">
                    <div class="row">
                        <div class="col-6"><p><span><?php echo $posts_count->publish; ?></span> posts</p></div>
                        <div class="col-6"><p><span><?php echo $comments_count; ?></span> comments</p></div>
                    </div>
                </div>
            </div>
            <?php if ($recent_posts) { ?>
                <div class="widget">
                    <h4 class="widget-title">Latest <?php echo single_cat_title() ?> Posts.</h4>
                    <div class="widget-body">
                        <ul>
                            <?php foreach($recent_posts as $post) { ?>
                                <li>
                                    <a target="_blank" href="<?php get_permalink($post['ID']) ?>"><?php echo $post['post_title']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php wp_reset_query(); ?>
            <?php } ?>
            <?php if ($hot_posts->have_posts()) { ?>
                <div class="widget">
                    <h4 class="widget-title">Hot <?php echo single_cat_title() ?> Posts.</h4>
                    <div class="widget-body">
                        <ul>
                            <?php while($hot_posts->have_posts()) { ?>
                                <?php $hot_posts->the_post(); ?>
                                <li>
                                    <a target="_blank" href="<?php the_permalink() ?>"><?php echo the_title() ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php wp_reset_query(); ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>
