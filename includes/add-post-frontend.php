<?php

require_once("../../../../wp-load.php");

if(isset($_POST['ispost']))

{

    $post_title = $_POST['title'];
    $sample_image = $_FILES['image']['name'];
    $post_content = $_POST['content'];
    $category = $_POST['category'];

    $estate_data['area-size'] = sanitize_text_field($_POST['area-size']);
    $estate_data['price'] = sanitize_text_field($_POST['price']);
    $estate_data['address'] = sanitize_text_field($_POST['address']);
    $estate_data['living-area-size'] = sanitize_text_field($_POST['living-area-size']);
    $estate_data['level'] = sanitize_text_field($_POST['level']);

    $estate_city = sanitize_text_field($_POST['estate-city']);


    $new_post = array(
        'post_title' => $post_title,
        'post_content' => $post_content,
        'post_status' => 'publish',
        'post_type' => 'estate'
    );

    $post_id = wp_insert_post($new_post);

    add_post_meta($post_id, 'estate-metaboxes', $estate_data);
    add_post_meta($post_id, 'estate-city', $estate_city);

    if (!function_exists('wp_generate_attachment_metadata'))
    {
        require_once(__DIR__ . "/../../../../wp-admin/includes/image.php");
        require_once(__DIR__ . "/../../../../wp-admin/includes/file.php");
        require_once(__DIR__ . "/../../../../wp-admin/includes/media.php");
    }
    if ($_FILES)
    {
        foreach ($_FILES as $file => $array)
        {
            if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK)
            {
                return "upload error : " . $_FILES[$file]['error'];
            }
            $attach_id = media_handle_upload( $file, $post_id );
        }
    }
    if ($attach_id > 0)
    {
//and if you want to set that image as Post then use:
        update_post_meta($post_id, '_thumbnail_id', $attach_id);

    }

}


echo 'Спасибо, ваш объект успешно добавлен';

header( "refresh:3;url=http://slava.vegas/demo/wptest1/" );
?>