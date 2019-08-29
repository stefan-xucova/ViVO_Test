<?php
/*
 Plugin Name: Custom Post Types for testsm.vivo.digital
 Description: Adding custom post types for testsm.vivo.digital
 */

function servicesPostType () {
    $labels = array(
        'name' => __('Services'),
        'singular_name' => __('Service'),
        'add_new' => __('Add New Service'),
        'add_new_item' => __('Add New Service'),
        'edit_item' => __('Edit Service'),
        'new_item' => __('Add New Service'),
        'view_item' => __('View Service'),
        'search_items' => __('Search Service'),
        'not_found' => __('No services found'),
        'not_found_in_trash' => __('No services found in trash')
    );

    $supports = array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'comments',
        'revisions',
    );

    $args = array(
        'labels' => $labels,
        'supports' => $supports,
        'public' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'services'),
        'has_archive' => true,
        'menu_position' => 30,
        'register_meta_box_cb' => 'addServicesMeta',
    );
    register_post_type('services', $args);
}
add_action('init', 'servicesPostType');

function addServicesMeta() {
    add_meta_box(
        'titleServicesMeta',
        'Title',
        'titleServicesMeta',
        'services',
        'side',
        'default'
    );
    add_meta_box(
        'descriptionServicesMeta',
        'Description',
        'descriptionServicesMeta',
        'services',
        'side',
        'default'
    );
}

function titleServicesMeta() {
    global $post;
    wp_nonce_field(basename(__FILE__),'services_fields');
    $title = get_post_meta($post->ID, 'title', true);
    echo '<input type="text" name="title" value="'.esc_textarea($title).'"';
}

function descriptionServicesMeta() {
    global $post;
    wp_nonce_field(basename(__FILE__),'services_fields');
    $description = get_post_meta($post->ID, 'description', true);
    echo '<input type="text" name="description" value="'.esc_textarea($description).'"';
}

function saveServicesMeta($post_id, $post) {
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    if (!isset($_POST['title']) || !wp_verify_nonce($_POST['services_fields'], basename(__FILE__))) {
        return $post_id;
    }

    if (!isset($_POST['description']) || !wp_verify_nonce($_POST['services_fields'], basename(__FILE__))) {
        return $post_id;
    }

    $services_meta['title'] = esc_textarea($_POST['title']);
    $services_meta['description'] = esc_textarea($_POST['description']);

    foreach ($services_meta as $key => $value) :
        if ('revision' === $post->post_type) {
            return;
        }
        if (get_post_meta($post_id, $key, false)) {
            update_post_meta($post_id, $key, $value);
        } else {
        add_post_meta($post_id, $key, $value);
        }
        if (!$value) {
        delete_post_meta($post_id, $key);
        }
        endforeach;
}
add_action('save_post', 'saveServicesMeta', 1, 2);

function staffPostType () {
    $labels = array(
        'name' => __('Staff'),
        'singular_name' => __('Staff'),
        'add_new' => __('Add New Staff'),
        'add_new_item' => __('Add New Staff'),
        'edit_item' => __('Edit Staff'),
        'new_item' => __('Add New Staff'),
        'view_item' => __('View Staff'),
        'search_items' => __('Search Staff'),
        'not_found' => __('No staff found'),
        'not_found_in_trash' => __('No staff found in trash')
    );

    $supports = array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'comments',
        'revisions',
    );

    $args = array(
        'labels' => $labels,
        'supports' => $supports,
        'public' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'staff'),
        'has_archive' => true,
        'menu_position' => 30,
        'register_meta_box_cb' => 'addStaffMeta',
    );
    register_post_type('staff', $args);
}
add_action('init', 'staffPostType');

function addStaffMeta() {
    add_meta_box(
        'nameStaffMeta',
        'Name',
        'nameStaffMeta',
        'staff',
        'side',
        'default'
    );

    add_meta_box(
        'imageStaffMeta',
        'Image',
        'imageStaffMeta',
        'staff',
        'side',
        'default'
    );

    add_meta_box(
        'descriptionStaffMeta',
        'Description',
        'descriptionStaffMeta',
        'staff',
        'side',
        'default'
    );
}

function nameStaffMeta() {
    global $post;
    wp_nonce_field(basename(__FILE__),'staff_fields');
    $name = get_post_meta($post->ID, 'name', true);
    echo '<input type="text" name="name" value="'.esc_textarea($name).'"';
}

function imageStaffMeta() {
    global $post;
    wp_nonce_field(basename(__FILE__),'staff_fields');
    $image = get_post_meta($post->ID, 'image', true);
    echo '<input type="text" name="image" value="'.esc_textarea($image).'"';
}

function descriptionStaffMeta() {
    global $post;
    wp_nonce_field(basename(__FILE__),'staff_fields');
    $description = get_post_meta($post->ID, 'description', true);
    echo '<input type="text" name="description" value="'.esc_textarea($description).'"';
}

function saveStaffMeta($post_id, $post) {
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    if (!isset($_POST['name']) || !wp_verify_nonce($_POST['staff_fields'], basename(__FILE__))) {
        return $post_id;
    }

    if (!isset($_POST['image']) || !wp_verify_nonce($_POST['staff_fields'], basename(__FILE__))) {
        return $post_id;
    }

    if (!isset($_POST['description']) || !wp_verify_nonce($_POST['staff_fields'], basename(__FILE__))) {
        return $post_id;
    }


    $staff_meta['name'] = esc_textarea($_POST['name']);
    $staff_meta['image'] = esc_textarea($_POST['image']);
    $staff_meta['description'] = esc_textarea($_POST['description']);


    foreach ($staff_meta as $key => $value) :
        if ('revision' === $post->post_type) {
            return;
        }
        if (get_post_meta($post_id, $key, false)) {
            update_post_meta($post_id, $key, $value);
        } else {
            add_post_meta($post_id, $key, $value);
        }
        if (!$value) {
            delete_post_meta($post_id, $key);
        }
    endforeach;
}
add_action('save_post', 'saveStaffMeta', 1, 2);
?>