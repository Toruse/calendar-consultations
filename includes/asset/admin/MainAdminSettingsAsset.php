<?php

namespace  plugin\calendar\consultations\asset\admin;

class MainAdminSettingsAsset {

    private $name = 'calendar_consultations';

    public function __construct() {
        $this->plugin = PLUGIN_CALENDAR_PLUGIN_NAME . $this->name;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->name, PLUGIN_CALENDAR_CONSULTATIONS_URL . 'public/css/jquery-ui.min.css', array(), false, 'all');
    }

    public function enqueue_scripts($hook) {
        wp_enqueue_script($this->name, PLUGIN_CALENDAR_CONSULTATIONS_URL . 'public/js/main-admin-settings.js', array( 'jquery', 'jquery-ui-tabs'), false, true);
    }
}