<?php get_header(); ?>

<div class="container-md">

    <?php
    while (have_posts()) : the_post();
    ?>

        <header class="entry-header">
            <?php
            $parent_id = wp_get_post_parent_id(get_the_ID());
            $parent_link = get_permalink($parent_id);

            echo '<h1>';
            if ($parent_id) {
                echo '<a href="' . esc_url($parent_link) . '">' . esc_html(get_the_title($parent_id)) . '</a>/';
            }
            the_title();
            echo '</h1>';
            ?>
        </header>
        <hr>

        <div class="row">
            <div class="col-md-8">
                <div class="entry-content">
                    <?php
                    the_content();
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'mswiki'),
                        'after' => '</div>',
                    ));
                    ?>
                </div>
            </div> <!-- end col-md-8 -->

            <div class="col-md-4">
                <?php
                $ancestors = get_post_ancestors(get_the_ID());
                if (is_page('maps') || in_array(get_page_by_path('maps')->ID, $ancestors)) {
                    $parent_slug = 'maps';
                    $parent_page = get_page_by_path($parent_slug);

                    if ($parent_page) {
                        $child_pages = get_pages(array(
                            'child_of' => $parent_page->ID,
                            'sort_column' => 'menu_order',
                        ));

                        if ($child_pages) {
                            echo '<ul class="list-inline">';
                            foreach ($child_pages as $child_page) {
                                echo '<li class="list-inline-item">';
                                echo '<div class="bg-body-tertiary">';
                                echo '<p class="p-2 txt12"><a href="' . get_permalink($child_page->ID) . '">' . esc_html($child_page->post_title) . '</a></p>';
                                echo '</div>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<p>No child pages found.</p>';
                        }
                    } else {
                        echo '<p>Parent page not found.</p>';
                    }
                }

                get_template_part('banner');
                ?>
            </div><!-- end col-md-4 -->
        </div><!-- end row -->

    <?php endwhile; // End of the loop. ?>

</div>

<?php get_footer(); ?>