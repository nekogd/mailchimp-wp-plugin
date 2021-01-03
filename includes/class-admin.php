<?php

class NEKOMC_Admin
{

    /**
     * Registers all hooks
     */
    public function add_hooks()
    {

        // Actions used globally throughout WP Admin
        add_action('admin_menu', array($this, 'build_menu'));
        add_action('admin_init', array($this, 'initialize'));
    }

    /**
     * Initializes various stuff used in WP Admin
     *
     * - Registers settings
     */
    public function initialize()
    {

        // register settings
        register_setting('nekomc_settings', 'nekomc', array($this, 'save_general_settings'));

        // Load upgrader
        // $this->init_upgrade_routines();

        // listen for custom actions
        // $this->listen_for_actions();
    }


    public function build_menu()
    {
        $icon = file_get_contents(NEKOMC_PLUGIN_DIR . 'assets/images/icon.svg');
        add_menu_page('NekoMC settings', 'NekoMC', 'manage_options', 'neko-mc', array($this, 'show_general_settings_page'), 'data:image/svg+xml;base64,' . base64_encode($icon), '99.68491');
    }


    public function show_general_settings_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        $opts      = nekomc_get_options();
		$api_key   = nekomc_get_api_key();
		$lists     = array();
        $connected = ! empty( $api_key );
        
        $obfuscated_api_key = nekomc_obfuscate_string( $api_key );
        require NEKOMC_PLUGIN_DIR . 'views/general-settings.php';
    }


    /**
     * Validates the General settings
     * @param array $settings
     * @return array
     */
    public function save_general_settings(array $settings)
    {
        $current = nekomc_get_options();

        // merge with current settings to allow passing partial arrays to this method
        $settings = array_merge($current, $settings);

        // Make sure not to use obfuscated key
        if (strpos($settings['api_key'], '*') !== false) {
            $settings['api_key'] = $current['api_key'];
        }

        // Sanitize API key
        $settings['api_key'] = sanitize_text_field($settings['api_key']);

        // if API key changed, empty Mailchimp cache
        if ($settings['api_key'] !== $current['api_key']) {
        //    $mailchimp = new MC4WP_MailChimp();
        //    $mailchimp->refresh_lists();
        }

        /**
         * Runs right before general settings are saved.
         *
         * @param array $settings The updated settings array
         * @param array $current The old settings array
         */
        do_action('nekomc_save_settings', $settings, $current);

        return $settings;
    }

}
