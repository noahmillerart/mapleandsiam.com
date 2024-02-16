<?php get_header(); ?>

<div class="container-md">

    <h4><?php printf( esc_html__( 'Search Results for: %s', 'mswiki' ), '<b>' . get_search_query() . '</b>' ); ?></h4>

    <hr>

    <div class="row">

        <div class="col-md-8">

            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>

                    <p><b><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></b><br><?php the_excerpt(); ?></p>
                    <hr class="wp-block-separator">

                <?php endwhile; ?>

                <!-- Pagination -->
                <div class="pagination">
                    <?php echo paginate_links(); ?>
                </div>

            <?php else : ?>

                <p><?php esc_html_e( 'No results found.', 'mswiki' ); ?></p>

            <?php endif; ?>

        </div>

        <div class="col-md-4">
            <div class="alert alert-info text-center">
                
                <?php
                    global $wp_query;
                    $total_results = $wp_query->found_posts;
                    printf( esc_html( 'Total items found: <b>%d</b>', 'mswiki' ), $total_results );
                ?>
                       
            </div>

            <?php get_template_part('banner'); ?>

        </div>

    </div><!-- End row -->

</div> <!-- End container-md -->

<?php get_footer(); ?>