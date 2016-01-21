<?php
// echo '<script>console.log("this is landing-details.php");</script>';
if( function_exists('register_field_group') ):
    // echo '<script>console.log("function_exists when running landing-details.php; running register_field_group()");</script>';
    register_field_group(array (
        'key' => 'group_568d53be457ab',
        'title' => 'Landing Details',
        'fields' => array (
            array (
                'key' => 'field_568d56bd6feff',
                'label' => 'Page Heading',
                'name' => 'show_heading',
                'type' => 'checkbox',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => ''
                ),
                'choices' => array (
                    'Show the page heading' => 'Show the page heading'
                ),
                'default_value' => array (

                ),
                'layout' => 'vertical',
                'toggle' => 0
            ),
            array (
                'key' => 'field_568d56bd6fefe',
                'label' => 'Carousel Slider',
                'name' => 'show_slider',
                'type' => 'checkbox',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => ''
                ),
                'choices' => array (
                    'Show a carousel slider' => 'Show a carousel slider'
                ),
                'default_value' => array (

                ),
                'layout' => 'vertical',
                'toggle' => 0
            ),
            array (
                'key' => 'field_568d57386feff',
                'label' => 'Select Carousel Slider',
                'name' => 'select_slider',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array (
                    array (
                        array (
                            'field' => 'field_568d56bd6fefe',
                            'operator' => '==',
                            'value' => 'Show a carousel slider'
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => ''
                ),
                'post_type' => array (
                    'soliloquy'
                ),
                'taxonomy' => array (

                ),
                'allow_null' => 0,
                'multiple' => 0,
                'return_format' => 'object',
                'ui' => 1
            ),
            array (
                'key' => 'field_568d57b96ff00',
                'label' => 'Main Content',
                'name' => 'main_content',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => ''
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1
            ),
            array (
                'key' => 'field_568d57f26ff01',
                'label' => 'Summarized Content',
                'name' => 'repeating_content',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => ''
                ),
                'min' => 0,
                'max' => '',
                'layout' => 'table',
                'button_label' => 'Add Row',
                'sub_fields' => array (
                    array (
                        'key' => 'field_5696d026feb7e',
                        'label' => 'Left',
                        'name' => 'left',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'min' => '',
                        'max' => 1,
                        'layout' => 'block',
                        'button_label' => 'Entry',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_5697bcc116d76',
                                'label' => 'Image, 485px wide',
                                'name' => 'image',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array (
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'url',
                                'preview_size' => 'thumbnail',
                                'library' => 'all',
                                'min_width' => '',
                                'min_height' => '',
                                'min_size' => '',
                                'max_width' => '',
                                'max_height' => '',
                                'max_size' => '',
                                'mime_types' => '',
                            ),
                            array (
                                'key' => 'field_5697bd5e16d77',
                                'label' => 'Description',
                                'name' => 'description',
                                'type' => 'wysiwyg',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array (
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'tabs' => 'visual',
                                'toolbar' => 'basic',
                                'media_upload' => 0,
                            ),
                        ),
                    ),
                    array (
                        'key' => 'field_5696d127feb7f',
                        'label' => 'Right',
                        'name' => 'right',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'min' => '',
                        'max' => 1,
                        'layout' => 'block',
                        'button_label' => 'Entry',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_5697bfd9a87f5',
                                'label' => 'Image, 485px wide',
                                'name' => 'image',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array (
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'url',
                                'preview_size' => 'thumbnail',
                                'library' => 'all',
                                'min_width' => '',
                                'min_height' => '',
                                'min_size' => '',
                                'max_width' => '',
                                'max_height' => '',
                                'max_size' => '',
                                'mime_types' => '',
                            ),
                            array (
                                'key' => 'field_5697c006a87f6',
                                'label' => 'Description',
                                'name' => 'description',
                                'type' => 'wysiwyg',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array (
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'tabs' => 'visual',
                                'toolbar' => 'basic',
                                'media_upload' => 0,
                            ),
                        ),
                    ),
                ),
            ),
            array (
                'key' => 'field_568d58846ff03',
                'label' => 'Lower Content',
                'name' => 'lower_content',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => ''
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1
            )
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => AG_CORE_TEMPLATE_PATH . '/landing.php'
                )
            )
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array (
            'the_content',
            'excerpt',
            'custom_fields',
            'format',
            'featured_image',
            'categories',
            'tags',
            'send-trackbacks'
        ),
        'active' => 1,
        'description' => ''
    ));

endif;