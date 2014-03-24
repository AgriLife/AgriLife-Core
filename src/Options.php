<?php
namespace AgriLife\Core;

class Options {

	public function __construct() {

		add_filter( 'acf/options_page/settings', array( $this, 'options_page_settings' ) );
		add_action( 'init', array( $this, 'create_core_option_fields' ) );
		add_action( 'init', array( $this, 'create_contact_option_fields' ) );

	}

	public function options_page_settings( $settings ) {

		$settings['title']   = 'AgriLife';
		$settings['menu']    = 'AgriLife';
		$settings['pages']   = array( 'AgriLife' );
		$settings['pages'][] = apply_filters( 'agrilife/options/pages', null );

		return $settings;

	}

	public function create_core_option_fields() {

		$fields = array(
			array(
				'key'           => 'field_5330566f30981',
				'label'         => 'Agency Affiliation',
				'name'          => 'agrilife-agency',
				'type'          => 'checkbox',
				'choices'       => array(
					'ext'   => 'Extension',
					'res'   => 'Research',
					'col'   => 'College',
					'tvmdl' => 'TVMDL',
					'tfs'   => 'TFS',
				),
				'default_value' => '',
				'layout'        => 'vertical',
			),
		);

		if ( function_exists( "register_field_group" ) ) {
			register_field_group( array(
				'id'         => 'acf_core-options',
				'title'      => 'Core Options',
				'fields'     => apply_filters( 'agrilife/options/core_fields', $fields ),
				'location'   => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'acf-options-agrilife',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options'    => array(
					'position'       => 'normal',
					'layout'         => 'default',
					'hide_on_screen' => array(),
				),
				'menu_order' => 0,
			) );
		}

	}

	public function create_contact_option_fields() {

		if ( function_exists( 'register_field_group' ) ) {

			$general = array(
				array(
					'key'   => 'field_53305c0b18de8',
					'label' => 'General',
					'name'  => '',
					'type'  => 'tab',
				),
					array(
						'key'           => 'field_5330576ccf1d1',
						'label'         => 'Phone Number',
						'name'          => 'agrilife-contact-phone',
						'type'          => 'text',
						'default_value' => '',
						'placeholder'   => '979-999-7777',
						'prepend'       => '',
						'append'        => '',
						'formatting'    => 'none',
						'maxlength'     => '',
					),
					array(
						'key'           => 'field_533057a4cf1d2',
						'label'         => 'Fax Number',
						'name'          => 'agrilife-contact-fax',
						'type'          => 'text',
						'default_value' => '',
						'placeholder'   => '979-999-7777',
						'prepend'       => '',
						'append'        => '',
						'formatting'    => 'none',
						'maxlength'     => '',
					),
					array(
						'key'           => 'field_533057c7cf1d3',
						'label'         => 'Email Address (public)',
						'name'          => 'agrilife-contact-email',
						'type'          => 'email',
						'default_value' => '',
						'placeholder'   => '',
						'prepend'       => '',
						'append'        => '',
					),
					array(
						'key'           => 'field_5330583ccf1d4',
						'label'         => 'Hours of Operation',
						'name'          => 'agrilife-contact-hours',
						'type'          => 'text',
						'default_value' => '',
						'placeholder'   => 'Mon-Fri 8:00am-5:00pm',
						'prepend'       => '',
						'append'        => '',
						'formatting'    => 'none',
						'maxlength'     => '',
					),
			);

			$general = apply_filters( 'agrilife/options/contact_general_fields', $general );

			$physical_address = array(
				array(
					'key'   => 'field_53305bcee8d73',
					'label' => 'Physical Address',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'     => 'field_53305c68da7d0',
					'label'   => 'PO Note',
					'name'    => '',
					'type'    => 'message',
					'message' => 'This may not be a P.O. Box',
				),
				array(
					'key'           => 'field_53305bdfe8d74',
					'label'         => 'Street 1',
					'name'          => 'agrilife-contact-physical-street-1',
					'type'          => 'text',
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'formatting'    => 'none',
					'maxlength'     => '',
				),
				array(
					'key'           => 'field_53305c57da7cf',
					'label'         => 'Street 2',
					'name'          => 'agrilife-contact-physical-street-2',
					'type'          => 'text',
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'formatting'    => 'none',
					'maxlength'     => '',
				),
				array(
					'key'           => 'field_53305c7eda7d1',
					'label'         => 'City',
					'name'          => 'agrilife-contact-physical-city',
					'type'          => 'text',
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'formatting'    => 'none',
					'maxlength'     => '',
				),
				array(
					'key'           => 'field_53305cb1da7d2',
					'label'         => 'Zip Code',
					'name'          => 'agrilife-contact-physical-zip',
					'type'          => 'text',
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'formatting'    => 'none',
					'maxlength'     => '',
				),
			);

			$physical_address = apply_filters( 'agrilife/options/contact_physical_address_fields', $physical_address );

			$mailing_address = array(
				array(
					'key'   => 'field_53305d03cf8b7',
					'label' => 'Mailing Address',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_53305d1bcf8b8',
					'label'         => 'Same as Physical Address',
					'name'          => 'agrilife-contact-mailing-same',
					'type'          => 'true_false',
					'message'       => '',
					'default_value' => 1,
				),
				array(
					'key'               => 'field_53305d38cf8b9',
					'label'             => 'Street 1',
					'name'              => 'agrilife-contact-mailing-street-1',
					'type'              => 'text',
					'conditional_logic' => array(
						'status'   => 1,
						'rules'    => array(
							array(
								'field'    => 'field_53305d1bcf8b8',
								'operator' => '!=',
								'value'    => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'formatting'        => 'none',
					'maxlength'         => '',
				),
				array(
					'key'               => 'field_53305d4bcf8ba',
					'label'             => 'Street 2',
					'name'              => 'agrilife-contact-mailing-street-2',
					'type'              => 'text',
					'conditional_logic' => array(
						'status'   => 1,
						'rules'    => array(
							array(
								'field'    => 'field_53305d1bcf8b8',
								'operator' => '!=',
								'value'    => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'formatting'        => 'none',
					'maxlength'         => '',
				),
				array(
					'key'               => 'field_53305d56cf8bb',
					'label'             => 'City',
					'name'              => 'agrilife-contact-mailing-city',
					'type'              => 'text',
					'conditional_logic' => array(
						'status'   => 1,
						'rules'    => array(
							array(
								'field'    => 'field_53305d1bcf8b8',
								'operator' => '!=',
								'value'    => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'formatting'        => 'none',
					'maxlength'         => '',
				),
				array(
					'key'               => 'field_53305d64cf8bc',
					'label'             => 'Zip Code',
					'name'              => 'agrilife-contact-mailing-zip',
					'type'              => 'text',
					'conditional_logic' => array(
						'status'   => 1,
						'rules'    => array(
							array(
								'field'    => 'field_53305d1bcf8b8',
								'operator' => '!=',
								'value'    => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'formatting'        => 'none',
					'maxlength'         => '',
				),
			);

			$mailing_address = apply_filters( 'agrilife/options/contact_mailing_address_fields', $mailing_address );

			$default_fields = array_merge( $general, $physical_address, $mailing_address );

			register_field_group( array(
				'id'         => 'acf_contact-information',
				'title'      => 'Contact Information',
				'fields'     => apply_filters( 'agrilife/options/contact_fields', $default_fields ),
				'location'   => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'acf-options-agrilife',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options'    => array(
					'position'       => 'normal',
					'layout'         => 'default',
					'hide_on_screen' => array(),
				),
				'menu_order' => 1,
			) );
		}
	}

}