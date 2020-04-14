<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post();
global $post;

$metaboxes_data = get_post_meta($post->ID, 'estate-metaboxes', true);
$metaboxes_city = get_post_meta($post->ID, 'estate-city', true);
?>

<section class="main">
    <h1 class="estate-title"><?php the_title(); ?></h1>
    <?php the_post_thumbnail(); ?>
    <h4>Характеристики:</h4>
    <ul class="estate-features">
        <?php if (isset($metaboxes_data['area-size']) && ($metaboxes_data['area-size'] != '')) echo '<li>Площадь: ' . $metaboxes_data['area-size'] . '</li>'; ?>
        <?php if (isset($metaboxes_data['price']) && ($metaboxes_data['price'] != '')) echo '<li>Стоимость: ' . $metaboxes_data['price'] . '</li>'; ?>
        <?php if (isset($metaboxes_data['address']) && ($metaboxes_data['address'] != '')) echo '<li>Адрес: ' . $metaboxes_data['address'] . '</li>'; ?>
        <?php if (isset($metaboxes_data['living-area-size']) && ($metaboxes_data['living-area-size'] != '')) echo '<li>Жилая площадь: ' . $metaboxes_data['living-area-size'] . '</li>'; ?>
        <?php if (isset($metaboxes_data['level']) && ($metaboxes_data['level'] != '')) echo '<li>Этаж: ' . $metaboxes_data['level'] . '</li>'; ?>
        <?php
        if (isset($metaboxes_city) && ($metaboxes_city != '')) $city_id = $metaboxes_city;
        echo '<li>Объект размещен в городе: <a href=" ' . get_post_permalink($city_id) . ' "> ' . get_the_title($city_id) . ' </a></li>';
        ?>
    </ul>
</section>


<?php endwhile; ?>
<?php endif; ?>


<?php get_footer(); ?>