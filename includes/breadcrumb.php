<?php
    $all_cats = get_the_category();
?>
<div class="breadcrumb-holder">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo esc_url(get_home_url()); ?>" target="_blank" rel="noopener noreferrer"><?php echo get_bloginfo('name'); ?></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo esc_url(get_category_link($all_cats[0]->term_id)); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo $all_cats[0]->name; ?>
                </a>
            </li>
            <li class="breadcrumb-item">
                <?php echo get_the_title(); ?>
            </li>
        </ol>
    </div>
</div>