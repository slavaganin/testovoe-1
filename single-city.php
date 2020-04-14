<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post();
global $post;
?>

<?php $city_id = get_the_ID(); ?>

<section class="content">
    <h1><?php the_title(); ?></h1>
    <div class="image"><?php the_post_thumbnail(); ?></div>
    <div class="container"><?php the_content(); ?></div>
</section>


<section class="city-estate-section">
    <h4>Недвижимость, размещенная в городе:</h4>
    <ul class="city-estate-list">
    <?php
    $query = new WP_Query(array(
        'post_type' => 'estate',
        'orderby' => 'date',
        'order'   => 'DESC',
        'posts_per_page' => 10,
        'meta_query' => array(
            array(
                'key'       => 'estate-city',
                'value'     => $city_id
            )
        )
    ));
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            global $post;
            $metaboxes_data = get_post_meta($post->ID, '', true)
            ?>
            <li class="city-estate-item">
                <a href="<?php the_permalink(); ?>" class="city-estate-item-link"><?php the_title(); ?></a>
            </li>


    <?php endwhile;
    endif;
    wp_reset_postdata(); ?>
    </ul>
</section>


<?php endwhile; ?>
<?php endif; ?>


<?php get_footer(); ?>
