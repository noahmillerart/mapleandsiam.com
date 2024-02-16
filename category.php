<?php get_header(); ?>

<div class="container-md">

    <?php  
    $category = get_queried_object();
    echo '<h1>' . $category->name . '</h1>'; 
    ?>     

    <hr>

    <div class="row">

        <div class="col-md-8">

            <div class="row">

                <?php 
                while (have_posts()) : the_post(); 
                ?>

                <div class="col-md-4 pb-4">

                    <div class="border border-secondary-subtle bg-body-tertiary">
                        <?php
                        if (has_post_thumbnail()) {
                            echo '<div class="text-center p-2">';
                            echo '<a href="' . get_permalink() . '">';
                            the_post_thumbnail('medium', array('class' => 'border border-secondary-subtle'));
                            echo '</a>';
                            echo '</div>';
                        }
                        ?>

                        <div class="p-2 pb-4">
                            <h4 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        </div>
                    </div>

                </div> <!-- End col-->

                <?php 
                endwhile; 
                ?>

            </div> <!-- End row-->
    
        </div> <!-- End col-md-8-->

        <div class="col-md-4">

            <?php
            $total_pages = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'category__in' => $category->term_id
            ));

            echo '<div class="alert alert-info text-center">';
            echo 'Total items found in "' . $category->name . '": <b>' . $total_pages->found_posts . '</b>';
            echo '</div>';
            ?>

            <h4>Categories</h4>

            <hr>

            <?php
            $args = array(
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => true, // Set to true if you want to hide empty categories
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

            <?php get_template_part('banner'); ?>

        </div>

    </div> <!-- End row-->

    <div class="pagination">
        <?php the_posts_pagination(); ?>
    </div>

</div>

<?php get_footer(); ?>