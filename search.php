<?php
    /**
     * Template Name: Search Page
     */

    global $query_string;

    wp_parse_str( $query_string, $search_query );
    $search_result = new WP_Query( $search_query );
?>

<?php get_header() ?>

<div class="container search-page">
    <div class="row mt-2">
        <div class="col-md-8 col-lg-9">
            <div class="search-results">
                <?php if ( $search_result->have_posts() ) : ?>
                    <header class="page-header">
                        <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'shape' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                        <hr />
                    </header><!-- .page-header -->
                    <?php /* Start the Loop */ ?>
                    <?php while ( $search_result->have_posts() ) : $search_result->the_post(); ?>
                        <div class="search-post">
                            <h3 class="title"><a href="<?php echo get_permalink() ?>"><?php the_title() ?></a></h3>
                            <div class="content"></div>
                            <div class="info"></div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <header class="page-header">
                        <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'shape' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                        <hr />
                    </header><!-- .page-header -->
                    <div class="search-not-found">
                        <p class="error">No results match!!!.</p>
                        <p class="error">Try again, and type a words that you know it exists in the posts to get better results.</p>
                    </div>
                <?php endif; ?>
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

<?php get_footer() ?>