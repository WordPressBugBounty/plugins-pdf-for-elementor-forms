<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Yeepdf_Setup_Template
{
    function __construct()
    {
        add_action('admin_footer', array($this, 'add_dialog_page'));
    }
    function add_dialog_page()
    {
        global $post;
        $screen = get_current_screen();
        if ($screen && $screen->post_type === 'yeepdf' && in_array($screen->base, array('post', 'post-new'))) {
            $value = apply_filters("yeepdf_setup_id", "", $post->ID);
            $type = apply_filters("yeepdf_setup_type", "");
            $forms = apply_filters("yeepdf_setup_forms", array(), $post->ID);
?>
            <input type="hidden" id="yeepdf-setup-template_id" value="<?php echo esc_attr($value) ?>">
            <input type="hidden" id="yeepdf-setup-type" value="<?php echo esc_attr($type) ?>">
            <div id="yeepdf-setup-template" style="display:none">
                <div class="yeepdf-setup-wrapper">
                    <!-- Top Configuration Card -->
                    <div class="yeepdf-setup-config-card">
                        <div class="yeepdf-setup-form-row">
                            <div class="yeepdf-setup-field-group">
                                <label class="yeepdf-setup-label" for="yeepdf-setup-form-title">
                                    <span class="yeepdf-label-text"><?php esc_html_e("Template Name", 'pdf-for-elementor-forms'); ?></span>
                                    <span class="yeepdf-badge-required"><?php esc_html_e("Required", 'pdf-for-elementor-forms'); ?></span>
                                </label>
                                <div class="yeepdf-input-box">
                                    <span class="yeepdf-input-icon">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </span>
                                    <input id="yeepdf-setup-form-title" class="yeepdf-setup-input" type="text" placeholder="<?php esc_attr_e("e.g. Order Invoice, Registration Form...", 'pdf-for-elementor-forms'); ?>" autofocus autocomplete="off">
                                </div>
                            </div>

                            <div class="yeepdf-setup-field-group">
                                <label class="yeepdf-setup-label" for="yeepdf-setup-form-id">
                                    <span class="yeepdf-label-text"><?php esc_html_e("Target Form", 'pdf-for-elementor-forms'); ?></span>
                                    <span class="yeepdf-badge-required"><?php esc_html_e("Required", 'pdf-for-elementor-forms'); ?></span>
                                </label>
                                <div class="yeepdf-input-box">
                                    <span class="yeepdf-input-icon">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                    </span>
                                    <select id="yeepdf-setup-form-id" class="yeepdf-setup-select">
                                        <?php if (empty($forms)) : ?>
                                            <option value=""><?php esc_html_e("-- Select a Form --", 'pdf-for-elementor-forms'); ?></option>
                                        <?php else : ?>
                                            <?php foreach ($forms as $id => $name) : ?>
                                                <option value="<?php echo esc_attr($id) ?>"><?php echo esc_html($name) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <span class="yeepdf-select-arrow">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Template Selection Banner -->
                    <div class="yeepdf-setup-banner">
                        <div class="yeepdf-setup-banner-info">
                            <h3 class="yeepdf-setup-banner-title"><?php esc_html_e("Select a Starter Template", 'pdf-for-elementor-forms'); ?></h3>
                            <p class="yeepdf-setup-banner-desc"><?php esc_html_e("Choose one of the pre-made templates below to get started quickly, or click Blank to build from scratch.", 'pdf-for-elementor-forms'); ?></p>
                        </div>
                    </div>

                    <!-- Templates Grid -->
                    <div class="list-view-templates yeepdf-setup-grid">
                        <?php
                        $args = array(
                            "json" => "",
                            "img" => YEEPDF_CREATOR_BUILDER_URL . "backend/demo/template1/1.png",
                            "title" => "Email templates",
                            "cat" => array(),
                            "id" => 0,
                        );
                        do_action("builder_yeepdfs"); //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
                        ?>
                    </div>
                </div>
            </div>
<?php
        }
    }
}
new Yeepdf_Setup_Template;
