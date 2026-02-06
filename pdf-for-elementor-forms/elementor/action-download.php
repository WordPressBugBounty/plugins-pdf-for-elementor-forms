<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly
use Elementor\Controls_Manager;
/**
 * Elementor form ping action.
 *
 * Custom Elementor form action which will ping an external server.
 *
 * @since 1.0.0
 */
class Yeepdf_Redirect_Download_PDF_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {
	/**
	 * Get action name.
	 *
	 * Retrieve ping action name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'yeepdf_redirect_pdf';
	}

	/**
	 * Get action label.
	 *
	 * Retrieve ping action label.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Redirect Download PDF', 'elementor-forms-ping-action' );
	}
	protected function get_control_id( $control_id ) {
        return $control_id;
    }
	protected function get_title() {
        return esc_html__( 'PDF Settings', 'pdf-for-elementor-forms' );
    }
	public function register_settings_section( $widget ) {
		$widget->start_controls_section(
			'section_redirect_pdf',
			[
				'label' => esc_html__( 'Redirect Download PDF', 'elementor-pro' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);
        $widget->end_controls_section();
	}
	public function run( $record, $ajax_handler ) {
        $redirect_to = do_shortcode( "[pdf_download]");
        if($redirect_to != ""){
            $redirect_tos = explode(",",$redirect_to);
            $redirect_to = $redirect_tos[0];
        }
        $ajax_handler->add_response_data( 'redirect_url', $redirect_to);
    }
	public function on_export( $element ) {
        
    }

}