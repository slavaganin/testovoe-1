<?php
/**
 * Template Name: Шаблон домашней страницы
 **/
?>

<?php get_header(); ?>

<section class="estate">
    <h1>Последние добавленные объекты недвижимости</h1>
    <div class="row estate-list">

    <?php
    $query = new WP_Query(array(
        'post_type' => 'estate',
        'orderby' => 'date',
        'order'   => 'DESC',
        'posts_per_page' => 10
    ));

    if ( $query->have_posts() ) :
    while ( $query->have_posts() ) : $query->the_post();

    global $post;
    $metaboxes_data = get_post_meta($post->ID, 'estate-metaboxes', true);
    $metaboxes_city = get_post_meta($post->ID, 'estate-city', true);
    ?>

    <div class="col-sm-12 col-md-4 col-lg-3 estate-item">
        <h3 class="estate-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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
    </div>

    <?php endwhile;
    wp_reset_postdata();
    endif; ?>

    </div>
</section>


<section class="cities">
    <h2>Последние добавленные города</h2>
    <ul class="cities-list">

        <?php
        $query = new WP_Query(array(
            'post_type' => 'city',
            'orderby' => 'date',
            'order'   => 'ASC'
        ));

        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                global $post;
                ?>

                <li class="city-item">
                    <h6 class="city-link"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                </li>

            <?php endwhile;
        wp_reset_postdata();
        endif; ?>


    </ul>
</section>


<section class="add-estate">
    <h3>Добавить новый объект недвижимости</h3>
    <form class="form-horizontal" name="form" method="post" enctype="multipart/form-data" action="<?php echo get_stylesheet_directory_uri(); ?>/includes/add-post-frontend.php">
        <input type="hidden" name="ispost" value="1" />
        <input type="hidden" name="userid" value="" />
        <div class="col-md-12">
            <label class="control-label">Заголовок</label>
            <input type="text" class="form-control" name="title" />
        </div>

        <div class="col-md-12">
            <label class="control-label">Описание объекта</label>
            <textarea class="form-control" rows="8" name="content"></textarea>
        </div>

        <div class="col-md-12">
            <label class="control-label">Категория объекта</label>
            <select name="category" class="form-control">
                <?php $catList = get_categories((['taxonomy'     => 'estate-type', 'hide_empty' => false]));
                foreach($catList as $listval)
                {
                    echo '<option value="'.$listval->term_id.'">'.$listval->name.'</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="area-size">Площадь</label>
                    <input type="text" name="area-size" value="">
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="price">Стоимость</label>
                    <input type="text" name="price" value="">
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="address">Адрес</label>
                    <input type="text" name="address" value="">
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="living-area-size">Жилая площадь</label>
                    <input type="text" name="living-area-size" value="">
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="level">Этаж</label>
                    <input type="number" name="level" value="">
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group container">
                <h4>Объект размещен в городе:</h4>
                <?php
                $query = new WP_Query(array(
                    'post_type' => 'city',
                    'orderby' => 'title',
                    'order'   => 'ASC'
                ));
                if ( $query->have_posts() ) :
                    while ( $query->have_posts() ) : $query->the_post();
                        global $post; ?>
                        <input type="radio" id="<?php echo $post->ID; ?>" name="estate-city" value="<?php echo $post->ID; ?>"
                            <?php if ((isset($metaboxes_data)) && ($post->ID == $metaboxes_data)) echo 'checked'?>
                        >
                        <label for="<?php echo $post->ID; ?>"><?php the_title(); ?></label>
                    <?php endwhile;
                endif;
                wp_reset_postdata(); ?>
            </div>
        </div>

        <div class="col-md-12">
            <label class="control-label">Прикрепите изображение</label>
            <input type="file" name="image" class="form-control" />
        </div>

        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" value="Отправить" name="submitpost" />
        </div>
    </form>
</section>



<?php get_footer(); ?>

