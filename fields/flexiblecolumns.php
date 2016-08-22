<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
    'key' => 'group_5772ab01cb984',
    'title' => 'Flexible Columns',
    'fields' => array (
        array (
            'key' => 'field_5775462291edf',
            'label' => 'Show Page Title',
            'name' => 'show_page_title',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => 'spt-class',
                'id' => 'spt_id',
            ),
            'message' => '',
            'default_value' => 1,
        ),
        array (
            'key' => 'field_5772ab6603192',
            'label' => 'Rows',
            'name' => 'rows',
            'type' => 'flexible_content',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'button_label' => 'Add Row',
            'min' => '',
            'max' => '',
            'layouts' => array (
                array (
                    'key' => '5772d76125f4e',
                    'name' => 'full_width',
                    'label' => 'Full Width',
                    'display' => 'row',
                    'sub_fields' => array (
                        array (
                            'key' => 'field_5772d78125f4f',
                            'label' => 'Content',
                            'name' => 'content',
                            'type' => 'wysiwyg',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'tabs' => 'all',
                            'toolbar' => 'full',
                            'media_upload' => 1,
                        ),
                    ),
                    'min' => '',
                    'max' => '',
                ),
                array (
                    'key' => '5772d7c125f50',
                    'name' => 'columns',
                    'label' => 'Columns',
                    'display' => 'row',
                    'sub_fields' => array (
                        array (
                            'key' => 'field_5791001b8659c',
                            'label' => 'Text alignment',
                            'name' => 'text_alignment',
                            'type' => 'select',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'choices' => array (
                                'left' => 'left',
                                'center' => 'center',
                            ),
                            'default_value' => array (
                                0 => 'left',
                            ),
                            'allow_null' => 0,
                            'multiple' => 0,
                            'ui' => 0,
                            'ajax' => 0,
                            'placeholder' => '',
                            'disabled' => 0,
                            'readonly' => 0,
                        ),
                        array (
                            'key' => 'field_5772d80e25f51',
                            'label' => 'Cells',
                            'name' => 'content',
                            'type' => 'repeater',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'collapsed' => '',
                            'min' => 2,
                            'max' => 3,
                            'layout' => 'table',
                            'button_label' => 'Add Cell',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_5773f0c2e6a2c',
                                    'label' => 'Heading',
                                    'name' => 'heading',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array (
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'maxlength' => '',
                                    'readonly' => 0,
                                    'disabled' => 0,
                                ),
                                array (
                                    'key' => 'field_5773f0cbe6a2d',
                                    'label' => 'Image',
                                    'name' => 'columnimage',
                                    'type' => 'image',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array (
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'return_format' => 'array',
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
                                    'key' => 'field_5773f0d5e6a2e',
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
                                    'toolbar' => 'simple_text',
                                    'media_upload' => 0,
                                ),
                                array (
                                    'key' => 'field_5773f0f0e6a2f',
                                    'label' => 'Link',
                                    'name' => 'link',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array (
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'maxlength' => '',
                                    'readonly' => 0,
                                    'disabled' => 0,
                                ),
                            ),
                        ),
                    ),
                    'min' => '',
                    'max' => '',
                ),
                array (
                    'key' => '577bc5ed6e30f',
                    'name' => 'contact_info',
                    'label' => 'Contact Info',
                    'display' => 'row',
                    'sub_fields' => array (
                        array (
                            'key' => 'field_577bc5f86e310',
                            'label' => 'Name',
                            'name' => 'name',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                            'readonly' => 0,
                            'disabled' => 0,
                        ),
                        array (
                            'key' => 'field_577bc5ff6e311',
                            'label' => 'Email',
                            'name' => 'email',
                            'type' => 'email',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                        ),
                        array (
                            'key' => 'field_577bc61f6e312',
                            'label' => 'Phone',
                            'name' => 'phone',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                            'readonly' => 0,
                            'disabled' => 0,
                        ),
                    ),
                    'min' => '',
                    'max' => '',
                ),
                array (
                    'key' => '577bd1973b545',
                    'name' => 'button',
                    'label' => 'Button',
                    'display' => 'row',
                    'sub_fields' => array (
                        array (
                            'key' => 'field_577bd1aa3b546',
                            'label' => 'Text',
                            'name' => 'text',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                            'readonly' => 0,
                            'disabled' => 0,
                        ),
                        array (
                            'key' => 'field_577bd39dda4cf',
                            'label' => 'Link',
                            'name' => 'link',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                            'readonly' => 0,
                            'disabled' => 0,
                        ),
                        array (
                            'key' => 'field_577c13d2a53b7',
                            'label' => 'Alignment',
                            'name' => 'alignment',
                            'type' => 'select',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'choices' => array (
                                'left' => 'left',
                                'center' => 'center',
                                'right' => 'right',
                            ),
                            'default_value' => array (
                                0 => 'left',
                            ),
                            'allow_null' => 0,
                            'multiple' => 0,
                            'ui' => 0,
                            'ajax' => 0,
                            'placeholder' => '',
                            'disabled' => 0,
                            'readonly' => 0,
                        ),
                        array (
                            'key' => 'field_57bb24495c9f4',
                            'label' => 'Font Size',
                            'name' => 'font_size',
                            'type' => 'number',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 1,
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => 'rem',
                            'min' => '0.1',
                            'max' => 150,
                            'step' => '',
                            'readonly' => 0,
                            'disabled' => 0,
                        ),
                    ),
                    'min' => '',
                    'max' => '',
                ),
                array (
                    'key' => '579249285a037',
                    'name' => 'accordion',
                    'label' => 'Accordion',
                    'display' => 'block',
                    'sub_fields' => array (
                        array (
                            'key' => 'field_579249b85a038',
                            'label' => 'Title',
                            'name' => 'accordion_title',
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
                            'toolbar' => 'simple_title',
                            'media_upload' => 0,
                        ),
                        array (
                            'key' => 'field_57924a2f5a039',
                            'label' => 'Content',
                            'name' => 'accordion_content',
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
                            'toolbar' => 'simple_text',
                            'media_upload' => 1,
                        ),
                    ),
                    'min' => '',
                    'max' => '',
                ),
            ),
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'page_template',
                'operator' => '==',
                'value' => AG_CORE_TEMPLATE_PATH . '/flexiblecolumns.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => array (
        0 => 'discussion',
        1 => 'comments',
    ),
    'active' => 1,
    'description' => '',
));

endif;
