<?php

namespace  plugin\calendar\consultations\asset;

class CalendarConsultationsAsset {

    private $name = 'calendar_consultations';

    public function __construct() {
        $this->plugin = PLUGIN_CALENDAR_PLUGIN_NAME . $this->name;
    }

    public function enqueue_styles() {

    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->name, PLUGIN_CALENDAR_CONSULTATIONS_URL . 'public/js/main.js', array( 'jquery' ), false, true);
    }
}