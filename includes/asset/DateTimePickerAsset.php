<?php

namespace  plugin\calendar\consultations\asset;

class DateTimePickerAsset {

    private $name = 'date_time_picker';

    public function __construct() {
        $this->name = PLUGIN_CALENDAR_PLUGIN_NAME . $this->name;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->name, PLUGIN_CALENDAR_CONSULTATIONS_URL . 'public/css/jquery.datetimepicker.min.css', array(), false, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->name, PLUGIN_CALENDAR_CONSULTATIONS_URL . 'public/js/jquery.datetimepicker.full.min.js', array( 'jquery' ), false, true);
    }
}
