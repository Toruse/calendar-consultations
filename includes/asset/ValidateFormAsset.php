<?php

namespace  plugin\calendar\consultations\asset;

class ValidateFormAsset {

    private $name = 'validate_form';

    public function __construct() {
        $this->plugin = PLUGIN_CALENDAR_PLUGIN_NAME . $this->name;
    }

    public function enqueue_styles() {

    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->name, PLUGIN_CALENDAR_CONSULTATIONS_URL . 'public/js/validate/jquery.validate.min.js', array( 'jquery' ), false, true);
        wp_enqueue_script($this->name.'_local_validate', PLUGIN_CALENDAR_CONSULTATIONS_URL . 'public/js/validate/localization/messages_de.min.js', array( 'jquery' ), false, true);
    }
}