<?php get_header(); ?>

<div class="container-md">

    <div class="row">

        <div class="col-md-8 pb-5">

            <!-- Featured Posts -->
            <div class="card bg-body-tertiary">
                <h1 class="px-4 pt-4">Featured</h1>

                <?php
                // Query featured posts
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 1,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'tag'            => 'featured',
                );
                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                ?>

                        <!-- Display each featured post -->
                        <div class="row p-4">
                            <div class="col-md-4">
                                <?php the_post_thumbnail('', array('class' => 'img-fluid border border-secondary-subtle')); ?>
                            </div>
                            <div class="col-md-8">
                                <?php the_title('<h4 class="pt-2"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h4>'); ?>
                                <p><?php the_excerpt(); ?></p>
                                <?php if (has_category()) {
                                    echo '<span class="cat-links">' . get_the_category_list(', ') . '</span>';
                                } ?>
                            </div>
                        </div>

                <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>

            </div> <!--End card-->

            <!-- Main Characters -->
            <div class="card mt-4 bg-body-tertiary">
                <h1 class="p-4">Main Characters</h1>

                <?php
                // Query main character posts
                $tag_slug = 'maincharacter';
                $tagged_posts = new WP_Query(array(
                    'tag'            => $tag_slug,
                    'posts_per_page' => -1,
                ));

                if ($tagged_posts->have_posts()) :
                ?>
                    <div class="row px-4">
                        <?php while ($tagged_posts->have_posts()) : $tagged_posts->the_post(); ?>
                            <div class="col-3">
                                <div class="mb-4 text-center">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail', array('class' => 'card-img-top img-fluid rounded-circle border border-secondary-subtle', 'alt' => get_the_title())); ?>
                                        </a>
                                        <p class="p-2"><?php the_title(); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php
                endif;
                wp_reset_postdata(); // Reset post data to the main query
                ?>
            </div> <!--End card-->

        </div> <!--End col-8-->

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Categories -->
            <h4>Categories</h4>
            <hr>
            <?php
            // Display categories
            $args = array(
                'orderby'    => 'name',
                'order'      => 'ASC',
                'hide_empty' => true,
            );
            $categories = get_categories($args);
            if ($categories) {
                echo '<ul class="list-inline">';
                foreach ($categories as $category) {
                    echo '<li class="list-inline-item">';
                    echo '<div class="bg-body-tertiary">';
                    echo '<p class="p-2 txt12"><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></p>';
                    echo '</div>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No categories found</p>';
            }
            ?>

            <!-- Maps -->
            <h4>Maps</h4>
            <hr>
            <?php
            // Display maps
            $parent_slug = 'maps';
            $parent_page = get_page_by_path($parent_slug);
            if ($parent_page) {
                $child_pages = get_pages(array(
                    'child_of'    => $parent_page->ID,
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
            ?>

            <?php get_template_part('banner'); ?>

        </div> <!--End col-4-->

    </div> <!--End row-->

</div> <!--End container-md-->

<?php get_footer(); ?>