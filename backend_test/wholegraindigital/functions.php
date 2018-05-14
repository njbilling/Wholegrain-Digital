<?php

// Recipes custom post type function
function create_recipes_posttype() {

    register_post_type( 'recipes',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Recipes' ),
                'singular_name' => __( 'Recipe' ),
                'add_new' => __('Add New Recipe'),
                'add_new_item' => __('Add New Recipe'),
                'edit_item' => __('Edit Recipe'),
                'new_item' => __('New Recipe'),
                'view_item' => __('View Recipe'),
                'view_items' => __('View Recipes'),
                'search_items' => __('Search Recipes')
            ),
            'supports' => array('title', 'editor', 'custom-fields'),
            'taxonomies' => array('category'),
            'public' => true,
            'show_in_rest' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'recipes'),
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_recipes_posttype' );


//Register Ingredients Meta Box for Recipes CPT
add_filter( 'rwmb_meta_boxes', 'recipes_meta_boxes' );
function recipes_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'  => 'Recipe Ingredients',
        'post_types' => 'recipes',
        'context'    => 'normal',
        'priority'   => 'high',
        'fields' => array(
            array(
                'id'   => 'ingredients',
                'name' => 'Ingredients',
                'type' => 'wysiwyg',
                'options' => array(
                    'textarea_rows' => 8,
                ),
            ),
        ),
    );
    return $meta_boxes;
}


// The object type. For custom post types, this is 'post';
// for custom comment types, this is 'comment'. For user meta,
// this is 'user'.
$object_type = 'post';
$args1 = array( // Validate and sanitize the meta value.
    // Note: currently (4.7) one of 'string', 'boolean', 'integer',
    // 'number' must be used as 'type'. The default is 'string'.
    'type'         => 'string',
    // Shown in the schema for the meta key.
    'description'  => 'A meta key associated with a string meta value.',
    // Return a single value of the type.
    'single'       => true,
    // Show in the WP REST API response. Default: false.
    'show_in_rest' => true,
);
register_meta( $object_type, 'ingredients', $args1 );