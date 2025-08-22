<?php
/*
 * Plugin Name: PDF for Elementor Forms + Drag And Drop Template Builder
 * Description: Automatically generate, email and download PDFs with Elementor Forms
 * Plugin URI: https://add-ons.org/plugin/elementor-form-pdf-generator-attachment/
 * Requires Plugins: elementor
 * Author: add-ons.org
 * Version: 6.3.0
 * Requires PHP: 5.6
 * Elementor tested up to: 3.29
 * Elementor pro tested up to: 3.29
 * Author URI: https://add-ons.org/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
if (!defined('YEEPDF_ELEMENTOR_PDF_PLUGIN_PATH')) {
    define( 'YEEPDF_ELEMENTOR_PDF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    define( 'YEEPDF_ELEMENTOR_PDF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    if(!class_exists('Yeepdf_Creator_Builder')) {
        require 'vendor/autoload.php';
        if(!defined('YEEPDF_CREATOR_BUILDER_PATH')) {
            define( 'YEEPDF_CREATOR_BUILDER_PATH', plugin_dir_path( __FILE__ ) );
        }
        if(!defined('YEEPDF_CREATOR_BUILDER_URL')) {
            define( 'YEEPDF_CREATOR_BUILDER_URL', plugin_dir_url( __FILE__ ) );
        }
        class Yeepdf_Creator_Builder {
            function __construct(){
                $dir = new RecursiveDirectoryIterator(YEEPDF_CREATOR_BUILDER_PATH."backend");
                $ite = new RecursiveIteratorIterator($dir);
                $files = new RegexIterator($ite, "/\.php/", RegexIterator::MATCH);
                foreach ($files as $file) {
                    if (!$file->isDir()){
                        require_once $file->getPathname();
                    }
                }
                if (!class_exists('QRcode')) {
                    include_once YEEPDF_CREATOR_BUILDER_PATH."libs/phpqrcode.php";
                }
                include_once YEEPDF_CREATOR_BUILDER_PATH."frontend/index.php";
            }
        }
        new Yeepdf_Creator_Builder;
    }
    class Yeepdf_Creator_Form_Widget_Builder { 
        function __construct(){
            add_action( 'elementor_pro/forms/actions/register', array($this,'register_new_form_actions') );
            include YEEPDF_ELEMENTOR_PDF_PLUGIN_PATH."elementor/index.php";
            include YEEPDF_ELEMENTOR_PDF_PLUGIN_PATH."yeekit/document.php"; 
            register_activation_hook( __FILE__, array($this,'activation') );
        }
        function register_new_form_actions( $form_actions_registrar ) {
            include YEEPDF_ELEMENTOR_PDF_PLUGIN_PATH .'elementor/action-pdf.php';
            include YEEPDF_ELEMENTOR_PDF_PLUGIN_PATH .'elementor/action-download.php';
            $form_actions_registrar->register( new \Superaddons_Pdf_Action_After_Submit() );
            $form_actions_registrar->register( new \Superaddons_Pdf2_Action_After_Submit() );
            $form_actions_registrar->register( new \Superaddons_Pdf3_Action_After_Submit() );
            $form_actions_registrar->register( new \Superaddons_Pdf4_Action_After_Submit() );
            $form_actions_registrar->register( new \Superaddons_Pdf5_Action_After_Submit() );
            $form_actions_registrar->register( new \Superaddons_Pdf6_Action_After_Submit() );
            $form_actions_registrar->register( new \Superaddons_Pdf7_Action_After_Submit() );
            $form_actions_registrar->register( new \Superaddons_Pdf8_Action_After_Submit() );
            $form_actions_registrar->register( new \Superaddons_Pdf9_Action_After_Submit() );
            $form_actions_registrar->register( new \Superaddons_Pdf10_Action_After_Submit() );
            $form_actions_registrar->register( new \Yeepdf_Redirect_Download_PDF_Action_After_Submit() );
        }
        function activation() {
            $check = get_option( "yeepdf_elementor_forms_setup" );
            if( !$check ){           
                $data = file_get_contents(YEEPDF_ELEMENTOR_PDF_PLUGIN_PATH."elementor/form-import.json");
                $my_template = array(
                'post_title'    => "Elementor Form Default",
                'post_content'  => "",
                'post_status'   => 'publish',
                'post_type'     => 'yeepdf'
                );
                $id_template = wp_insert_post( $my_template );
                add_post_meta($id_template,"data_email",$data);      
                add_post_meta($id_template,"_builder_pdf_settings_font_family",'dejavu sans');
                update_option( "yeepdf_elementor_forms_setup",$id_template );     
            } 
        }
    }
    new Yeepdf_Creator_Form_Widget_Builder;
}