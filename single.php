<?php get_header(); ?>

<div class="container-md">
    <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>

        <?php
        $categories = get_the_category();

        if ($categories) {
            echo '<p>';
            $category_count = count($categories);
            $i = 1;
            foreach ($categories as $category) {
                echo esc_html($category->name);
                if ($i < $category_count) {
                    echo ' / ';
                }
                $i++;
            }
            echo '</p>';
        }
        ?>

        <hr class="my-4">

        <div class="row">
            <div class="col-md-8 pb-5">
                <?php the_content(); ?>
            </div>
            <div class="col-md-4">
                <div class="container-fluid border border-secondary-subtle p-2 infobox bg-body-tertiary">

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="container-fluid p-2 mb-3">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    $custom_fields = get_post_meta(get_the_ID());

                    ksort($custom_fields);

                    if (!empty($custom_fields)) {

                        foreach ($custom_fields as $key => $value) {

                            if (substr($key, 0, 1) !== '_') {
                                echo '<div class="row infolink p-2">';
                                echo '<div class="col"><strong>' . esc_html($key) . ':</strong></div>';
                                echo '<div class="col">' . esc_html($value[0]) . '</div>';
                                echo '</div>';
                            }
                        }
                    }
                    ?>

                    <hr>

                    <div class="row infolink p-2">
                        <div class="col">
                            <b><?php esc_html_e('Categories:', 'mswiki'); ?></b>
                        </div>
                        <div class="col">
                            <?php the_category('<br>'); ?>
                        </div>
                    </div>

                </div>

                <?php get_template_part('banner'); ?>

            </div>
        </div>

        <footer></footer>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>