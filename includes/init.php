<?php

function sg_custom_post_types_init()
{

    // Регистрация пользовательского типа записи
    $labels = array(
        'name' => 'Недвижимость',
        'singular_name' => 'Объект',
        'menu_name' => 'Недвижимость',
        'name_admin_bar' => 'Объекты',
        'add_new' => 'Добавить',
        'add_new_item' => 'Добавить объект',
        'new_item' => 'Новый объект',
        'edit_item' => 'Редактировать объект',
        'view_item' => 'Просмотреть объект',
        'all_items' => 'Все объекты',
        'search_items' => 'Искать объекты',
        'parent_item_colon' => '',
        'not_found' => 'Объекты не найдены',
        'not_found_in_trash' => 'Объекты не найдены в корзине'
    );
    $args = array(
        'labels' => $labels,
        'description' => __('Пользовательский тип записи для объектов недвижимости', 'estate'),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'estate'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 20,
        'exclude_from_search' => true,
        'supports' => array('thumbnail', 'editor', 'title'),
        'taxonomies' => array('estate-type')
    );
    register_post_type('estate', $args);



    // Регистрация пользовательского типа записи
    $labels = array(
        'name' => 'Города',
        'singular_name' => 'Город',
        'menu_name' => 'Города',
        'name_admin_bar' => 'Города',
        'add_new' => 'Добавить',
        'add_new_item' => 'Добавить город',
        'new_item' => 'Новый город',
        'edit_item' => 'Редактировать город',
        'view_item' => 'Просмотреть город',
        'all_items' => 'Все города',
        'search_items' => 'Искать города',
        'parent_item_colon' => '',
        'not_found' => 'Города не найдены',
        'not_found_in_trash' => 'Города не найдены в корзине'
    );
    $args = array(
        'labels' => $labels,
        'description' => __('Пользоавтельский тип записи для городов', 'city'),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'city'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 20,
        'exclude_from_search' => true,
        'supports' => array('thumbnail', 'editor', 'title'),
        'taxonomies' => array()
    );
    register_post_type('city', $args);

}







function sg_custom_taxonomies_init(){

    // список параметров: wp-kama.ru/function/get_taxonomy_labels
    register_taxonomy( 'estate-type', [ 'estate' ], [
        'label'                 => 'estate-type', // определяется параметром $labels->name
        'labels'                => [
            'name'              => 'Тип недвижимости',
            'singular_name'     => 'Тип недвижимости',
            'search_items'      => 'Поиск типов недвижимости',
            'all_items'         => 'Все типы недвижимости',
            'view_item '        => 'Просмотр типа недвижимости',
            'parent_item'       => 'Родительский тип недвижимости',
            'parent_item_colon' => 'Родительские типы недвижимости:',
            'edit_item'         => 'Редактировать тип недвижимости',
            'update_item'       => 'Обновить тип недвижимости',
            'add_new_item'      => 'Добавить новый тип недвижимости',
            'new_item_name'     => 'Имя нового типа недвижимости',
            'menu_name'         => 'Типы недвижимости',
        ],
        'description'           => 'Пользовательская таксономия для типов недвижимости', // описание таксономии
        'public'                => true,
        // 'publicly_queryable'    => null, // равен аргументу public
        // 'show_in_nav_menus'     => true, // равен аргументу public
        // 'show_ui'               => true, // равен аргументу public
        // 'show_in_menu'          => true, // равен аргументу show_ui
        // 'show_tagcloud'         => true, // равен аргументу show_ui
        // 'show_in_quick_edit'    => null, // равен аргументу show_ui
        'hierarchical'          => true,

        'rewrite'               => true,
        //'query_var'             => $taxonomy, // название параметра запроса
        'capabilities'          => array(),
        'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
        'show_in_rest'          => null, // добавить в REST API
        'rest_base'             => null, // $taxonomy
        // '_builtin'              => false,
        //'update_count_callback' => '_update_post_term_count',
    ] );

}
