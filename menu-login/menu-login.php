<?php
/**
 * Plugin Name: Menu Login
 * Plugin URI: https://www.menslaveai.com/
 * Description: Elementor widget for a WooCommerce login icon. Logged-out: icon + optional welcome message + "login" text. Logged-in: avatar or letter fallback + optional welcome message with truncated first name on one line.
 * Version: 1.0.0
 * Author: Jeremy with GPT
 * Author URI: https://www.menslaveai.com/
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'plugins_loaded', function() {

	// Ensure Elementor is active before registering the widget.
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	add_action( 'elementor/widgets/register', function( $widgets_manager ) {

		class Menu_Login_Widget extends \Elementor\Widget_Base {

			public function get_name() {
				return 'menu_login_icon';
			}

			public function get_title() {
				return __( 'Menu Login Icon', 'menu-login' );
			}

			public function get_icon() {
				return 'eicon-lock-user';
			}

			public function get_categories() {
				return [ 'general' ];
			}

			public function get_keywords() {
				return [ 'login', 'icon', 'woo', 'woocommerce', 'account', 'user', 'svg' ];
			}

			protected function register_controls() {

				// CONTENT TAB
				$this->start_controls_section(
					'section_icon_content',
					[
						'label' => __( 'Content', 'menu-login' ),
						'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
					]
				);

				$this->add_control(
					'icon',
					[
						'label'   => __( 'Logged-Out Icon', 'menu-login' ),
						'type'    => \Elementor\Controls_Manager::ICONS,
						'default' => [
							'value'   => 'fas fa-user',
							'library' => 'fa-solid',
						],
					]
				);

				$this->add_control(
					'welcome_message',
					[
						'label'   => __( 'Welcome Message', 'menu-login' ),
						'type'    => \Elementor\Controls_Manager::TEXTAREA,
						'default' => __( 'Welcome ', 'menu-login' ),
					]
				);

				$this->add_control(
					'show_message',
					[
						'label'        => __( 'Show Message?', 'menu-login' ),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'label_on'     => __( 'Show', 'menu-login' ),
						'label_off'    => __( 'Hide', 'menu-login' ),
						'return_value' => 'yes',
						'default'      => 'yes',
					]
				);

				$this->end_controls_section();

				// ICON CONTAINER (Common controls)
				$this->start_controls_section(
					'section_icon_style',
					[
						'label' => __( 'Icon Container', 'menu-login' ),
						'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
					]
				);

				// Responsive margin for the whole login block.
				$this->add_responsive_control(
					'menu_login_margin',
					[
						'label'       => __( 'Login Block Margin', 'menu-login' ),
						'type'        => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units'  => [ 'px', 'em', '%' ],
						'default'     => [
							'top'     => '0',
							'right'   => '0',
							'bottom'  => '0',
							'left'    => '0',
							'unit'    => 'px',
							'isLinked' => false,
						],
						'selectors'   => [
							'{{WRAPPER}} .menu-login-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->end_controls_section();

				// LOGGED OUT ICON STYLE
				$this->start_controls_section(
					'section_logged_out_icon_style',
					[
						'label' => __( 'Logged Out Icon', 'menu-login' ),
						'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
					]
				);

				$this->start_controls_tabs( 'logged_out_icon_tabs' );

					// Normal Tab
					$this->start_controls_tab( 'logged_out_icon_normal', [
						'label' => __( 'Normal', 'menu-login' ),
					] );

					$this->add_control(
						'logged_out_icon_color',
						[
							'label'   => __( 'Icon Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#ffffff',
						]
					);

					$this->add_control(
						'logged_out_icon_background_color',
						[
							'label'     => __( 'Background Color', 'menu-login' ),
							'type'      => \Elementor\Controls_Manager::COLOR,
							'default'   => '#000000',
						]
					);

					$this->add_responsive_control(
						'logged_out_icon_size',
						[
							'label'      => __( 'Icon Size', 'menu-login' ),
							'type'       => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', '%' ],
							'range'      => [
								'px' => [ 'min' => 10, 'max' => 200 ],
								'em' => [ 'min' => 0.5, 'max' => 20 ],
								'%'  => [ 'min' => 5, 'max' => 100 ],
							],
							'default'   => [ 'unit' => 'px', 'size' => 40 ],
						]
					);

					$this->add_responsive_control(
						'logged_out_icon_padding',
						[
							'label'       => __( 'Icon Padding', 'menu-login' ),
							'type'        => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units'  => [ 'px', 'em', '%' ],
							'default'     => [
								'top'    => '0',
								'right'  => '0',
								'bottom' => '0',
								'left'   => '0',
								'unit'   => 'px',
								'isLinked' => false,
							],
						]
					);

					$this->add_control(
						'logged_out_icon_border_radius',
						[
							'label'       => __( 'Border Radius', 'menu-login' ),
							'type'        => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units'  => [ 'px', '%', 'em' ],
							'default'     => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
						]
					);

					$this->add_control(
						'logged_out_icon_border_style',
						[
							'label'     => __( 'Border Style', 'menu-login' ),
							'type'      => \Elementor\Controls_Manager::SELECT,
							'options'   => [
								'none'   => __( 'None', 'menu-login' ),
								'solid'  => __( 'Solid', 'menu-login' ),
								'dashed' => __( 'Dashed', 'menu-login' ),
								'dotted' => __( 'Dotted', 'menu-login' ),
								'double' => __( 'Double', 'menu-login' ),
							],
							'default'   => 'none',
						]
					);

					$this->add_control(
						'logged_out_icon_border_width',
						[
							'label'      => __( 'Border Width', 'menu-login' ),
							'type'       => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em' ],
							'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
						]
					);

					$this->add_control(
						'logged_out_icon_border_color',
						[
							'label'   => __( 'Border Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#000000',
						]
					);

					$this->end_controls_tab();

					// Hover Tab
					$this->start_controls_tab( 'logged_out_icon_hover', [
						'label' => __( 'Hover', 'menu-login' ),
					] );

					$this->add_control(
						'logged_out_icon_hover_color',
						[
							'label'   => __( 'Icon Hover Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#ffffff',
						]
					);

					$this->add_control(
						'logged_out_icon_hover_background_color',
						[
							'label'   => __( 'Icon Hover Background Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#222222',
						]
					);

					$this->add_control(
						'logged_out_icon_hover_border_radius',
						[
							'label'       => __( 'Border Radius (Hover)', 'menu-login' ),
							'type'        => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units'  => [ 'px', '%', 'em' ],
							'default'     => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
						]
					);

					$this->add_control(
						'logged_out_icon_hover_border_style',
						[
							'label'     => __( 'Border Style (Hover)', 'menu-login' ),
							'type'      => \Elementor\Controls_Manager::SELECT,
							'options'   => [
								'none'   => __( 'None', 'menu-login' ),
								'solid'  => __( 'Solid', 'menu-login' ),
								'dashed' => __( 'Dashed', 'menu-login' ),
								'dotted' => __( 'Dotted', 'menu-login' ),
								'double' => __( 'Double', 'menu-login' ),
							],
							'default'   => 'none',
						]
					);

					$this->add_control(
						'logged_out_icon_hover_border_width',
						[
							'label'      => __( 'Border Width (Hover)', 'menu-login' ),
							'type'       => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em' ],
							'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
						]
					);

					$this->add_control(
						'logged_out_icon_hover_border_color',
						[
							'label'   => __( 'Border Color (Hover)', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#000000',
						]
					);

					$this->end_controls_tab();

				$this->end_controls_tabs();

				$this->end_controls_section();

				/**
				 * LOGGED IN LETTER STYLE
				 */
				$this->start_controls_section(
					'section_logged_in_letter_style',
					[
						'label' => __( 'Logged In Letter', 'menu-login' ),
						'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
					]
				);

				$this->start_controls_tabs( 'logged_in_letter_tabs' );

					// Normal tab
					$this->start_controls_tab( 'logged_in_letter_normal', [
						'label' => __( 'Normal', 'menu-login' ),
					] );

					$this->add_control(
						'logged_in_letter_color',
						[
							'label'   => __( 'Letter Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [],
						]
					);

					$this->add_control(
						'logged_in_letter_background_color',
						[
							'label'   => __( 'Background Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#000000',
							'selectors' => [],
						]
					);

					$this->add_responsive_control(
						'logged_in_letter_size',
						[
							'label'      => __( 'Letter Size', 'menu-login' ),
							'type'       => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', '%' ],
							'range'      => [
								'px' => [ 'min' => 10, 'max' => 200 ],
								'em' => [ 'min' => 0.5, 'max' => 20 ],
								'%'  => [ 'min' => 5, 'max' => 100 ],
							],
							'default'   => [ 'unit' => 'px', 'size' => 40 ],
							'selectors' => [],
						]
					);

					$this->add_responsive_control(
						'logged_in_letter_padding',
						[
							'label'       => __( 'Letter Padding', 'menu-login' ),
							'type'        => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units'  => [ 'px', 'em', '%' ],
							'default'     => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
							'selectors'   => [],
						]
					);

					$this->add_control(
						'logged_in_letter_border_radius',
						[
							'label'       => __( 'Border Radius', 'menu-login' ),
							'type'        => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units'  => [ 'px', '%', 'em' ],
							'default'     => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
							'selectors'   => [],
						]
					);

					$this->add_control(
						'logged_in_letter_border_style',
						[
							'label'     => __( 'Border Style', 'menu-login' ),
							'type'      => \Elementor\Controls_Manager::SELECT,
							'options'   => [
								'none'   => __( 'None', 'menu-login' ),
								'solid'  => __( 'Solid', 'menu-login' ),
								'dashed' => __( 'Dashed', 'menu-login' ),
								'dotted' => __( 'Dotted', 'menu-login' ),
								'double' => __( 'Double', 'menu-login' ),
							],
							'default'   => 'none',
							'selectors' => [],
						]
					);

					$this->add_control(
						'logged_in_letter_border_width',
						[
							'label'       => __( 'Border Width', 'menu-login' ),
							'type'        => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units'  => [ 'px', 'em' ],
							'default'     => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
							'selectors'   => [],
						]
					);

					$this->add_control(
						'logged_in_letter_border_color',
						[
							'label'   => __( 'Border Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#000000',
							'selectors' => [],
						]
					);

					$this->end_controls_tab();

					// Hover tab
					$this->start_controls_tab( 'logged_in_letter_hover', [
						'label' => __( 'Hover', 'menu-login' ),
					] );

					$this->add_control(
						'logged_in_letter_hover_color',
						[
							'label'   => __( 'Letter Hover Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [],
						]
					);

					$this->add_control(
						'logged_in_letter_hover_background_color',
						[
							'label'   => __( 'Letter Hover Background Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#222222',
							'selectors' => [],
						]
					);

					$this->add_control(
						'logged_in_letter_hover_border_radius',
						[
							'label'       => __( 'Border Radius (Hover)', 'menu-login' ),
							'type'        => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units'  => [ 'px', '%', 'em' ],
							'default'     => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
							'selectors'   => [],
						]
					);

					$this->add_control(
						'logged_in_letter_hover_border_style',
						[
							'label'     => __( 'Border Style (Hover)', 'menu-login' ),
							'type'      => \Elementor\Controls_Manager::SELECT,
							'options'   => [
								'none'   => __( 'None', 'menu-login' ),
								'solid'  => __( 'Solid', 'menu-login' ),
								'dashed' => __( 'Dashed', 'menu-login' ),
								'dotted' => __( 'Dotted', 'menu-login' ),
								'double' => __( 'Double', 'menu-login' ),
							],
							'default'   => 'none',
							'selectors' => [],
						]
					);

					$this->add_control(
						'logged_in_letter_hover_border_width',
						[
							'label'       => __( 'Border Width (Hover)', 'menu-login' ),
							'type'        => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units'  => [ 'px', 'em' ],
							'default'     => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
							'selectors'   => [],
						]
					);

					$this->add_control(
						'logged_in_letter_hover_border_color',
						[
							'label'   => __( 'Border Color (Hover)', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#000000',
							'selectors' => [],
						]
					);

					$this->end_controls_tab();

				$this->end_controls_tabs();
				$this->end_controls_section();

				/**
				 * MESSAGE TEXT STYLE (Normal/Hover)
				 */
				$this->start_controls_section(
					'section_message_style',
					[
						'label' => __( 'Message Text', 'menu-login' ),
						'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
					]
				);

				$this->start_controls_tabs( 'message_text_tabs' );

					// Normal
					$this->start_controls_tab( 'message_text_normal', [
						'label' => __( 'Normal', 'menu-login' ),
					] );

					$this->add_control(
						'message_text_color',
						[
							'label'   => __( 'Text Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [],
						]
					);

					$this->add_responsive_control(
						'message_text_font_size',
						[
							'label'      => __( 'Font Size', 'menu-login' ),
							'type'       => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', '%' ],
							'range'      => [
								'px' => [ 'min' => 10, 'max' => 100 ],
								'em' => [ 'min' => 0.5, 'max' => 10 ],
								'%'  => [ 'min' => 10, 'max' => 200 ],
							],
							'default' => [ 'unit' => 'px', 'size' => 16 ],
							'selectors' => [],
						]
					);

					$this->end_controls_tab();

					// Hover
					$this->start_controls_tab( 'message_text_hover', [
						'label' => __( 'Hover', 'menu-login' ),
					] );

					$this->add_control(
						'message_text_hover_color',
						[
							'label'   => __( 'Text Hover Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [],
						]
					);

					$this->add_responsive_control(
						'message_text_hover_font_size',
						[
							'label'      => __( 'Font Size (Hover)', 'menu-login' ),
							'type'       => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', '%' ],
							'range'      => [
								'px' => [ 'min' => 10, 'max' => 100 ],
								'em' => [ 'min' => 0.5, 'max' => 10 ],
								'%'  => [ 'min' => 10, 'max' => 200 ],
							],
							'default' => [ 'unit' => 'px', 'size' => 16 ],
							'selectors' => [],
						]
					);

					$this->end_controls_tab();

				$this->end_controls_tabs();
				$this->end_controls_section();

				/**
				 * CUSTOMER NAME STYLE (Normal/Hover)
				 */
				$this->start_controls_section(
					'section_customer_name_style',
					[
						'label' => __( 'Customer Name', 'menu-login' ),
						'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
					]
				);

				$this->start_controls_tabs( 'customer_name_tabs' );

					// Normal
					$this->start_controls_tab( 'customer_name_normal', [
						'label' => __( 'Normal', 'menu-login' ),
					] );

					$this->add_control(
						'customer_name_color',
						[
							'label'   => __( 'Name Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [],
						]
					);

					$this->add_responsive_control(
						'customer_name_font_size',
						[
							'label'      => __( 'Name Font Size', 'menu-login' ),
							'type'       => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', '%' ],
							'range'      => [
								'px' => [ 'min' => 10, 'max' => 100 ],
								'em' => [ 'min' => 0.5, 'max' => 10 ],
								'%'  => [ 'min' => 10, 'max' => 200 ],
							],
							'default' => [ 'unit' => 'px', 'size' => 16 ],
							'selectors' => [],
						]
					);

					$this->end_controls_tab();

					// Hover
					$this->start_controls_tab( 'customer_name_hover', [
						'label' => __( 'Hover', 'menu-login' ),
					] );

					$this->add_control(
						'customer_name_hover_color',
						[
							'label'   => __( 'Name Hover Color', 'menu-login' ),
							'type'    => \Elementor\Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [],
						]
					);

					$this->add_responsive_control(
						'customer_name_hover_font_size',
						[
							'label'      => __( 'Name Font Size (Hover)', 'menu-login' ),
							'type'       => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', '%' ],
							'range'      => [
								'px' => [ 'min' => 10, 'max' => 100 ],
								'em' => [ 'min' => 0.5, 'max' => 10 ],
								'%'  => [ 'min' => 10, 'max' => 200 ],
							],
							'default' => [ 'unit' => 'px', 'size' => 16 ],
							'selectors' => [],
						]
					);

					$this->end_controls_tab();

				$this->end_controls_tabs();
				$this->end_controls_section();
			}

			protected function render() {
				$settings = $this->get_settings_for_display();
				
				// Generate a unique wrapper class.
				$wrapper_class = 'menu-login-wrapper-' . $this->get_id();
				
				// Determine link based on login status.
				if ( function_exists( 'is_user_logged_in' ) && is_user_logged_in() ) {
					$icon_link = function_exists( 'wc_get_account_endpoint_url' )
						? wc_get_account_endpoint_url( 'dashboard' )
						: wp_logout_url();
				} else {
					$icon_link = function_exists( 'wc_get_page_permalink' )
						? wc_get_page_permalink( 'myaccount' )
						: wp_login_url();
				}
				
				// If logged in, prepare truncated name.
				if ( is_user_logged_in() ) {
					$user_id   = get_current_user_id();
					$user_data = get_userdata( $user_id );
					$first_name = isset( $user_data->first_name ) ? $user_data->first_name : '';
					$customer_name = ( mb_strlen( $first_name ) > 20 ) ? mb_substr( $first_name, 0, 17 ) . '...' : $first_name;
				}
				
				// Build a dynamic CSS block from all the control settings.
				ob_start();
				?>
				<style>
				/* Login Block Margin */
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-wrapper {
					margin: <?php echo esc_html( $settings['menu_login_margin']['top'] . $settings['menu_login_margin']['unit'] . ' ' . $settings['menu_login_margin']['right'] . $settings['menu_login_margin']['unit'] . ' ' . $settings['menu_login_margin']['bottom'] . $settings['menu_login_margin']['unit'] . ' ' . $settings['menu_login_margin']['left'] . $settings['menu_login_margin']['unit'] ); ?>;
				}
				
				/* Logged Out Icon - Normal */
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-icon.unlogged {
					background-color: <?php echo esc_html( $settings['logged_out_icon_background_color'] ); ?>;
					width: <?php echo esc_html( $settings['logged_out_icon_size']['size'] . $settings['logged_out_icon_size']['unit'] ); ?>;
					height: <?php echo esc_html( $settings['logged_out_icon_size']['size'] . $settings['logged_out_icon_size']['unit'] ); ?>;
					padding: <?php echo esc_html( $settings['logged_out_icon_padding']['top'] . $settings['logged_out_icon_padding']['unit'] . ' ' . $settings['logged_out_icon_padding']['right'] . $settings['logged_out_icon_padding']['unit'] . ' ' . $settings['logged_out_icon_padding']['bottom'] . $settings['logged_out_icon_padding']['unit'] . ' ' . $settings['logged_out_icon_padding']['left'] . $settings['logged_out_icon_padding']['unit'] ); ?>;
					border-radius: <?php echo esc_html( $settings['logged_out_icon_border_radius']['top'] . $settings['logged_out_icon_border_radius']['unit'] . ' ' . $settings['logged_out_icon_border_radius']['right'] . $settings['logged_out_icon_border_radius']['unit'] . ' ' . $settings['logged_out_icon_border_radius']['bottom'] . $settings['logged_out_icon_border_radius']['unit'] . ' ' . $settings['logged_out_icon_border_radius']['left'] . $settings['logged_out_icon_border_radius']['unit'] ); ?>;
					border-style: <?php echo esc_html( $settings['logged_out_icon_border_style'] ); ?>;
					border-width: <?php echo esc_html( $settings['logged_out_icon_border_width']['top'] . $settings['logged_out_icon_border_width']['unit'] . ' ' . $settings['logged_out_icon_border_width']['right'] . $settings['logged_out_icon_border_width']['unit'] . ' ' . $settings['logged_out_icon_border_width']['bottom'] . $settings['logged_out_icon_border_width']['unit'] . ' ' . $settings['logged_out_icon_border_width']['left'] . $settings['logged_out_icon_border_width']['unit'] ); ?>;
					border-color: <?php echo esc_html( $settings['logged_out_icon_border_color'] ); ?>;
				}
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-icon.unlogged .menu-login-svg-icon {
					fill: <?php echo esc_html( $settings['logged_out_icon_color'] ); ?> !important;
				}
				/* Logged Out Icon - Hover */
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-link:hover .menu-login-icon.unlogged {
					background-color: <?php echo esc_html( $settings['logged_out_icon_hover_background_color'] ); ?>;
					border-radius: <?php echo esc_html( $settings['logged_out_icon_hover_border_radius']['top'] . $settings['logged_out_icon_hover_border_radius']['unit'] . ' ' . $settings['logged_out_icon_hover_border_radius']['right'] . $settings['logged_out_icon_hover_border_radius']['unit'] . ' ' . $settings['logged_out_icon_hover_border_radius']['bottom'] . $settings['logged_out_icon_hover_border_radius']['unit'] . ' ' . $settings['logged_out_icon_hover_border_radius']['left'] . $settings['logged_out_icon_hover_border_radius']['unit'] ); ?>;
					border-style: <?php echo esc_html( $settings['logged_out_icon_hover_border_style'] ); ?>;
					border-width: <?php echo esc_html( $settings['logged_out_icon_hover_border_width']['top'] . $settings['logged_out_icon_hover_border_width']['unit'] . ' ' . $settings['logged_out_icon_hover_border_width']['right'] . $settings['logged_out_icon_hover_border_width']['unit'] . ' ' . $settings['logged_out_icon_hover_border_width']['bottom'] . $settings['logged_out_icon_hover_border_width']['unit'] . ' ' . $settings['logged_out_icon_hover_border_width']['left'] . $settings['logged_out_icon_hover_border_width']['unit'] ); ?>;
					border-color: <?php echo esc_html( $settings['logged_out_icon_hover_border_color'] ); ?>;
				}
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-link:hover .menu-login-icon.unlogged .menu-login-svg-icon {
					fill: <?php echo esc_html( $settings['logged_out_icon_hover_color'] ); ?> !important;
				}
				
				/* Logged In Letter - Normal */
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-icon.loggedin-fallback {
					color: <?php echo esc_html( $settings['logged_in_letter_color'] ); ?>;
					background-color: <?php echo esc_html( $settings['logged_in_letter_background_color'] ); ?>;
					width: <?php echo esc_html( $settings['logged_in_letter_size']['size'] . $settings['logged_in_letter_size']['unit'] ); ?>;
					height: <?php echo esc_html( $settings['logged_in_letter_size']['size'] . $settings['logged_in_letter_size']['unit'] ); ?>;
					padding: <?php echo esc_html( $settings['logged_in_letter_padding']['top'] . $settings['logged_in_letter_padding']['unit'] . ' ' . $settings['logged_in_letter_padding']['right'] . $settings['logged_in_letter_padding']['unit'] . ' ' . $settings['logged_in_letter_padding']['bottom'] . $settings['logged_in_letter_padding']['unit'] . ' ' . $settings['logged_in_letter_padding']['left'] . $settings['logged_in_letter_padding']['unit'] ); ?>;
					border-radius: <?php echo esc_html( $settings['logged_in_letter_border_radius']['top'] . $settings['logged_in_letter_border_radius']['unit'] . ' ' . $settings['logged_in_letter_border_radius']['right'] . $settings['logged_in_letter_border_radius']['unit'] . ' ' . $settings['logged_in_letter_border_radius']['bottom'] . $settings['logged_in_letter_border_radius']['unit'] . ' ' . $settings['logged_in_letter_border_radius']['left'] . $settings['logged_in_letter_border_radius']['unit'] ); ?>;
					border-style: <?php echo esc_html( $settings['logged_in_letter_border_style'] ); ?>;
					border-width: <?php echo esc_html( $settings['logged_in_letter_border_width']['top'] . $settings['logged_in_letter_border_width']['unit'] . ' ' . $settings['logged_in_letter_border_width']['right'] . $settings['logged_in_letter_border_width']['unit'] . ' ' . $settings['logged_in_letter_border_width']['bottom'] . $settings['logged_in_letter_border_width']['unit'] . ' ' . $settings['logged_in_letter_border_width']['left'] . $settings['logged_in_letter_border_width']['unit'] ); ?>;
					border-color: <?php echo esc_html( $settings['logged_in_letter_border_color'] ); ?>;
				}
				/* Logged In Letter - Hover */
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-link:hover .menu-login-icon.loggedin-fallback {
					color: <?php echo esc_html( $settings['logged_in_letter_hover_color'] ); ?>;
					background-color: <?php echo esc_html( $settings['logged_in_letter_hover_background_color'] ); ?>;
					border-radius: <?php echo esc_html( $settings['logged_in_letter_hover_border_radius']['top'] . $settings['logged_in_letter_hover_border_radius']['unit'] . ' ' . $settings['logged_in_letter_hover_border_radius']['right'] . $settings['logged_in_letter_hover_border_radius']['unit'] . ' ' . $settings['logged_in_letter_hover_border_radius']['bottom'] . $settings['logged_in_letter_hover_border_radius']['unit'] . ' ' . $settings['logged_in_letter_hover_border_radius']['left'] . $settings['logged_in_letter_hover_border_radius']['unit'] ); ?>;
					border-style: <?php echo esc_html( $settings['logged_in_letter_hover_border_style'] ); ?>;
					border-width: <?php echo esc_html( $settings['logged_in_letter_hover_border_width']['top'] . $settings['logged_in_letter_hover_border_width']['unit'] . ' ' . $settings['logged_in_letter_hover_border_width']['right'] . $settings['logged_in_letter_hover_border_width']['unit'] . ' ' . $settings['logged_in_letter_hover_border_width']['bottom'] . $settings['logged_in_letter_hover_border_width']['unit'] . ' ' . $settings['logged_in_letter_hover_border_width']['left'] . $settings['logged_in_letter_hover_border_width']['unit'] ); ?>;
					border-color: <?php echo esc_html( $settings['logged_in_letter_hover_border_color'] ); ?>;
					width: <?php echo esc_html( $settings['logged_in_letter_size']['size'] . $settings['logged_in_letter_size']['unit'] ); ?>;
					height: <?php echo esc_html( $settings['logged_in_letter_size']['size'] . $settings['logged_in_letter_size']['unit'] ); ?>;
					font-size: <?php echo esc_html( $settings['logged_in_letter_size']['size'] . $settings['logged_in_letter_size']['unit'] ); ?>;
				}
				
				/* Message Text - Normal */
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-message {
					color: <?php echo esc_html( $settings['message_text_color'] ); ?>;
					font-size: <?php echo esc_html( $settings['message_text_font_size']['size'] . $settings['message_text_font_size']['unit'] ); ?>;
				}
				/* Message Text - Hover */
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-link:hover .menu-login-message {
					color: <?php echo esc_html( $settings['message_text_hover_color'] ); ?>;
					font-size: <?php echo esc_html( $settings['message_text_hover_font_size']['size'] . $settings['message_text_hover_font_size']['unit'] ); ?>;
				}
				
				/* Customer Name (if logged in) - Normal */
				<?php if ( is_user_logged_in() ) : ?>
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-user-name {
					color: <?php echo esc_html( $settings['customer_name_color'] ); ?>;
					font-size: <?php echo esc_html( $settings['customer_name_font_size']['size'] . $settings['customer_name_font_size']['unit'] ); ?>;
				}
				/* Customer Name - Hover */
				.<?php echo esc_html( $wrapper_class ); ?> .menu-login-link:hover .menu-login-user-name {
					color: <?php echo esc_html( $settings['customer_name_hover_color'] ); ?>;
					font-size: <?php echo esc_html( $settings['customer_name_hover_font_size']['size'] . $settings['customer_name_hover_font_size']['unit'] ); ?>;
				}
				<?php endif; ?>
				</style>
				<?php
				$dynamic_css = ob_get_clean();
				// Output the dynamic style block.
				echo $dynamic_css;
				
				?>
				<div class="menu-login-wrapper <?php echo esc_attr( $wrapper_class ); ?>" style="display:inline-flex;align-items:center;gap:8px;">
					<a href="<?php echo esc_url( $icon_link ); ?>" class="menu-login-link" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
						<?php
						if ( is_user_logged_in() ) {
							$avatar_url = get_avatar_url( $user_id, [ 'default' => '404' ] );
							if ( false !== strpos( $avatar_url, '404' ) ) {
								$letter = ( ! empty( $user_data->first_name ) ) ? strtoupper( mb_substr( $user_data->first_name, 0, 1 ) ) : '?';
								?>
								<span class="menu-login-icon loggedin-fallback"><?php echo esc_html( $letter ); ?></span>
								<?php
							} else {
								?>
								<span class="menu-login-icon">
									<?php echo get_avatar( $user_id, 96, '404', 'Avatar', [ 'class' => 'menu-login-svg-icon avatar-img' ] ); ?>
								</span>
								<?php
							}
						} else {
							?>
							<span class="menu-login-icon unlogged">
								<?php
								if ( ! empty( $settings['icon'] ) ) {
									\Elementor\Icons_Manager::render_icon(
										$settings['icon'],
										[
											'aria-hidden' => 'true',
											'class'       => 'menu-login-svg-icon',
										],
										'i'
									);
								}
								?>
							</span>
							<?php
						}
						
						if ( 'yes' === $settings['show_message'] ) {
							if ( is_user_logged_in() ) {
								?>
								<span class="menu-login-message menu-login-welcome"><?php echo esc_html( $settings['welcome_message'] ); ?></span>
								<span class="menu-login-message menu-login-user-name"><?php echo esc_html( $customer_name ); ?></span>
								<?php
							} else {
								?>
								<span class="menu-login-message menu-login-welcome"><?php echo esc_html( $settings['welcome_message'] ); ?></span>
								<span class="menu-login-message menu-login-login-text"><?php echo esc_html( 'login' ); ?></span>
								<?php
							}
						}
						?>
					</a>
				</div>
				<?php
			}
		}

		$widgets_manager->register( new Menu_Login_Widget() );
	});
});
