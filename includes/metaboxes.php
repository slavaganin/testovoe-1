<?php
function sg_add_meta()
{
    global $post;
    if (!empty($post)) {

        add_meta_box(
            'estate-metaboxes', // $id
            'Метабоксы объекта недвижимости', // $title
            'display_estate_metaboxes', // $callback
            'estate', // $page
            'normal', // $context
            'high');

        add_meta_box(
            'estate-city', // $id
            'Город объекта недвижимости', // $title
            'display_estate_city_metaboxes', // $callback
            'estate', // $page
            'normal', // $context
            'high');

    }
}





function display_estate_metaboxes()
{
    global $post;
    $metaboxes_data = get_post_meta($post->ID, 'estate-metaboxes', true);
    ?>
    <div class="form-group container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label for="area-size">Площадь</label>
                <input type="text" name="area-size" value="<?php if (isset($metaboxes_data['area-size']) && ($metaboxes_data['area-size'] != '')) echo $metaboxes_data['area-size']; ?>">
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label for="price">Стоимость</label>
                <input type="text" name="price" value="<?php if (isset($metaboxes_data['price']) && ($metaboxes_data['price'] != '')) echo $metaboxes_data['price']; ?>">
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label for="address">Адрес</label>
                <input type="text" name="address" value="<?php if (isset($metaboxes_data['address']) && ($metaboxes_data['address'] != '')) echo $metaboxes_data['address']; ?>">
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label for="living-area-size">Жилая площадь</label>
                <input type="text" name="living-area-size" value="<?php if (isset($metaboxes_data['living-area-size']) && ($metaboxes_data['living-area-size'] != '')) echo $metaboxes_data['living-area-size']; ?>">
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label for="level">Этаж</label>
                <input type="number" name="level" value="<?php if (isset($metaboxes_data['level']) && ($metaboxes_data['level'] != '')) echo $metaboxes_data['level']; ?>">
            </div>
        </div>
    </div>
    <?php
}



function display_estate_city_metaboxes()
{
    global $post;
    $metaboxes_data = get_post_meta($post->ID, 'estate-city', true);
    ?>
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
    <?php
}







function sg_save_meta($post_id, $post, $update)
{
    global $post;
    if (!empty($post)) {

        if (!$update) {
            return;
        }


        $estate_data['area-size'] = sanitize_text_field($_POST['area-size']);
        $estate_data['price'] = sanitize_text_field($_POST['price']);
        $estate_data['address'] = sanitize_text_field($_POST['address']);
        $estate_data['living-area-size'] = sanitize_text_field($_POST['living-area-size']);
        $estate_data['level'] = sanitize_text_field($_POST['level']);

        update_post_meta($post_id, 'estate-metaboxes', $estate_data);

        $estate_city = sanitize_text_field($_POST['estate-city']);

        update_post_meta($post_id, 'estate-city', $estate_city);
    }
}